<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use App\Models\Conf;
use Illuminate\Http\Request;

class ConfController extends AppBaseController
{
    const BANNER_CONF_KEY = 'banner_list';
    const BLOCK_CONF_KEY = 'block_list';
    const DEVELOP_CONF_KEY = 'develop_list';
    const COURSE_CONF_KEY = 'course_list';

    public function saveArr(Request $request)
    {
//        $img = $request->post('img');
//        $jumpType = $request->post('jump_type');
//        $url = $request->post('url');
        $oneData = $request->post('value');
        $key = $request->post('key', self::BANNER_CONF_KEY);

        $model = Conf::where(['key' => $key])->first();
        $value = [];
        if (empty($model)) {
            $model = new Conf();
            $model->key = $key;
        } else {
            $value = json_decode($model->value, true);
        }
        $value[] = $oneData;
        $model->value = json_encode($value);
        if (!$model->save()) {
            return $this->sendError('保存失败');
        }
        return $this->sendSuccess('成功');
    }

    /**
     * @desc 配置
     */
    public function show()
    {
        $confBanner = $model = Conf::whereIn('key', [self::BANNER_CONF_KEY, self::BLOCK_CONF_KEY,
            self::DEVELOP_CONF_KEY, self::COURSE_CONF_KEY
        ])->get();

        $data =  [];
        foreach ($confBanner  as $item){
            $data[$item->key] = json_decode($item->value,true);
        }
        return $this->sendResponse($data);
    }
}
