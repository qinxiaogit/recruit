<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFeedBackAPIRequest;
use App\Http\Requests\API\UpdateFeedBackAPIRequest;
use App\Models\AppUser;
use App\Models\FeedBack;
use App\Models\Jobs;
use App\Models\Store;
use App\Repositories\AuditLogRepository;
use App\Repositories\FeedBackRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class FeedBackController
 * @package App\Http\Controllers\API
 */
class FeedBackAPIController extends AppBaseController
{
    /** @var  FeedBackRepository */
    private $feedBackRepository;

    public function __construct(FeedBackRepository $feedBackRepo)
    {
        $this->feedBackRepository = $feedBackRepo;
    }

    /**
     * Display a listing of the FeedBack.
     * GET|HEAD /feedBack
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->get('page');
        $size = $request->get('size');

        $feeds = DB::table("feed_back")
            ->where(['feed_uid' => auth()->id()])
            ->orderBy('id', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get()
            ->toArray();

        $jobIdArr = array_column($feeds, 'job_id');

        $jobArr = Jobs::whereIn('id', $jobIdArr)->get()->toArray();
        $jobArrMap = array_column($jobArr, null, 'id');

        $storeIdArr = array_column($jobArr, 'store_id');

        $storeArr = Store::whereIn('id', $storeIdArr)->get()->toArray();
        $storeArrMap = array_column($storeArr, null, 'id');

        $reportTypeText = [
            1 => "收取费用",
            2 => "工资拖欠",
            3 => "放鸽子",
            4 => "虚假信息",
            5 => "刷单博彩",
            6 => "其他"
        ];
        $feeds = json_decode(json_encode($feeds),true);
        foreach ($feeds as $key => $item) {
            $jobId = $item['job_id'];
            $item['store_name'] = $storeArrMap[$jobId]['name'] ?? '';
            $item['name'] = $jobArrMap[$jobId]['name'] ?? '';
            $item['report_count'] = $jobArrMap[$jobId]['report_count'] ?? '';
            $item['unit_desc'] = ($jobArrMap[$jobId]['salary'] ?? '') . "/" . ($jobArrMap[$jobId]['unit'] ?? '');
            $item['img_json_arr'] = json_decode($item['img_json'], true);
            $item['tag'] = [];
            $item['report_type_text'] = $reportTypeText[$item['feed_type']] ?? "";
            $item['report_date'] = $item['created_at'];
            $feeds[$key] = $item;
        }
        return $this->sendResponse(['list' => $feeds], 'Jobs retrieved successfully');
    }


    public function total()
    {
        $total = DB::table("feed_back")->where(['feed_uid' => auth()->id()])->count();
        return $this->sendResponse(['total' => $total], '拉取成功');
    }

    public function report(Request $request)
    {
        $jobId = $request->post('job_id');

        $report = DB::table("feed_back")->where(['feed_uid' => auth()->id(), 'job_id' => $jobId])->first();
        if (!empty($report)) {
            return $this->sendError('你已经举报过该职位，等待管理员处理');
        }
        $imgJson = json_decode($request->post('img_json'),true);

        $urlArr = array_column($imgJson,'url');

        $feedback = new FeedBack();
        $feedback->feed_uid = auth()->id();
        $feedback->job_id = $request->post('job_id');
        $feedback->feed_type = $request->post('feed_type');
        $feedback->contact_method = $request->post('contact_method');
        $feedback->content = $request->post('content');
        $feedback->img_json = json_encode($urlArr);
        $feedback->status = 0;
        $feedback->reason = '';
        $feedback->save();
        return $this->sendResponse([], '举报成功');
    }
}
