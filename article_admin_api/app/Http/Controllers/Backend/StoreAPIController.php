<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class StoreAPIController
 * @package App\Http\Controllers\API
 * @desc 店铺列表
 */
class StoreAPIController extends AppBaseController
{
    /**
     * @param Request $request
     * @desc 拉取商户列表
     * @return
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $offset = $request->get('offset');

        $query = DB::table("stores");
        $data = $query->offset($offset)->limit($limit)->get()->toArray();
        $total = $query->count();

        $result = [
            'items'=>$data,
            'total'=>$total
        ];
        return $this->sendResponse($result,"拉取成功");
    }
}
