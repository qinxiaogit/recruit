<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\Store;

class ConfAPIController extends AppBaseController
{
    public function banner()
    {
        $banner = [
            [
                "linkUrl" =>  'pages/home/job',
                "jumpType" => 2,
                "picUrl" => 'https://cdn.yunqirenli.com/banner/banner_01.jpeg',
                "id" => 6
            ],
            [
                "linkUrl" =>  'pages/home/job',
                "picUrl" => 'https://cdn.yunqirenli.com/banner/banner_02.png',
                "jumpType" => 2,
                "id" => 9
            ]
            ,
            [
                "linkUrl" => 'pages/home/job',
                "picUrl" => 'https://cdn.yunqirenli.com/banner/banner_03.png',
                "id" => 8,
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
