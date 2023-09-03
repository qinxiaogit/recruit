<?php


namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:backend', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);
        $credentials['mobile'] = $credentials['username'];
        unset($credentials['username']);
        $appUser = AppUser::where(["mobile"=>$credentials['mobile']])->first();
        if(empty($appUser)|| empty($appUser->is_open_agent)){
            return Response::json(ResponseUtil::makeError("该手机号还未注册代理商平台"), 200);
//            return response()->json(['error' => '该手机号还未注册代理商平台'],401);
        }
        if (!$token = auth('backend')->attempt($credentials)) {
            return Response::json(ResponseUtil::makeError("密码错误"), 200);

//            return response()->json(['error' => ''], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            'code' => 20000,
            'data' => auth('backend')->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['code' => 20000]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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

    /**
     * @desc 注册用户
     */
    public function register()
    {
        $user = new User();
        $user->username = 'admin';
        $user->password = Hash::make('123456');
//        $user->email = 'useremail@something.com';
        $user->save();
        return response()->json([
            'access_token' => $user->id,
            'aaa' => '2'
        ]);
    }

}
