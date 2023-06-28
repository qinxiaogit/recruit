<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/front/login",
     *     summary="系统登录",
     *     operationId="loginSystem",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="code",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="encryptedData",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="iv",
     *                     type="string"
     *                 ),
     *                 example={"code": "微信code", "encryptedData": "获取手机号加密数据","iv":"加密偏移"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     * )
     */
    public function login()
    {
        $credentials = request(['username', 'password']);
        $credentials = [
            'username' => 'admin',
            'password' => '123456'
        ];
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'code' => 401,
                'data' => '',
                'msg'  => "登录失败"
            ]);
        }

        return $this->respondWithToken($token);
    }


    /**
     * @OA\Post(
     *     path="/api/auth/front/me",
     *     summary="获取用户信息",
     *     operationId="meSystem",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     * )
     */
    public function me()
    {
        return response()->json([
            'code' => 20000,
            'data' => auth()->user()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/front/logout",
     *     summary="退出登录",
     *     operationId="logoutSystem",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     * )
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['code'=>20000]);
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
    public function register(){
        $user = new User();
        $user->username = 'admin';
        $user->password = Hash::make('123456');
//        $user->email = 'useremail@something.com';
        $user->save();
        return response()->json([
            'access_token' => $user->id,
            'aaa'=>'2'
        ]);
    }


}
