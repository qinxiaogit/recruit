<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\Jobs;
use App\Models\PromotionJob;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Repositories\JobsRepository;
use Illuminate\Support\Facades\DB;

class JobsController extends AppBaseController
{
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
        $name = $request->get("name");
        if(!empty($name)){
            $where['name'] = $name;
        }
        $where['status'] = 1 ;//仅显示上架职位
        $jobs = $this->jobsRepository->all(
            $where,
            $request->get('skip'),
            $request->get('limit')
        );
        $items = $jobs->toArray();

        $storeIdArr = array_column($items, 'store_id');

        $stores = Store::whereIn('id', $storeIdArr)->get()->toArray();
        $storeMap = array_column($stores, null, 'id');

//        $jobsIds=  array_column($items, 'id');

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
     * @param Request $request
     * @return
     * @desc 分享
     */
    public function share(Request $request){
        $jobId = (int)$request->post('job_id');
        $source= $request->post('source','job');

        if(empty($jobId) && $source=="job"){
            return $this->sendError('Jobs not found');
        }
        $inviteCode = "";
//        $user = DB::table("app_user")->where(['id'=>auth()->id()])->first();
//        if(empty($user)){
//            return $this->sendError('该手机号未注册');
//        }
        $inviteCode = auth()->user()->invite_code;

        $shareMethod= $request->post('shareMethod','1');
        $token = 'asdmasaskdajdmkaskmasmkasdmksdamkdskmsdkmdsmkcdsike9i38927y802';
        $data = file_get_contents("https://api.yunqirenli.com/api/v1/public/share?id={$jobId}&invite_code={$inviteCode}&token={$token}&source={$source}&shareMethod=".$shareMethod);
        $dataArr = json_decode($data,true);
        if($dataArr['success']){
            $proto = PromotionJob::where([
                'view' =>$source,
                'view_id'=>$jobId,
                'uid' =>auth()->id(),
            ])->first();
            if(empty($proto)){
                $proto = new PromotionJob();
                $proto->view = $source;
                $proto->view_id = $jobId;
                $proto->uid = auth()->id();
                $proto->save();
            }
        }
        return $this->sendResponse(  $dataArr['data']??'','Jobs updated successfully');
    }

    public function dashboash(Request $request){
        $uid = auth()->id();
        $data = DB::table('promotion_job as pj')
            ->leftJoin("jobs as j","pj.view_id",'=','j.id')
            ->leftJoin("stores as s","s.id",'=','j.store_id')
            ->where("pj.uid",'=',$uid)
            ->select("pj.*","j.name as job_name","s.name as store_name","s.logo")
            ->get()->toArray();
        return $this->sendResponse($data,"操作成功");
    }

    public function detail(Request $request){
        $skip = $request->get('skip');
        $limit=$request->get('limit');
        $startDate = $request->get("start_date",date("Y-m-d"));
        $endDate = $request->get("end_date",date("Y-m-d"));

        $uid = auth()->id();

        $query = DB::table('promotion_job_log as pj')
            ->leftJoin("jobs as j","pj.view_id",'=','j.id')
            ->leftJoin("stores as s","s.id",'=','j.store_id')
            ->where("pj.agent_id",'=',$uid);

        $query->whereBetween('pj.created_at',[
                $startDate." 00:00:00",
                $endDate." 23:59:59"
            ]);

        $total = $query->count();
        $items = $query->orderByDesc('pj.id')
            ->offset($skip)
            ->limit($limit)
            ->select("pj.*","j.name as job_name","s.name as store_name","s.logo")
            ->get()->toArray();
        $data = [
            'items' => $items,
            'total' => $total,
//            'where'=>DB::getQueryLog()
        ];
        return $this->sendResponse($data, 'App Users retrieved successfully');
    }
}
