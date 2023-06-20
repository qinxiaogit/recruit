<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobCateAPIRequest;
use App\Http\Requests\API\UpdateJobCateAPIRequest;
use App\Models\JobCate;
use App\Models\Jobs;
use App\Repositories\JobCateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class JobCateController
 * @package App\Http\Controllers\API
 */
class JobCateAPIController extends AppBaseController
{
    /** @var  JobCateRepository */
    private $jobCateRepository;

    public function __construct(JobCateRepository $jobCateRepo)
    {
        $this->jobCateRepository = $jobCateRepo;
    }

    /**
     * Display a listing of the JobCate.
     * GET|HEAD /jobCates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $where = [];
        $jobCates = $this->jobCateRepository->all(
            $where,
            $request->get('skip'),
            $request->get('limit')
        );

        $data = [
            'items' => $jobCates->toArray(),
            'total' => JobCate::where($where)->count(),
        ];

        return $this->sendResponse($data, 'Job Cates retrieved successfully');
    }

    public function all(Request $request)
    {
        $where = [
            'level' => 1,
        ];
        $jobCates = $this->jobCateRepository->all($where)->toArray();

        array_unshift($jobCates, ['name' => "根", 'id' => 0]);
        return $this->sendResponse($jobCates, 'Job Cates retrieved successfully');
    }

    /**
     * Store a newly created JobCate in storage.
     * POST /jobCates
     *
     * @param CreateJobCateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateJobCateAPIRequest $request)
    {
        $input = $request->all();
        $input['level'] = $input['parent_id'] ? 2 : 1;


        $jobCate = $this->jobCateRepository->create($input);

        return $this->sendResponse($jobCate->toArray(), 'Job Cate saved successfully');
    }

    /**
     * Display the specified JobCate.
     * GET|HEAD /jobCates/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var JobCate $jobCate */
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            return $this->sendError('Job Cate not found');
        }

        return $this->sendResponse($jobCate->toArray(), 'Job Cate retrieved successfully');
    }

    /**
     * Update the specified JobCate in storage.
     * PUT/PATCH /jobCates/{id}
     *
     * @param int $id
     * @param UpdateJobCateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobCateAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobCate $jobCate */
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            return $this->sendError('Job Cate not found');
        }

        $jobCate = $this->jobCateRepository->update($input, $id);

        return $this->sendResponse($jobCate->toArray(), 'JobCate updated successfully');
    }

    /**
     * Remove the specified JobCate from storage.
     * DELETE /jobCates/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var JobCate $jobCate */
        $jobCate = $this->jobCateRepository->find($id);

        if (empty($jobCate)) {
            return $this->sendError('Job Cate not found');
        }

        $jobCate->delete();

        return $this->sendSuccess('Job Cate deleted successfully');
    }

    public function tree()
    {
        $where = [];
        $jobCates = $this->jobCateRepository->all($where)->toArray();

        $data = [];
        $dataIndexMap = [];
        $index = 0;
        foreach ($jobCates as $cate) {
            if ($cate['parent_id'] > 0) {//子节点
                $data[$dataIndexMap[$cate['parent_id']]]['children'][] = [
                    'label' => $cate['name'],
                    'id' => $cate['id'],
                    'value' => $cate['id'],
                ];
            } else {//根节点
                $data[$index] = [
                    'label' => $cate['name'],
                    'id' => $cate['id'],
                    'value' => $cate['id'],
                ];
                $dataIndexMap[$cate['id']] = $index;
                $index++;
            }
        }
        return $this->sendResponse($data, 'JobCate updated successfully');

    }

    public function delete(Request $request)
    {

        JobCate::whereIn('id', $request->post('id_arr'))->delete();
        return $this->sendResponse($request->post("id_arr"), 'JobCate updated successfully');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function select(Request $request)
    {
        $parentId = intval($request->get("parent_id"));
        $where = [];
        $where['parent_id'] = $parentId;

        $data = JobCate::where($where)->all()->toArray();
        return $this->sendResponse($data, "获取成功");
    }
}
