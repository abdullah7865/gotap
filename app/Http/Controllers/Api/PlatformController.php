<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Platform\AddPlatformRequest;
use App\Http\Requests\Api\Platform\IncrementRequest;
use App\Http\Requests\Api\Platform\PlatformRequest;
use App\Http\Requests\Api\Platform\SwapPlatformRequest;
use App\Models\Platform;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\Api\PlatformResource;

class PlatformController extends Controller
{

    /**
     * Search Platform
     **/
    public function search(Request $request)
    {
        $platforms = [];
        if ($request->title) {
            $platforms = Platform::where('title', 'like', '%' . $request->title . '%')->get();
        }

        return response()->json(
            [
                'platforms' => PlatformResource::collection($platforms)
            ]
        );
    }


    /**
     * Platform By Id
     **/
    public function details(Request $request)
    {

        $platform = Platform::find($request->id);

        if (!$platform) {
            return response()->json(['message' => 'Platform not found']);
        }

        return response()->json(
            [
                'platforms' => new PlatformResource($platform)
            ]
        );
    }

    public function add(AddPlatformRequest $request)
    {
        $platform = Platform::where('id', $request->platform_id)->where('status', 1)->first();
        if (!$platform) {
            return response()->json([

                'message' => trans('backend.platform_not_found')
            ]);
        }

        $baseUrl = $platform->baseURL;
        if ($baseUrl) {
            if (substr($baseUrl, -1) == '/') {
                $baseUrl = substr($baseUrl, 0, -1);
            }
        }

        $user_platform = DB::table('user_platforms')
            ->where('platform_id', $request->platform_id)
            ->where('user_id', auth()->id())
            ->first();

        try {
            if ($user_platform) {
                // Update existing platform
                $path = $request->path;

                DB::table('user_platforms')
                    ->where('platform_id', $request->platform_id)
                    ->where('user_id', auth()->id())
                    ->update([
                        'label' => $request->label,
                        'path' => $path,
                        'direct' => $request->direct
                    ]);

                $userPlatform = $this->userPlatform($request->platform_id);
                if ($userPlatform) {
                    return response()->json([

                        'message' => trans('backend.platform_updated_success'),
                        'data' => $userPlatform
                    ]);
                }
            } else {
                // Add new platform
                $path = $request->path;
                $latestPlatform = DB::table('user_platforms')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->first();

                DB::table('user_platforms')->insert([
                    'user_id' => auth()->id(),
                    'platform_id' => $request->platform_id,
                    'direct' => $request->direct,
                    'label' => $request->label,
                    'path' => $path,
                    'platform_order' => $latestPlatform ? ($latestPlatform->platform_order + 1) : 1,
                ]);

                $userPlatform = $this->userPlatform($request->platform_id);
                return response()->json([
                    "message" => trans('backend.platform_added_success'),
                    'data' => $userPlatform
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                "message" => $ex->getMessage()
            ]);
        }
    }

    /**
     * Remove platform
     */
    public function remove(PlatformRequest $request)
    {
        $platform = DB::table('user_platforms')
            ->where('user_id', auth()->id())
            ->where('platform_id', $request->platform_id)
            ->first();
        if (!$platform) {
            return response()->json([

                'message' => trans('backend.platform_not_found')
            ]);
        }

        $platform = DB::table('user_platforms')
            ->where('user_id', auth()->id())
            ->where('platform_id', $request->platform_id)
            ->delete();
        return response()->json([

            'message' => trans('backend.platform_removed_success')
        ]);
    }

    /**
     * Swap order
     */
    public function swap(SwapPlatformRequest $request)
    {

        if (!is_array($request->orderList)) {
            return response()->json(['message' => trans("order list must be an array")]);
        }

        $orderList = json_decode(json_encode($request->orderList));

        $id = array_column($orderList, 'id');
        array_multisort($id, SORT_ASC, $orderList);

        foreach ($orderList as $index => $platform) {

            DB::table('user_platforms')->where('user_id', auth()->id())
                ->where('platform_id', $platform->id)
                ->update(
                    [
                        'platform_order' => $platform->order
                    ]
                );
        }

        return response()->json([

            'message' => trans("Order swapped successfully")
        ]);
    }

    /**
     * Direct
     */
    public function direct(PlatformRequest $request)
    {
        $userPlatform = DB::table('user_platforms')
            ->where('user_id', auth()->id())
            ->where('platform_id', $request->platform_id)
            ->first();
        if (!$userPlatform) {
            return response()->json(['message' => trans('backend.platform_not_found')]);
        }

        try {

            DB::table('user_platforms')
                ->where('user_id', auth()->id())
                ->where('platform_id', '!=', $request->platform_id)
                ->where('direct', 1)
                ->update([
                    'direct' => 0
                ]);

            DB::table('user_platforms')
                ->where('user_id', auth()->id())
                ->where('platform_id', $request->platform_id)
                ->update([
                    'direct' => $userPlatform->direct ? 0 : 1
                ]);

            if ($userPlatform->direct) {
                return response()->json(['message' => trans('backend.platform_hide_success')]);
            }
            return response()->json(['message' => trans('backend.platform_visible_success')]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    /**
     * Increment Click
     */
    public function incrementClick(IncrementRequest $request)
    {
        if ($request->user_id == auth()->id()) {
            return response()->json(['message' => trans('backend.own_platform_click')]);
        }

        DB::table('user_platforms')
            ->where('platform_id', $request->platform_id)
            ->where('user_id', $request->user_id)
            ->increment('clicks');

        return response()->json(['message' => trans('backend.platform_clicked')]);
    }

    /**
     * Platform Response (private)
     */
    private function userPlatform($id)
    {
        $userPlatform = DB::table('user_platforms')
            ->select(
                'platforms.id',
                'user_platforms.user_id',
                'user_platforms.path',
                'user_platforms.label',
                'user_platforms.direct',
            )
            ->join('platforms', 'platforms.id', 'user_platforms.platform_id')
            ->where('platform_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return $userPlatform;
    }

    private function formatUrl($userInput)
    {
        // Check if the input contains "http://" or "https://"
        if (strpos($userInput, "http://") === 0 || strpos($userInput, "https://") === 0) {
            return $userInput;
        } elseif (strpos($userInput, "www.") === 0) {
            // If the input starts with "www.", concatenate "https://" at the beginning
            return "https://" . $userInput;
        } else {
            // If not, concatenate "https://www." at the beginning
            return "https://www." . $userInput;
        }
    }
}
