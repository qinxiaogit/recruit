<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStoreAPIRequest;
use App\Http\Requests\API\UpdateStoreAPIRequest;
use App\Models\BalanceLog;
use App\Models\Store;
use App\Repositories\AuditLogRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class StoreController
 * @package App\Http\Controllers\API
 */
class StoreAPIController extends AppBaseController
{
    /** @var  StoreRepository */
    private $storeRepository;

    public function __construct(StoreRepository $storeRepo)
    {
        $this->storeRepository = $storeRepo;
    }

    /**
     * Display a listing of the Store.
     * GET|HEAD /stores
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $where = [];
        $name = $request->post('name');
        $status = $request->post('status');
        if (!empty($name)) {
            $where['name'] = $name;
        }
        if (intval($status) !== -1) {
            $where['status'] = intval($status);
        }
        $stores = $this->storeRepository->all(
            $where,
            $request->post('skip'),
            $request->post('limit')
        );
        $data = [
            'items' => $stores->toArray(),
            'total' => Store::where($where)->count(),
        ];
        return $this->sendResponse($data, 'Stores retrieved successfully');
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
        $input = $request->all();

        $store = $this->storeRepository->create($input);

        return $this->sendResponse($store->toArray(), 'Store saved successfully');
    }

    /**
     * Display the specified Store.
     * GET|HEAD /stores/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
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
        if($amount<=0){
            return $this->sendError('操作金额异常');
        }
        if($direction == 2 && $amount>$store->balance) {//扣除不够
            return $this->sendError('余额不足');
        }

        //先写日志
        $balance = new BalanceLog();
        $balance->amount = $amount;
        $balance->direction = $direction;
        $balance->reason = $reason;
        $balance->uid = auth()->id();
        $balance->source = 1;
        if($balance->save()){
            if ($direction == 1){
                DB::table('stores')->where('id','=',$storeId)->increment('balance',$amount);

            }else{
                DB::table('stores')->where('id','=',$storeId)->decrement('balance',$amount);
            }
        }
        return $this->sendResponse([$store->balance], "操作成功");

    }
}
