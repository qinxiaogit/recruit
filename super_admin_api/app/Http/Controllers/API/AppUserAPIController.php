<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppUserAPIRequest;
use App\Http\Requests\API\UpdateAppUserAPIRequest;
use App\Models\AppUser;
use App\Models\Jobs;
use App\Models\Store;
use App\Repositories\AppUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\Hash;


/**
 * Class AppUserController
 * @package App\Http\Controllers\API
 */

class AppUserAPIController extends AppBaseController
{
    /** @var  AppUserRepository */
    private $appUserRepository;

    public function __construct(AppUserRepository $appUserRepo)
    {
        $this->appUserRepository = $appUserRepo;
    }

    /**
     * Display a listing of the AppUser.
     * GET|HEAD /appUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $where = [];

        if($request->get("nickname")){
            $where['mobile'] = $request->get('nickname');
        }
//        DB::enableQueryLog();
        $query = DB::table("app_user");
        if(!empty($where)){
            $query->where($where);
        }

        $sourceType = $request->get('source_type');
        if($sourceType){
            switch ($sourceType){
                case "today_register":
                    $query->whereBetween('created_at',[
                        date("Y-m-d H:i:s",strtotime("00:00:00")),
                        date("Y-m-d H:i:s",strtotime("+1 day 00:00:00")),
                    ]);
                    break;
                case "today_create":
                    $query->whereBetween('active_time',[
                        date("Y-m-d H:i:s",strtotime("00:00:00")),
                        date("Y-m-d H:i:s",strtotime("+1 day 00:00:00")),
                    ]);
                    break;
            }
        }
        $skip = $request->post('skip',0);
        $limit = $request->post('limit',10);
        $total = $query->count();
        $items = $query->orderByDesc('id')->offset($skip)->limit($limit)->get("app_user.*")->toArray();

        $items = json_decode(json_encode($items),true);

        $storeIdArr = array_column($items, 'invite_uid');

        $stores = AppUser::whereIn('id', $storeIdArr)->get()->toArray();
        $storeMap = array_column($stores, null, 'id');
        foreach ($items as $key => $item) {
            if(!empty($storeMap) && isset($storeMap[$item['invite_uid']])){
                $item['invite_user'] = [
                    'avatar' => $storeMap[$item['invite_uid']]['avatar'] ?? '',
                    'nickname' => $storeMap[$item['invite_uid']]['nickname'] ?? '',
                    'real_name' => $storeMap[$item['invite_uid']]['real_name'] ?? '',
                    'mobile' => $storeMap[$item['invite_uid']]['mobile'] ?? '',
                ];
            }
            $item['age'] = empty($item['birthday'])?"-":(date("Y") - date("Y",strtotime($item['birthday'])));
            $items[$key] = $item;
        }

        $data = [
            'items' => $items,
            'total' => $total,
//            'where'=>DB::getQueryLog()
        ];
        return $this->sendResponse($data, 'App Users retrieved successfully');
    }

    /**
     * Store a newly created AppUser in storage.
     * POST /appUsers
     *
     * @param CreateAppUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppUserAPIRequest $request)
    {
        $input = $request->all();

        $appUser = $this->appUserRepository->create($input);

        return $this->sendResponse($appUser->toArray(), 'App User saved successfully');
    }

    /**
     * Display the specified AppUser.
     * GET|HEAD /appUsers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->find($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        return $this->sendResponse($appUser->toArray(), 'App User retrieved successfully');
    }

    /**
     * Update the specified AppUser in storage.
     * PUT/PATCH /appUsers/{id}
     *
     * @param int $id
     * @param UpdateAppUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->find($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        $appUser = $this->appUserRepository->update($input, $id);

        return $this->sendResponse($appUser->toArray(), 'AppUser updated successfully');
    }

    /**
     * Remove the specified AppUser from storage.
     * DELETE /appUsers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->find($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        $appUser->delete();

        return $this->sendSuccess('App User deleted successfully');
    }

    public function agent(Request $request){
        $uid = $request->post("uid");
        $password = $request->post("password");
        $status = intval($request->post("status"));
        DB::table('app_user')->where(['id' => $uid])->update(['is_open_agent'=>$status,'agent_password'=>Hash::make($password)]);
        return $this->sendResponse("","操作成功");
    }
    public function dashboash(Request $request){
        $uid = $request->post("uid");
        $data = DB::table('promotion_job as pj')
            ->leftJoin("jobs as j","pj.view_id",'=','j.id')
            ->leftJoin("stores as s","s.id",'=','j.store_id')
            ->where("pj.uid",'=',$uid)
            ->select("pj.*","j.name as job_name","s.name as store_name","s.logo")
            ->get()->toArray();
        return $this->sendResponse($data,"操作成功");
    }
}
