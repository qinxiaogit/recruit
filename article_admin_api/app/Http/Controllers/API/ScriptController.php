<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Request;

class ScriptController extends AppBaseController
{
    /**
     * @OA\Get(
     *     path="api/v1/front/script/category",
     *     summary="课程分类",
     *     operationId="courseListCategory",
     *     @OA\Parameter(
     *         name="parent_id",
     *         in="query",
     *         description="分类id-默认0",
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
    public function category(Request $request)
    {
        $data = [
            [
                'label' => '预约接待话术',
                'id' => 1,
            ],
            [
                'label' => '护理沟通话术',
                'id' => 2,
            ]
        ];
        return $this->sendResponse($data, '获取成功');
    }

    /**
     * @OA\Get(
     *     path="api/v1/front/script/show",
     *     summary="话术详情",
     *     operationId="courseShowCategory",
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
    public function show(Request $request)
    {
        $data = [
            'id' => 1,
            'content' => [
                '你好，这你是，',
                '您想预约什么时间呢',
                '您是第一次来我们店吗？'
            ],
            'collect_status' => 1,
        ];
        $this->sendResponse($data, "话术详情");
    }

    /**
     * @OA\Get(
     *     path="api/v1/front/script/collect",
     *     summary="话术收藏",
     *     operationId="collectShowCategory",
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
        $this->sendResponse([], "收藏成功");
    }

    /**
     * @OA\Get(
     *     path="api/v1/front/script/collectList",
     *     summary="话术收藏列表",
     *     operationId="collect2ListCategory",
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
    public function collectList()
    {
        $data = [
            [
                'id' => 1,
                'label' => '你好话术',
                'content' => [
                    '你好，这你是，',
                    '您想预约什么时间呢',
                    '您是第一次来我们店吗？'
                ],
                'collect_status' => 1,],
            [
                'id' => 2,
                'label' => '你好话术2',
                'content' => [
                    '你好，这你是2，',
                    '您想预约什么时间呢2',
                    '您是第一次来我们店吗2？'
                ],
                'collect_status' => 1,]
        ];
        $this->sendResponse($data, "话术详情");
    }
}
