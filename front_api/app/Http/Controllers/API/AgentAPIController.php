<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\AppUser;
use App\Models\PromotionJob;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentAPIController extends AppBaseController
{
    /**
     * @param Request $request
     */
    public function report(Request $request)
    {
        /**
         * @desc 代理商code
         */
        $agentCode = $request->post("agent_code");
        //页面code
        $viewId  = $request->post("view_id");
        //路径
        $path    = $request->post("path");

        $uid = 0;
        try{
            $uid = auth()->id();
        }catch (\Exception $exception){

        }

        $agentUid = base_convert($agentCode, 36, 10) - AppUser::USER_INVITE_CODE_START ;

        DB::enableQueryLog();
        DB::table('promotion_job')->where(['uid' => $agentCode,'view'=>$path])->increment('view_count', 1);

        DB::table("promotion_job_log")->insert([
            "view_id"=>$viewId,
            'uid' => $uid,
            'agent_id' =>$agentUid,
            'path' =>$path,
            'params' =>json_encode($_POST)
        ]);

        return $this->sendResponse(DB::getQueryLog(),"上报成功");
    }
}
