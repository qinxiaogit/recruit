<?php

namespace App\Http\Controllers;

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
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['mobile', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['msg' => 'Unauthorized', 'code' => 400], 200);
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
            'data' => auth()->user()
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

    /**
     * @param Request $request
     */
    public function update(Request $request){
        $avatar = $request->post('avatar');
        $nickname = $request->post('nickname');
        $user = auth()->user();
        $user->nickname = $nickname;
        $user->avatar = $avatar;
        $user->save();
        return response()->json($user);
    }
}
