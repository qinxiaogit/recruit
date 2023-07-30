<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\Store;

class ConfAPIController extends AppBaseController
{
    public function banner()
    {
        $banner = [
            ["linkUrl" => 'http://y.qq.com/w/album.html?albummid=0044K2vN1sT5mE',
                "jumpType" => 1,
                "picUrl" => 'http://y.gtimg.cn/music/photo_new/T003R720x288M000001YCZlY3aBifi.jpg',
                "id" => 11351
            ],
            [
                "linkUrl" => 'https://y.qq.com/m/digitalbum/gold/index.html?_video=true&id=2197820&g_f=shoujijiaodian',
                "picUrl" => 'http://y.gtimg.cn/music/photo_new/T003R720x288M000004ckGfg3zaho0.jpg',
                "jumpType" => 1,
                "id" => 11372
            ]
            ,
            [
                "linkUrl" => '/pages/logs',
                "picUrl" => 'http://y.gtimg.cn/music/photo_new/T003R720x288M00000236sfA406cmk.jpg',
                "id" => 11378,
                "jumpType" => 2
            ]
        ];
        return $this->sendResponse($banner, '获取成功');
    }

    /**
     * @return mixed
     */
    public function stat()
    {
        $data = [
            'join_num' => intval(time() / 60),
            'push_money' => intval(time() / 60) + intval(time() / 3600) * 5,
        ];
        return $this->sendResponse($data, '获取成功');
    }

    public function protocol()
    {
        $data = [
            'user_protocol'    =>  'https://cdn.yunqirenli.com/document/%E7%BD%91%E8%81%8C%E5%85%BC%E8%81%8C_%E7%94%A8%E6%88%B7%E5%8D%8F%E8%AE%AE.pdf',
            'privacy_protocol' => 'https://cdn.yunqirenli.com/document/%E7%BD%91%E8%81%8C%E5%85%BC%E8%81%8C_%E9%9A%90%E7%A7%81%E5%8D%8F%E8%AE%AE.pdf',
            'temp_job_protocol' =>'https://cdn.yunqirenli.com/document/%E7%BD%91%E8%81%8C%E5%85%BC%E8%81%8C_%E5%85%BC%E8%81%8C%E5%8D%8F%E8%AE%AE.pdf'
        ];
        return $this->sendResponse($data, '获取成功');
    }
}
