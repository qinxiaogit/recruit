<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\AppUser;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitysAPIController extends AppBaseController
{
    public function index(Request $request)
    {
        $where = [];
        $keyword = $request->get('keyword');
        $skip = $request->get('skip');
        $limit = $request->get('limit');
        if (!empty($keyword)) {
            $where['keyword'] = $keyword;
        }

        $items = DB::table("citys")
            ->where($where)
            ->orderBy('id', 'desc')
            ->offset($skip)
            ->limit($limit)
            ->get()
            ->toArray();

        $data = [
            'items' => $items,
            'total' => City::where($where)->count(),
        ];
        return $this->sendResponse($data, 'App Users retrieved successfully');
    }

    /**
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {
        $name = $request->post('name');
        $index = $request->post('index');
        $key = $request->post('key');

        $city = new City();
        $city->name = $name;
        $city->index = $index;
        $city->key = $key;
        if (!$city->save()) {
            return $this->sendError('保存失败');
        }
        return $this->sendSuccess('');
    }

    /**
     * @param Request $request
     * @return
     */
    public function delete(Request $request)
    {
        $id = $request->post('id');
        $city = City::where(['id' => $id])->first();
        if (!$city->delete()) {
            return $this->sendError('保存失败');
        }
        return $this->sendSuccess('');
    }
}
