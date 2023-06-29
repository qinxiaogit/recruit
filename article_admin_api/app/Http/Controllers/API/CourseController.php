<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class CourseController extends AppBaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/front/course/category",
     *     summary="课程分类",
     *     operationId="courseCategory",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function category()
    {
        $data = [
            [
                'label' => '培训课程',
                'id' => 1,
                'key' => 'course'
            ],
            [
                'label' => '经营话术',
                'id' => 2,
                'key' => 'script'
            ]
        ];
        return $this->sendResponse($data, '获取成功');

    }

    /**
     * @OA\Get(
     *     path="/api/v1/front/course/init",
     *     summary="课程初始化",
     *     operationId="courseInitCategory",
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
            [
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
                'course_zone' => [
                    [
                        'label' => '老板学习区',
                        'desc' => '老板学习区',
                        'display' => 2,
                        'jump' => '/page/course/index',
                        'cate_id' => 1,
                    ],
                    [
                        'label' => '店长学习区',
                        'desc' => '店长学习区',
                        'display' => 2,
                        'jump' => '/page/course/index',
                        'cate_id' => 2,
                    ]
                ]
            ]
        ];
        return $this->sendResponse($data, '拉取成功');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/front/course/list",
     *     summary="课程分类",
     *     operationId="courseListCategory",
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
     *     @OA\Parameter(
     *         name="cate_id",
     *         in="query",
     *         description="分类id",
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
    public function index(Request $request)
    {
        $data = [
            [
                'course_type' => 'video',
                'cover' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'title' => '第一篇视频',
                'author' => "测试",
                'play_count' => 120,
                'id' => 1,
            ],
            [
                'course_type' => 'video',
                'cover' => 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
                'title' => '第二篇视频',
                'author' => "测试",
                'play_count' => 120,
                'id' => 2,
            ]
        ];
        return $this->sendResponse($data, "课程获取成功");
    }
}
