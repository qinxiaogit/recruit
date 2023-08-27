<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJobsAPIRequest;
use App\Http\Requests\API\UpdateJobsAPIRequest;
use App\Models\AppUser;
use App\Models\BalanceLog;
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
        $page = $request->get('page');
        $size = $request->get('size');
        $oneCateId = $request->get('one_cate_id');
        $query = DB::table("jobs AS j")->leftJoin("stores AS s", 'j.store_id', '=', 's.id')
            ->where('balance', '>', 0)
            ->where(['s.status' => 1])
            ->where(['j.status' => 1]);
        if (!empty($oneCateId)) {
            $query->where(['one_cate_id' => $oneCateId]);
        }
        $lists = $query->orderBy('is_top', 'desc')
            ->orderBy('sort', 'asc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get(["j.id", "is_top", "j.name", "unit", 'salary', "s.name as store_name", "report_count", "one_cate_id", "two_cate_id",'age_start'])
            ->toArray();

        $oneCateIdArr = array_column($lists, 'one_cate_id');
        $twoCateIdArr = array_column($lists, 'two_cate_id');

        $tagTypes = ['primary','success','danger','warning'];

        $cateIdArr = array_merge($oneCateIdArr, $twoCateIdArr);
        $catArr = [];
        if ($cateIdArr) {
            $catArr = DB::table("job_cate")->whereIn('id', $cateIdArr)->get(["id", "name"])->toArray();
            $catArr = array_column($catArr, 'name', 'id');
        }
        foreach ($lists as $key => $list) {
            $list = json_decode(json_encode($list), true);
            $tags = [];
            $tags[] = [
                'id'=>-2,
                'name'=>$list['store_name'],
                'type'=> $tagTypes[random_int(0,3)]
            ];
            if(!empty($list['age_start'])){
                $tags[] = [
                    'id'=>-1,
                    'name'=>$list['age_start']."岁以上",
                    'type'=> $tagTypes[random_int(0,3)]
                ];
            }


            if (isset($catArr[$list['one_cate_id']])) {
                $tags[] = [
                    'id' => $list['one_cate_id'],
                    'name' => $catArr[$list['one_cate_id']],
                    'type'=> $tagTypes[random_int(0,3)]
                ];
            }
            if (isset($catArr[$list['two_cate_id']])) {
                $tags[] = [
                    'id' => $list['two_cate_id'],
                    'name' => $catArr[$list['two_cate_id']],
                    'type'=> $tagTypes[random_int(0,3)]
                ];
            }
            $nameLength =  mb_strlen($list['name']);
            $list["name"] = $nameLength>24? (mb_substr($list['name'],0,24)."..."):$list['name'];
            $list['unit_desc'] = $list['salary'] . "/" . $list['unit'];
            $list['tags'] = $tags;
            $lists[$key] = $list;
        }
        return $this->sendResponse(['list' => $lists], 'Jobs retrieved successfully');
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
    public function show(Request $request)
    {
        $id = $request->get('id');
        /** @var Jobs $jobs */
        $jobs = $this->jobsRepository->find($id);

        if (empty($jobs)) {
            return $this->sendError('Jobs not found');
        }
        $jobData = $jobs->toArray();
        $store = Store::find($jobData['store_id']);

        /**
         * id: 1,
         * name: '线上给文章配音投稿，在家轻松做',
         * unit_desc: '50元/条',
         * settlement: '日结',
         * employ_count: '招300人',
         * sex: '男',
         * work_time: '06月16日-07月16日',
         * age_range: '20-40',
         * work_content: '工作内容',
         * work_require: '岗位要求几年级啊加大节能加拿大加拿大缴纳\n' +
         * '时间段斤斤计较大',
         * salary_desc: '薪资说明',
         * report_count: 1799,
         * store_info: {
         * name: '喵绘教育',
         * logo: 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg',
         * id: 1
         * }
         */
        $settlementMap = [
            '1' => '日结',
            '2' => '周结',
            '3' => '月结',
            '4' => '完工结',
            '5' => '其他'
        ];
        $workInfo = [
            "id" => $jobData['id'],
            "name" => $jobData['name'],
            "unit_desc" => $jobData['salary'] . "/" . $jobData['unit'],
            "settlement" => $settlementMap[$jobData['settlement']] ?? '',
            "employ_count" => "招" . $jobData['employ_count'] . "人",
            "sex" => (intval($jobData['sex']) === 1) ? '男' : ((intval($jobData['sex']) === 2) ? '女' : '不限'),
            "work_time" => date("m-d", $jobData['work_start_time']) . "-" . date("m-d", $jobData['work_end_time']),
            "age_range" => (empty($jobData['age_start']) && empty($jobData['age_end'])) ? '' : ($jobData['age_start'] . '-' . $jobData['age_end']),
            "work_content" => $jobData['work_content'],
            "salary_desc" => $jobData['salary_desc'],
            "work_require" => $jobData['work_require'],
            "report_count" => $jobData['report_count'],
            "store_info" => [
                "name" => $store['name'],
                "logo" => $store['logo'],
                'id' => $store['id'],
            ],
            "contact_qrcode" => $jobData['contact_qrcode'] ?? '',
            "contact_qq" => $jobData['contact_qq'] ?? '',
            "contact_wx" => $jobData['contact_wx'] ?? '',
            "contact_mobile" => $jobData['contact_mobile'] ?? '',
            "current_date" => date("Y-m-d H:i:s")
        ];
        DB::table('jobs')->where(['id' => $id])->increment('view_count', 1);

        return $this->sendResponse($workInfo, 'Jobs retrieved successfully');
    }

    public function recommend()
    {
        $query = DB::table("jobs AS j")->leftJoin("stores AS s", 'j.store_id', '=', 's.id')
            ->where('balance', '>', 0)
            ->where(['s.status' => 1])
            ->where(['j.status' => 1]);
        if (!empty($oneCateId)) {
            $query->where(['one_cate_id' => $oneCateId]);
        }
        $lists = $query->orderBy('is_top', 'desc')
            ->orderBy('sort', 'asc')
            ->limit(10)
            ->get(["j.id", "is_top", "j.name", "unit", 'salary', "s.name as store_name", "report_count", "one_cate_id", "two_cate_id"])
            ->toArray();
        $oneCateIdArr = array_column($lists, 'one_cate_id');
        $twoCateIdArr = array_column($lists, 'two_cate_id');

        $cateIdArr = array_merge($oneCateIdArr, $twoCateIdArr);
        $catArr = [];
        if ($cateIdArr) {
            $catArr = DB::table("job_cate")->whereIn('id', $cateIdArr)->get(["id", "name"])->toArray();
            $catArr = array_column($catArr, 'name', 'id');
        }
        foreach ($lists as $key => $list) {
            $list = json_decode(json_encode($list), true);
            $tags = [];
            if (isset($catArr[$list['one_cate_id']])) {
                $tags[] = $catArr[$list['one_cate_id']];
            }
            if (isset($catArr[$list['two_cate_id']])) {
                $tags[] = $catArr[$list['two_cate_id']];
            }
            $list['unit_desc'] = $list['salary'] . "/" . $list['unit'];
            $list['tag'] = $tags;
            $lists[$key] = $list;
        }
        return $this->sendResponse($lists, 'Jobs retrieved successfully');
    }

    public function record(Request $request)
    {
        $jobId = $request->get('job_id');
        $reportArr = DB::table('job_report_records')->where([
            'job_id' => $jobId
        ])->limit(8)->get('uid')->toArray();
        $uidArr = array_column($reportArr, 'uid');
        if (!empty($uidArr)) {
            $uidArr = AppUser::whereIn('id', $uidArr)->select("id","avatar","invite_code")->get()->toArray();
            foreach ($uidArr as $key=>$item){
                if($item['avatar'] == ""|| $item['avatar'] == 'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132'){
                    $item['avatar'] = AppUser::randomAvatar();
                    $uidArr[$key] = $item;
                }
            }

        }
        return $this->sendResponse($uidArr, 'Jobs retrieved successfully');
    }

    /**
     * @param Request $request
     * @return
     */
    public function report(Request $request)
    {
        $jobId = $request->post('job_id');
        $uid = auth()->id();
        if(empty(auth()->user()->birthday) || empty(auth()->user()->sex) || empty(auth()->user()->real_name)){
            return $this->sendError('未完成实名信息，暂不可报名');
        }
        $jobs = JobReportRecords::where([
            'job_id' => $jobId,
            'uid' => $uid
        ])->first();
        if (!empty($jobs)) {
            return $this->sendError('已经报名了，无需重复报名');
        }

        $job = Jobs::where(['id'=>$jobId,'status'=>Jobs::JOB_STATUS_UP])->first();
        if(empty($job)){
            return $this->sendError('职位不存在或已下架不可报名');
        }
        //职位限制性别
        if($job->sex){
            if($job->sex !=  auth()->user()->sex){
                return $this->sendError('职位限制性别：性别不符合无法报名');
            }
        }
        $userAge = bcsub(date("Y"),date("Y",strtotime(auth()->user()->birthday)));
        //年龄限制
        if($job->age_start>0 && ($job->age_start > $userAge)){
            return $this->sendError('职位限制年龄：年龄不符合无法报名');
        }

        if($job->age_end>0 && ($job->age_end < $userAge)){
            return $this->sendError('职位限制年龄：年龄不符合无法报名');
        }
        $store = Store::where(['id'=>$job->store_id,'status'=>Store::STORE_STATUS_UP])->first();
        if(empty($store)){
            return $this->sendError('店铺不存在或已下架不可报名');
        }
        if($store->balance<=0){
            return $this->sendError('店铺余额不足不可报名');
        }
        $jobReportRecord = new JobReportRecords();
        $jobReportRecord->job_id = $jobId;
        $jobReportRecord->uid = $uid;
        if(!$jobReportRecord->save()){
            return $this->sendError('报名失败');
        }

        DB::table('jobs')->where(['id' => $jobId])->increment('report_count', 1);

        //先写日志
        $balance = new BalanceLog();
        $balance->amount = 1;
        $balance->direction = 2;
        $balance->reason = '报名消费';
        $balance->uid = auth()->id();
        $balance->source = 2;
        if ($balance->save()) {
            DB::table('stores')->where(['id' => $job->store_id])->decrement('balance', 1);
        }

        $this->sendResponse([], '报名成功');

    }

    /**
     * @param Request $request
     * @return
     */
    public function reportStatus(Request $request)
    {
        $jobId = $request->post('job_id');
        $res = DB::table("job_report_records")->where([
            "job_id" => $jobId,
            "uid" => auth()->id()
        ])->first();
        return $this->sendResponse($res, "操作成功");
    }

}
