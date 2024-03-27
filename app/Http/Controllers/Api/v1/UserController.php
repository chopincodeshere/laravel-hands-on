<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Login the user and return the bearer token
     *
     * @param  \App\Http\Requests\Api\v1\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => __('messages.user_not_found'),
                'status' => '0',
            ]);
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'message' => __('messages.wrong_password'),
                'status' => '0',
            ]);
        }
        return response()->json([
            'data' => $user,
            'token' => $user->createToken($request->header('User-Agent') ?? $request->ip())->plainTextToken,
            'message' => __('messages.user_login'),
            'status' => '1'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        return response()->json([
            'data' => $user,
            'message' => __('messages.user_detail_returned'),
            'status' => '1'
        ]);
    }
}
