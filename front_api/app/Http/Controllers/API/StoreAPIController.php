<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreAPIRequest;
use App\Http\Requests\API\UpdateStoreAPIRequest;
use App\Models\BalanceLog;
use App\Models\Store;
use App\Models\StoreAccount;
use App\Repositories\AuditLogRepository;
use App\Repositories\StoreAccountRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Response;

/**
 * Class StoreController
 * @package App\Http\Controllers\API
 */
class StoreAPIController extends AppBaseController
{
    /** @var  StoreRepository */
    private $storeRepository;
    protected $storeAdminRepository;

    public function __construct(StoreRepository $storeRepo, StoreAccountRepository $storeAccountRepo)
    {
        $this->storeRepository = $storeRepo;
        $this->storeAdminRepository = $storeAccountRepo;
    }

    public function index(){
        return $this->sendResponse([],'success');
    }
    /**
     * Store a newly created Store in storage.
     * POST /stores
     *
     * @param CreateStoreAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStoreAPIRequest $request)
    {
        $logoArr = json_decode($request->post('logoList'),true);
        $busList = json_decode($request->post('busList'),true);
        $pictureArr= json_decode($request->post('picture_arr'),true);
        $username= $request->post('username');

        $storeData = [
            'name' => $request->post('store_name'),
            'logo' => $logoArr[0]['url'] ?? '',
            'business_license' => $busList[0]['url'] ?? '',
            'contact' =>$request->post('contact'),
            'album'   => json_encode(array_column($pictureArr,'url')),
            'uid'     => auth()->user()->id,
        ];
        //判断当前用户是否已注册账号
        $store = Store::where(['uid'=>auth()->user()->id])->first();
        if(!empty($store)){
            return $this->sendError('该用户已经注册了店铺不可重复注册');
        }
        //检查账号是否存在
        $storeAccount = StoreAccount::where(['username'=>$username])->first();
        if(!empty($storeAccount)){
            return $this->sendError('该账号已存在，请切换账号重试');
        }
        $store = $this->storeRepository->create($storeData);
        //保存成功-生成店铺账号信息
        if ($store->save()) {
            $storeAccount = $this->storeAdminRepository->create([
                'username' => $username,
                'password' => Hash::make($request->post('password')),
            ]);
            $storeAccount->save();
        }

        return $this->sendResponse($store->toArray(), 'Store saved successfully');
    }

    /**
     * Display the specified Store.
     * GET|HEAD /stores/{id}
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $id = auth()->user()->store_id;
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        return $this->sendResponse($store->toArray(), 'Store retrieved successfully');
    }

    /**
     * Update the specified Store in storage.
     * PUT/PATCH /stores/{id}
     *
     * @param int $id
     * @param UpdateStoreAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStoreAPIRequest $request)
    {
        $input = $request->all();

        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $store = $this->storeRepository->update($input, $id);

        return $this->sendResponse($store->toArray(), 'Store updated successfully');
    }

    /**
     * Remove the specified Store from storage.
     * DELETE /stores/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Store $store */
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            return $this->sendError('Store not found');
        }

        $store->delete();

        return $this->sendSuccess('Store deleted successfully');
    }

    /**
     * @desc 审核
     * @param Request $request
     * @return
     * @throws \Exception
     */
    public function audit(Request $request)
    {
        $store = $this->storeRepository->find($request->post("id"));

        $reason = $request->post('reason');
        $status = $request->post('status');

        if (empty($store)) {
            return $this->sendError('商户数据异常');
        }
        if ($store->status !== 0) {
            return $this->sendError("商户已审核了");
        }
        //审核驳回结果
        $store->status = $status ? 2 : 1;
        if ($store->save()) {
            $adminLogRepository = new AuditLogRepository(app());
            $adminLogRepository->create([
                'reason' => $reason,
                'result' => $status,
                'uid' => auth()->id(),
            ]);
        }
        return $this->sendResponse([], "操作成功");
    }

    /**
     * @param Request $request
     * @desc 商户状态变更
     * @return mixed
     */
    public function status(Request $request)
    {
        $store = $this->storeRepository->find($request->post("id"));
        $option = $request->post('option');

        if (empty($store)) {
            return $this->sendError('商户数据异常');
        }
        switch ($option) {
            case "up":
                $store->status = 1;
                break;
            case "down":
                $store->status = 2;
                break;
        }

        $store->save();
        return $this->sendResponse([], "操作成功");
    }

    /**
     * @param Request $request
     * @desc 余额变更
     * @return
     */
    public function balance(Request $request)
    {
        $amount = $request->post('amount');//变更金额
        $direction = $request->post('direction');//变更方向.1新增，2.扣除
//        $source = $request->post('source');//来源：1.管理员
        $reason = $request->post('reason');//变更原因
        $storeId = $request->post("store_id");

        $store = $this->storeRepository->find($storeId);
        if (empty($store)) {
            return $this->sendError('商户数据异常');
        }
        if ($amount <= 0) {
            return $this->sendError('操作金额异常');
        }
        if ($direction == 2 && $amount > $store->balance) {//扣除不够
            return $this->sendError('余额不足');
        }

        //先写日志
        $balance = new BalanceLog();
        $balance->amount = $amount;
        $balance->direction = $direction;
        $balance->reason = $reason;
        $balance->uid = auth()->id();
        $balance->source = 1;
        if ($balance->save()) {
            if ($direction == 1) {
                DB::table('stores')->where('id', '=', $storeId)->increment('balance', $amount);

            } else {
                DB::table('stores')->where('id', '=', $storeId)->decrement('balance', $amount);
            }
        }
        return $this->sendResponse([$store->balance], "操作成功");

    }

    public function me(){
        $uid = auth()->user()->id;
        $store = Store::where(['uid'=>$uid])->first();
        if(empty($store)){
            return $this->sendResponse(null,'成功');
        }
        $storeArr = $store->toArray();
        $storeArr['album'] = json_decode($storeArr['album'],true);
        return $this->sendResponse($storeArr,'成功');
    }
}
