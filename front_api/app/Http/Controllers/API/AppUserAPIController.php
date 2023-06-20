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
            $where['nickname'] = $request->get('nickname');
        }
        DB::enableQueryLog();

        $sourceType = $request->get('source_type');
        if($sourceType){
            switch ($sourceType){
                case "today_register":
                    $where['>'] = '> '.date("Y-m-d")." 00:00:00";
                    break;
            }
        }

        $appUsers = $this->appUserRepository->all(
            $where,
            $request->get('skip'),
            $request->get('limit')
        );
        $items = $appUsers->toArray();

        $storeIdArr = array_column($items, 'invite_uid');

        $stores = AppUser::whereIn('id', $storeIdArr)->get()->toArray();
        $storeMap = array_column($stores, null, 'id');

        foreach ($items as $key => $item) {
            if(isset($storeMap[$item['invite_uid']])){
                $item['invite_user'] = [
                    'avatar' => $storeMap[$item['invite_uid']]['avatar'] ?? '',
                    'nickname' => $storeMap[$item['invite_uid']]['nickname'] ?? '',
                ];
            }
            $items[$key] = $item;
        }

        $data = [
            'items' => $items,
            'total' => AppUser::where($where)->count(),
            'where'=>DB::getQueryLog()
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
}
