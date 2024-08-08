<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ConnectRequest;
use App\Http\Requests\Api\User\GetConnect;
use App\Http\Requests\SearchRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class ConnectController extends Controller
{
    public function connect(ConnectRequest $request)
    {

        if($request->connect_id == auth()->id()) {
            return response()->json([
                'message' => 'Please enter valid connect Id'
            ]);
        }

        // check connection is valid
        $connection = User::where('id', $request->connect_id)
            ->first();

        if (!$connection) {
            return response()->json([
                'message' => trans('backend.connection_not_found')
            ]);
        }

        // check
        $connected = DB::table('connects')
            ->where('connected_id', $request->connect_id)
            ->where('connecting_id', auth()->id())
            ->first();
        if ($connected) {
            return response()->json([
                'message' => trans('backend.already_connected')
            ]);
        }

        try {
            DB::table('connects')->insert([
                'connected_id' => $request->connect_id,
                'connecting_id' => auth()->id()
            ]);
            return response()->json([
                'message' => trans('backend.connected_success')
            ]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    public function disconnect(ConnectRequest $request)
    {

        if($request->connect_id == auth()->id()) {
            return response()->json([
                'message' => 'Please enter valid connect Id'
            ]);
        }


        // check connection is valid
        $connection = User::where('id', $request->connect_id)
            ->first();

        if (!$connection) {
            return response()->json([
                'message' => trans('backend.connection_not_found')]);
        }

        $connected = DB::table('connects')
            ->where('connected_id', $request->connect_id)
            ->where('connecting_id', auth()->id())
            ->first();
        if (!$connected) {
            return response()->json(['message' => trans('backend.not_connected')]);
        }

        try {
            DB::table('connects')
                ->where('connected_id', $request->connect_id)
                ->where('connecting_id', auth()->id())
                ->delete();
            return response()->json(['message' => trans('backend.connection_removed')]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    /**
     * Get all connections
     */
 public function getConnections(SearchRequest $request)
    {
        $searchQuery = $request->input('query', '');

        $connections = User::select(
            'connection.id as connection_id',
            'connection.name as connection_name',
            'connection.username as connection_user_name',
            'connection.job_title as connection_job_title',
            'connection.company as connection_company',
            'connection.photo as connection_photo',
            'connection.verified as verified',
        )
            ->join('connects', 'connects.connecting_id', 'users.id')
            ->join('users as connection', 'connection.id', 'connects.connected_id')
            ->where('users.id', auth()->id())
            ->when(!empty($searchQuery), function($query) use ($searchQuery) {
                $query->where('connection.name', 'like', '%' . $searchQuery . '%');
            })
            ->get();

        $message = $connections->isEmpty() ? 'No connections found .' : 'Connections fetched successfully.';

        return response()->json([
            'message' => $message,
            'data' => $connections
        ]);
    }

    /**
     * Get connection profile
     */
    public function getConnectionProfile(GetConnect $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['message' => 'Please enter a valid username']);
        }

        if ($user->username == auth()->user()->username) {
            return response()->json([
                'message' => 'Please enter a valid username'
            ]);
        }

        $res['user'] = $user;

        $platforms = DB::table('user_platforms')
            ->select(
                'platforms.id',
                'platforms.title',
                'platforms.icon',
                'platforms.input',
                'platforms.baseUrl',
                'user_platforms.created_at',
                'user_platforms.path',
                'user_platforms.label',
                'user_platforms.platform_order',
                'user_platforms.direct',
            )
            ->join('platforms', 'platforms.id', 'user_platforms.platform_id')
            ->where('user_id', $user->id)
            ->orderBy('user_platforms.platform_order')
            ->get();

        // Check if the current user is connected to the target user
        $isConnected = DB::table('connects')
            ->where('connecting_id', auth()->id())
            ->where('connected_id', $user->id)
            ->first();

        return response()->json([
            'profile' => $res['user'],
            'platforms' => $platforms,
            'is_connected' => $isConnected ? 1 : 0,
        ]);
    }

}
