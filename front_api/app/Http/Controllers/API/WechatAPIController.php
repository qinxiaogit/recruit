<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\AppUser;
use App\User;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Overtrue\LaravelWeChat\Facade;

/**
 * Class WechatAPIController
 * @package App\Http\Controllers\API
 * @desc 微信api
 */
class WechatAPIController extends AppBaseController
{
    protected $app;

    public function __construct()
    {
        $this->app = Facade::miniProgram("default");
    }

    /**
     * @param Request $request
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(Request $request)
    {

        $code = $request->post("code");
        return $this->app->auth->session($code);
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decode(Request $request)
    {
        $session = $request->post("session");
        $iv = $request->post("iv");
        $encryptedData = $request->post("encryptedData");

//        $encryptedData =  str_replace($encryptedData,'+',' ');

        $openid = $request->post('openid');

        $inviteCode = $request->post('invite_code');

        $wechatData = $this->app->encryptor->decryptData($session, $iv, $encryptedData);
        $mobile = $wechatData['phoneNumber'];
        $user = User::where(['mobile' => $mobile])->first();
        //用户不存在
        if (empty($user)) {
            $user = new  User();
            $user->mobile = $mobile;
            $user->password = Hash::make('123456');
            $user->openid = $openid;
            if (!empty($inviteCode)) {
                $inviteUser = User::where(['invite_code' => $inviteCode])->first();
                if (!empty($inviteUser)) {
                    $user->invite_uid = $inviteUser->id;
                }
            }
            if (!$user->save()) {
                return $this->sendError('保存用户失败');
            }
            $user->invite_code = base_convert(AppUser::USER_INVITE_CODE_START + $user->id, 10, 36);
            $user->save();
        }
        $credentials = ['mobile' => $mobile, 'password' => '123456'];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['msg' => 'Unauthorized', 'code' => 400, 'sql' => DB::getQueryLog()], 200);
        }

        return $this->respondWithToken($token, $user->invite_code);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @param string $inviteCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $inviteCode = "")
    {
        return response()->json([
            'code' => 20000,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'invite_code' => $inviteCode
            ]
        ]);
    }


    /**
     * @分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function share(Request $request){
        $source = $request->get('source');
        $jobId = $request->get("id");
        $inviteCode = $request->get("invite_code");
        $token = $request->get('token');
        $shareMethod = $request->get('shareMethod');
        if ($token != "asdmasaskdajdmkaskmasmkasdmksdamkdskmsdkmdsmkcdsike9i38927y802") {
            return response()->json(['msg' => 'Unauthorized', 'code' => 66,], 200);
        }

        switch ($source){
            case "job":
                $path = "pages/home/job";
                $scene = "id=".$jobId."&invite_code=".$inviteCode;
                break;
            case "home":
                $path = "pages/home/index";
                $scene = "invite_code=".$inviteCode;
                break;
            default:

                return response()->json(['msg' => 'Unauthorized', 'code' => 66,], 200);
        }

        if($shareMethod == 2){
            try {
                $response = $this->app->app_code->httpPostJson("wxa/generate_urllink",  [

                        "page_url"=>$scene."&scene=".urlencode($scene),
                        "expire_type"=>0,
                        "expire_time"=>strtotime("+30day")

                ]);
                var_dump($response->getBody()->getContents());die();
            } catch (\Exception $e) {
                var_dump($e->getMessage());die();
            }
            //https://api.weixin.qq.com/wxa/genwxashortlink?access_token=ACCESS_TOKEN
//            $response =$this->app->access_token->getLastToken()
        }else{
            $response =$this->app->app_code->getUnlimit($scene,[
                'page'  => $path,
            ]);
            if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
                $filename = $response->save('/tmp');

                $localName = "/tmp/".$filename;
                $remoteFile = 'qrcode/' . date("Ymd") . "/" . md5(time()).".png";

                $remoteUrl = $this->upload_image($remoteFile, file_get_contents($localName));
                unlink($localName);
                return $this->sendResponse($remoteUrl, '上传成功');
            }
        }
        $this->sendResponse($response->toArray(), '上传成功');
    }
    function upload_image($path, $file)
    {
        if (!$path) return false;
        $disk = Storage::disk('qiniu');

        //将文件上传到七牛云，并且返回七牛云上相对路径
        $fileinfo = $disk->put($path, $file);
        //用相对路径来获取图片的完整路径
        return ['domain' => $disk->getUrl(''), 'path' => $path];
    }
}
