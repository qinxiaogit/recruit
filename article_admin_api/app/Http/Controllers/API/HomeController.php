<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;

class HomeController extends AppBaseController
{
    /**
     * @OA\Get(
     *     path="api/v1/front/home/init",
     *     summary="首页初始化",
     *     operationId="initSystem",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function init()
    {
        $data = [
            'banner_list' => [
                [
                    'img' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'jump_type' => 'url',
                    'url' => 'http://www.baidu.com'
                ],
                [
                    'img' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'jump_type' => 'page',
                    'url' => '/page/home/index'
                ]
            ],
            'block_list' => [
                [
                    'img' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'jump_type' => 'url',
                    'url' => 'http://www.baidu.com',
                    'display' => 'half',
                ],
                [
                    'img' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'jump_type' => 'url',
                    'url' => 'http://www.baidu.com',
                    'display' => 'line',
                ],
            ],
            'store_list' => [
                [
                    'avatar' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'address' => "成都市高新区金科东方雅郡",
                    'long' => 104.09030,
                    'lat' => 30.63777,
                    'label' => '四川高新店'
                ],
                [
                    'avatar' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                    'address' => "成都市龙泉驿区保利紫薇花语",
                    'long' => 104.07275,
                    'lat' => 30.57899,
                    'label' => '四川龙泉店'
                ]
            ]
        ];
        return $this->sendResponse($data,'获取成功');
    }

}
