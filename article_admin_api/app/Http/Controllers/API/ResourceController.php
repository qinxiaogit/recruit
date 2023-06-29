<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;

/**
 * Class ResourceController
 * @package App\Http\Controllers\API
 * @desc 店铺物料
 */
class ResourceController extends AppBaseController
{
    /**
     * @OA\Get(
     *     path="api/v1/front/resource/list",
     *     summary="店铺物料",
     *     operationId="courseList222Category",
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="搜索",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         description="父级id",
     *         required=true,
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
    public function index()
    {
        $data = [
            [
                "label" => '月度数据报表.xlsx',
                'desc' => '2022-12-06 26k 来自售后部-田灵',
                'mod' => 'file',
                'content' => "https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg",
                'file_type' => 'word'
            ],
            [
                "label" => '设计板块',
                'desc' => 'LOGO源文件',
                'mod' => 'dir',
            ]
        ];
        $this->sendResponse($data, 'success');
    }
}
