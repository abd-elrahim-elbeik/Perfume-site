<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        Auth::guard('api')->login($user);



        $device_name = $request->post('device_name', $request->userAgent());
        $token = $user->createToken($device_name)->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($res, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'msg' => 'incorrect username or password'
            ], 401);
        }

        Auth::guard('api')->login($user);

        $device_name = $request->post('device_name', $request->userAgent());

        $token = $user->createToken($device_name)->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];



        return response($res, 201);
    }

    public function logout(Request $request,$token = null)
    {



        $user = User::where('email', $request->email)->first();

        Auth::guard('api')->login($user);



        if (null === $token){
            auth()->guard('api')->user()->tokens()->delete();
            return [
             'message' => 'user logged out'
            ];
        }


        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ($user->id == $personalAccessToken->tokenable_id && get_class($user) == $personalAccessToken->tokenable_type) { //بتحقق انو هاد التوكن فعلا تابع لهاد اليوزر فبعمل عملية الحذف

            $personalAccessToken->delete();

            return [
                'message' => 'user logged out from thes device'
               ];
        }



    }

}
