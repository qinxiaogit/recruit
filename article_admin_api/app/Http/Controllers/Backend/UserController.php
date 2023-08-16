<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\AppBaseController;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UserController extends AppBaseController
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
        $keyword = $request->get('keyword');

        $query = DB::table("app_user");
        if (!empty($keyword)) {
            $query->where('mobile', '=', $keyword);
        }

        $query->whereNull('deleted_at');
        $data = $query->offset($offset)->limit($limit)->get()->toArray();
        $total = $query->count();

        foreach ($data as $key => $item) {
            $item->active_time = empty($item->active_time) ? "-" : date("Y-m-d H:i:s", $item->active_time);
            $data[$key] = $item;
        }

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
        $realName = $request->post('real_name');
        $mobile = $request->post('mobile');
        $id = $request->post('id');

        if (empty($realName) || empty($mobile)) {
            return $this->sendError('资料不完整');
        }
        if (empty($id)) {
            $storeModel = new AppUser();
        } else {
            $storeModel = AppUser::find($id);
        }
        $storeModel->real_name = $realName;
        $storeModel->mobile = $mobile;
        if ($storeModel->save()) {
            return $this->sendSuccess('操作成功');
        }
        return $this->sendError('保存失败');
    }

    /**
     * @param Request $request
     * @return
     */
    public function show(Request $request)
    {
        $id = $request->post('id');
        $model = AppUser::find($id);
        return $this->sendResponse($model);
    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        $model = AppUser::find($id);
        if (empty($model)) {
            return $this->sendError('保存失败');
        }
        $model->delete();
        return $this->sendSuccess('操作成功');
    }
}
