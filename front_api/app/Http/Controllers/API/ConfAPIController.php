<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;

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
}
