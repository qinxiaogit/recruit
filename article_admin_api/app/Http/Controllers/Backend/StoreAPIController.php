<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use App\Models\Store;
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
        $query->whereNull('deleted_at');
        $data = $query->offset($offset)->limit($limit)->get()->toArray();
        $total = $query->count();

        $result = [
            'items' => $data,
            'total' => $total
        ];
        return $this->sendResponse($result, "拉取成功");
    }

    /**
     * @param Request $request
     * @return
     */
    public function save(Request $request)
    {
        $address = $request->post('address');
        $avatar = $request->post('avatar');
        $label = $request->post('label');
        $lang = $request->post('lang');
        $lat = $request->post('lat');
        $id = $request->post('id');

        if (empty($avatar) || empty($lat) || empty($address) || empty($lang) || empty($label)) {
            return $this->sendError('资料不完整');
        }
        if (empty($id)) {
            $storeModel = new Store();
        } else {
            $storeModel = Store::find($id);
        }
        $storeModel->address = $address;
        $storeModel->avatar = $avatar;
        $storeModel->label = $label;
        $storeModel->lang = $lang;
        $storeModel->lat = $lat;
        if ($storeModel->save()) {
            return $this->sendSuccess('操作成功');
        }
        return $this->sendError('保存失败');
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $model = Store::find($id);
        if (empty($model)) {
            return $this->sendError('保存失败');
        }
        $model->delete();
        return $this->sendSuccess('操作成功');
    }

    /**
     * @param Request $request
     * @return
     */
    public function show(Request $request)
    {
        $id = $request->post('id');
        $model = Store::find($id);
        return $this->sendResponse($model);
    }
}
