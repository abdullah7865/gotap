<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ConnectRequest;
use App\Models\Group;
use App\Http\Resources\Api\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function connect(ConnectRequest $request)
    {
        $connected = DB::table('connects')->where('connected_id', $request->connect_id)
            ->where('connecting_id', auth()->id())->first();
        if ($connected) {
            $deleted = DB::table('connects')->where('connected_id', $request->connect_id)
                ->where('connecting_id', auth()->id())
                ->delete();
            if ($deleted) {
                return response()->json([
                    'message' => trans('backend.connection_removed')
                ]);
            } else {
                return response()->json([
                    'message' => trans('backend.connection_removed_fails')
                ]);
            }
        }
        $connect = DB::table('connects')->insert([
            'connected_id' => $request->connect_id,
            'connecting_id' => auth()->id()
        ]);
        if ($connect) {
            return response()->json([
                'message' => trans('backend.connection_success')
            ]);
        }
        return response()->json([
            'message' => trans('backend.connection_removed_fails')
        ]);
    }

    /**
     * Private Profile
     */
    public function privateProfile()
    {

        $user = auth()->user();

        if ($user->private) {
            User::where('id', $user->id)
                ->update(
                    [
                        'private' => 0
                    ]
                );

            $user = User::find(auth()->id());
            return response()->json([
                'message' => trans('backend.profile_set_public'), 'data' => new ProfileResource($user)
            ]);
        }

        User::where('id', auth()->id())
            ->update(
                [
                    'private' => 1
                ]
            );
        $user = User::find(auth()->id());
        return response()->json([
            'message' => trans('backend.profile_set_private'), 'data' => new ProfileResource($user)
        ]);
    }

    /**
     * Deactivate Account
     */
    public function deactivateAccount()
    {
        $user_groups = DB::table('user_groups')
            ->where('user_id', auth()->id())
            ->get();

        foreach ($user_groups as $user_group) {
            $group = Group::where('id', $user_group->group_id)->first();
            Group::where('id', $group->id)->decrement();
        }

        $updated = User::where('id', auth()->id())->update(
            [
                'status' => 0,
                'deactivated_at' => date('Y-m-d H:i:s'),
            ]
        );
        if ($updated) {
            $message = trans('backend.account_will_delete');
            return response()->json([
                'message' => $message
            ]);
        }
        return response()->json([
            'message' => trans('backend.something_wrong')
        ]);
    }

    /**
     * Delete Account
     */
    public function deleteAccount()
    {
        $user_groups = DB::table('user_group')
            ->where('user_id', auth()->id())
            ->get();

        // foreach ($user_groups as $user_group) {
        //     $group = Group::where('id', $user_group->group_id)->first();
        //     Group::where('id', $group->id)->decrement();
        // }

        $updated = User::where('id', auth()->id())->update(
            [
                'status' => 0,
                'deactivated_at' => date('Y-m-d H:i:s'),
            ]
        );
        if ($updated) {
            $message = trans('backend.account_will_delete');
            return response()->json(['message' => $message]);
        }
        return response()->json(['message' => trans('backend.something_wrong')]);
    }

    /**
     * Analytics
     */
    public function analytics()
    {
        $connections = DB::table('connects')->where('connecting_id', auth()->id())->get()->count();
        $profileViews = User::where('id', auth()->id())->first()->tiks;

        $platforms = DB::table('user_platforms')
            ->select(
                'platforms.id',
                'platforms.title',
                'platforms.icon',
                'user_platforms.path',
                'user_platforms.label',
                'user_platforms.clicks',
            )
            ->join('platforms', 'platforms.id', 'user_platforms.platform_id')
            ->where('user_id', auth()->id())
            ->orderBy(('user_platforms.platform_order'))
            ->get();


        return response()->json(
            [
                'user' => [
                    [
                        'label' => trans('backend.connections'),
                        'connections' => $connections,
                        'icon' => 'uploads/photos/total_connections.png',
                    ],
                    [
                        'label' => trans('backend.profile_views'),
                        'profileViews' => $profileViews,
                        'icon' => 'uploads/photos/profile_views.png',
                    ],
                    [
                        'label' => trans('backend.platform_clicks'),
                        'total_clicks' => $platforms->sum('clicks'),
                        'icon' => 'uploads/photos/total_clicks.png',
                    ],
                    [
                        'label' => trans('backend.platforms'),
                        'total_platforms' => $platforms->count(),
                        'icon' => 'uploads/photos/total_platforms.png',
                    ],
                    [
                        'label' => trans('backend.groups'),
                        'total_groups' => Group::where('user_id', auth()->id())->count(),
                        'icon' => 'uploads/photos/total_groups.png',
                    ],
                ],
                'platforms' => $platforms
            ]
        );
    }
}
