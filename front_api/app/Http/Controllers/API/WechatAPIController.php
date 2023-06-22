<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decode(Request $request)
    {
        $session = $request->post("session");
        $iv = $request->post("iv");
        $encryptedData = $request->post("encryptedData");

//        $avatar = $request->post('avatar');
//        $nickname = $request->post('nickname');

        $wechatData = $this->app->encryptor->decryptData($session, $iv, $encryptedData);
        $mobile = $wechatData['phoneNumber'];
        $user = User::where(['mobile' => $mobile])->first();
        //用户不存在
        if (empty($user)) {
            $user = new  User();
            $user->mobile = $mobile;
            $user->password = Hash::make('123456');
            $user->save();
        }
        $credentials = ['mobile' => $mobile, 'password' => '123456'];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['msg' => 'Unauthorized', 'code' => 400, 'sql' => DB::getQueryLog()], 200);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'code' => 20000,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
