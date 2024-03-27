<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFollowController extends Controller
{
    /**
     * list of followers of the given user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function followers(User $user, CommonPaginationRequest $request)
    {
        $data = $user->followers();
        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.user_followers_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }
        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.user_followers_returned'),
            'status' => '1'
        ]);
    }

    /**
     * list of followers of the given user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function following(User $user, CommonPaginationRequest $request)
    {
        $data = $user->following();
        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.user_following_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }
        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.user_following_returned'),
            'status' => '1'
        ]);
    }

    /**
     * toggle the follow of auth user with the given user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(User $user)
    {
        $auth_user = Auth::user();
        if ($auth_user->id == $user->id) {
            return response()->json([
                'message' => __('messages.can_not_follow_self'),
                'status' => '0'
            ]);
        }
        $user->followers()->toggle([$auth_user->id]);
        return response()->json([
            'message' => __('messages.follow_toggle'),
            'status' => '1'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
