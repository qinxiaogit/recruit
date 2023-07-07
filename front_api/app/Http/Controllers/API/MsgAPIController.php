<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsgAPIController extends AppBaseController
{
    /**
     * 消息列表
     */
    public function report(Request $request)
    {
        $page = $request->get('page');
        $size = $request->get('size');

        $where = [
            'uid' => auth()->user()->id
        ];
        $arr = DB::table("job_report_records")->where($where)
            ->orderBy('id', 'desc')
            ->offset(($page - 1) * $size)
            ->limit($size)
            ->get('job_id')
            ->toArray();

        $jobsMap = [];
        $storeMap = [];
        if (!empty($arr)) {
            $jobIdArr = array_column($arr, 'job_id');
            $jobsArr = DB::table("jobs")->whereIn('id', $jobIdArr)->get(["id", "name", 'store_id'])->toArray();

            $jobsMap = array_column($jobsArr, null, 'id');

            $storeIdArr = array_column($jobsArr, 'store_id');
            $storeArr = DB::table("stores")->whereIn('id', $storeIdArr)->get(['id', 'name', 'logo'])->toArray();
            $storeMap = array_column($storeArr, null, 'id');
        }

        foreach ($arr as $key => $item) {
            $item['job'] = $jobsMap[$item['job_id']] ?? [];
            $item['store'] = $storeMap[$item['job']['store_id']] ?? [];

            $arr[$key] = $item;
        }
        return $this->sendResponse(['list' => $arr], 'Jobs retrieved successfully');
    }
}
