<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobsAPIRequest;
use App\Http\Requests\API\UpdateJobsAPIRequest;
use App\Models\AuditRecord;
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

        $jobsIds=  array_column($items, 'id');
        $auditRecord = AuditRecord::whereIn('origin_id',$jobsIds)->where('source',1)->get()->toArray();
        $auditRecordMap = array_column($auditRecord,null,'origin_id');

        foreach ($items as $key => $item) {
            $item['store'] = [
                'name' => $storeMap[$item['store_id']]['name'] ?? '',
                'logo' => $storeMap[$item['store_id']]['logo'] ?? '',
            ];
            if(isset($auditRecordMap[$item['id']])){
                $item['audit_log'] =  [
                    'extra'=> json_decode($auditRecordMap[$item['id']]['extra'],true)
                ];
            }
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
        $audit = AuditRecord::where('origin_id',$id)->orderBy('id','desc')->first();

        if ($audit) {
            $extra = json_decode($audit->extra, true);
            if (isset($input['status']) && $input['status'] == 1) {
                $input['name'] = $extra['name'] ?? "";
                $input['work_content'] = $extra['work_content'] ?? '';
            }
            AuditRecord::where('origin_id',$id)->delete();
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
     * @desc 分享
     */
    public function share(Request $request){
        $jobId = $request->post('job_id');
        $mobile = $request->post('mobile');
        if(empty($jobId)){
            return $this->sendError('Jobs not found');
        }
        $inviteCode = "";
        if(!empty($mobile)){
            $user = DB::table("app_user")->where(['mobile'=>$mobile])->first();
            if(empty($user)){
                return $this->sendError('该手机号未注册');
            }
            $inviteCode = $user->invite_code;
        }
        $source= $request->post('source','job');
        $token = 'asdmasaskdajdmkaskmasmkasdmksdamkdskmsdkmdsmkcdsike9i38927y802';
        $data = file_get_contents("https://api.yunqirenli.com/api/v1/public/share?id={$jobId}&invite_code={$inviteCode}&token={$token}&source={$source}");
        $dataArr = json_decode($data,true);
        return $this->sendResponse(  $dataArr['data']??'','Jobs updated successfully');
    }
}
