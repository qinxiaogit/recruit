<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobsAPIRequest;
use App\Http\Requests\API\UpdateJobsAPIRequest;
use App\Models\AppUser;
use App\Models\JobReportRecords;
use App\Models\Jobs;
use App\Models\Store;
use App\Repositories\AuditLogRepository;
use App\Repositories\JobsRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class JobsController
 * @package App\Http\Controllers\API
 */
class JobsAPIController extends AppBaseController
{
    /** @var  JobsRepository */
    private $jobsRepository;

    public function __construct(JobsRepository $jobsRepo)
    {
        $this->jobsRepository = $jobsRepo;
    }

    /**
     * Display a listing of the Jobs.
     * GET|HEAD /jobs
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $where = [];
        $jobs = $this->jobsRepository->all(
            $where,
            $request->get('skip'),
            $request->get('limit')
        );
        $items = $jobs->toArray();

        $storeIdArr = array_column($items, 'store_id');

        $stores = Store::whereIn('id', $storeIdArr)->get()->toArray();
        $storeMap = array_column($stores, null, 'id');

        foreach ($items as $key => $item) {
            $item['store'] = [
                'name' => $storeMap[$item['store_id']]['name'] ?? '',
                'logo' => $storeMap[$item['store_id']]['logo'] ?? '',
            ];
            $item['is_top'] = $item['is_top'] ? true : false;
            $items[$key] = $item;
        }

        $data = [
            'items' => $items,
            'total' => Jobs::where($where)->count(),
        ];
        return $this->sendResponse($data, 'Jobs retrieved successfully');
    }

    /**
     * Store a newly created Jobs in storage.
     * POST /jobs
     *
     * @param CreateJobsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateJobsAPIRequest $request)
    {
        $input = $request->all();
        $storeId = auth()->user()->store_id;

        $input['store_id'] = $storeId;

        $jobs = $this->jobsRepository->create($input);

        return $this->sendResponse($jobs->toArray(), 'Jobs saved successfully');
    }

    /**
     * Display the specified Jobs.
     * GET|HEAD /jobs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Jobs $jobs */
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            return $this->sendError('Jobs not found');
        }

        return $this->sendResponse($jobs->toArray(), 'Jobs retrieved successfully');
    }

    /**
     * Update the specified Jobs in storage.
     * PUT/PATCH /jobs/{id}
     *
     * @param int $id
     * @param UpdateJobsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Jobs $jobs */
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            return $this->sendError('Jobs not found');
        }

        $jobs = $this->jobsRepository->update($input, $id);

        return $this->sendResponse($jobs->toArray(), 'Jobs updated successfully');
    }

    /**
     * Remove the specified Jobs from storage.
     * DELETE /jobs/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Jobs $jobs */
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            return $this->sendError('Jobs not found');
        }

        $jobs->delete();

        return $this->sendSuccess('Jobs deleted successfully');
    }

    /**
     * @param Request $request
     * @return
     */
    public function report(Request $request)
    {
        $where = [];
        $status = $request->post('status');
        if ($status > 0) {
            $where['status'] = $status;
        }
        $jobId = $request->post('job_id');
        if ($jobId) {
            $where['job_id'] = $jobId;
        }
        $query = DB::table("job_report_records");
        if (!empty($where)) {
            $query = $query->where($where);
        }
        $skip = $request->post('skip');
        $limit = $request->post('limit');

        $items = $query->offset($skip)->limit($limit)->get()->toArray();
        $total = $query->count();


        $items = json_decode(json_encode($items), true);
        $storeIdArr = array_column($items, 'uid');

        $stores = AppUser::whereIn('id', $storeIdArr)->get()->toArray();

        $storeMap = array_column($stores, null, 'id');
        foreach ($items as $key => $item) {
            if (isset($storeMap[$item['uid']])) {
                $item['report_user'] = [
                    'avatar' => $storeMap[$item['uid']]['avatar'] ?? '',
                    'nickname' => $storeMap[$item['uid']]['nickname'] ?? '',
                    'mobile' => $storeMap[$item['uid']]['mobile'] ?? '',
                    'sex' => $storeMap[$item['uid']]['sex'] ?? '',
                ];
            }
            $items[$key] = $item;
        }

        return $this->sendResponse([
            'items' => $items,
            'total' => $total,
        ], "拉取成功");
    }

    /**
     * @param Request $request
     * @return
     */
    public function reportStatus(Request $request)
    {
        $reportId = $request->post('report_id');
        $status = $request->post('status');//1.录用，2.不录用
        $reason = $request->post('reason');

        DB::enableQueryLog();
        $res = DB::table("job_report_records")->where([
            "id" => $reportId,
            "status" => 0
        ])->update([
            'status' => $status,
            'reason' => $reason,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        return $this->sendResponse(['result' => $res, "sql" => DB::getQueryLog()], "操作成功");
    }
}
