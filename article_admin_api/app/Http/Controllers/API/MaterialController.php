<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Request;

class MaterialController extends AppBaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/front/material/market",
     *     summary="营销素材分类",
     *     operationId="materialMarket",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function market()
    {
        $data = [
            [
                'label' => '线上运营',
                'id' => 1,
                'tags' => [
                    [
                        'label' => '早安日签',
                        'id' => 1
                    ],
                    [
                        'label' => '护肤知识',
                        'id' => 2
                    ]
                ]
            ],
            [
                'label' => '朋友圈打造',
                'id' => 2,
                'tags' => [
                    [
                        'label' => '早安日签',
                        'id' => 1
                    ],
                    [
                        'label' => '护肤知识',
                        'id' => 2
                    ]
                ]
            ]
        ];
        return $this->sendResponse($data, '营销素材');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/front/material/circle",
     *     summary="营销素材圈",
     *     operationId="courseListCategory",
     *     @OA\Parameter(
     *         name="cate_id",
     *         in="query",
     *         description="分类id-默认0",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="tag_id",
     *         in="query",
     *         description="子标签id",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page for 分页",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=true,
     *         description="The limit for 分页尺寸",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function circle()
    {
        $data = [
            [
                'author' => '设计部',
                'avatar' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'push_date' => "2022-06-28",
                'content' => 'hello world',
                'img' => [
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg'
                ],
                'id' => 1,
                'collect_status' => 1,
            ],
            [
                'author' => '设计部2',
                'avatar' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'push_date' => "2022-06-28",
                'content' => 'hello world 2',
                'img' => [
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg'
                ],
                'id' => 2,
                'collect_status' => 0
            ]
        ];
        return $this->sendResponse($data, '营销素材');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/front/material/collect",
     *     summary="营销素材收藏",
     *     operationId="collectMShowCategory",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="话术id",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function collect(Request $request)
    {
       return $this->sendResponse([], "收藏成功");
    }
    /**
     * @OA\Get(
     *     path="/api/v1/front/material/collectList",
     *     summary="营销素材收藏列表",
     *     operationId="collectListCategory",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page for 分页",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=true,
     *         description="The limit for 分页尺寸",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function collectList(){
        $data = [
            [
                'author' => '设计部',
                'avatar' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'push_date' => "2022-06-28",
                'content' => 'hello world',
                'img' => [
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg'
                ],
                'id' => 1,
                'collect_status' => 1,
            ],
            [
                'author' => '设计部2',
                'avatar' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'push_date' => "2022-06-28",
                'content' => 'hello world 2',
                'img' => [
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                    'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg'
                ],
                'id' => 2,
                'collect_status' => 0
            ]
        ];
        return $this->sendResponse($data, '营销素材');
    }
}
