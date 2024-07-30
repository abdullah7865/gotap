<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ViewProfileRequest;
use App\Http\Resources\Api\PlatformResource;
use App\Models\Card;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;

class ViewProfileController extends Controller
{

    public function viewUserProfile(ViewProfileRequest $request)
    {
        $card = null;
        $checkCard = null;
        if ($request->has('card_uuid')) {
            $card = Card::where('uuid', $request->card_uuid)->first();
            if (!$card) {
                return response()->json(['message' => trans('backend.card_not_found')]);
            }
            // check card status
            if (!$card->status) {
                return response()->json(['message' => trans('backend.card_inactive')]);
            }
            // check user card status is active or not
            $checkCard = DB::table('user_cards')
                ->select('user_cards.user_id')
                ->where('card_id', $card->id)
                ->where('status', 1)
                ->first();
            if (!$checkCard) {
                return response()->json(['message' => trans('backend.profile_not_accessible')]);
            }
        }

        if ($checkCard) {
            $res['user'] = User::where('id', $checkCard->user_id)->first();
        }
        if ($request->has('username')) {
            $res['user'] = User::where('username', $request->username)->first();
        }
        if ($request->has('connect_id')) {
            $res['user'] = User::where('id', $request->connect_id)->first();
        }
        if (!$res['user']) {
            return response()->json(['message' => trans('backend.profile_not_found')]);
        }

        $res['user']->connected = 0;
        $connected = DB::table('connects')->where('connecting_id', auth()->id())
                ->where('connected_id', $res['user']->id)
                ->first();
            if ($connected) {
                $res['user']->connected = 1;
            }

        // $categoryService = new CategoryService();

        if ($res['user']->id != auth()->id() || $res['user']->username != auth()->user()->username) {
            User::where('id', $res['user']->id)->increment('tiks');
        }

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
            ->where('user_id', $res['user']->id)
            ->orderBy(('user_platforms.platform_order'))
            ->get();

        return response()->json([
            'message' => 'User profile',
            'user' => $res['user'],
            'platforms' => PlatformResource::collection($platforms)
            // 'categories' => $categoryService->categoryWithPlatorms($res['user']->id)
        ]);
    }
}
