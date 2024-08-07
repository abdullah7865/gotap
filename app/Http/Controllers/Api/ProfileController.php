<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\ProfileResource;
use App\Http\Resources\Api\PlatformResource;
use App\Http\Livewire\Admin\Category\Categoies;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
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
        ->join('platforms', 'platforms.id', '=', 'user_platforms.platform_id')
        ->where('user_id', auth()->id())
        ->orderBy('user_platforms.platform_order')
        ->get();

        return response()->json(
            [
                'profile' => new ProfileResource(auth()->user()),
                'platforms' => PlatformResource::collection($platforms)
            ]
        );
    }



    public function update(UpdateProfileRequest $request)
    {
        try {
            $cover_photo = auth()->user()->cover_photo;
            $photo = auth()->user()->photo;

            if ($request->hasFile('cover_photo')) {
                $image = $request->cover_photo;
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('public/uploads/coverPhotos', $imageName);
                $cover_photo = '/storage/uploads/coverPhotos/' . $imageName;
                if (auth()->user()->cover_photo) {
                    if (Storage::exists('public/' . auth()->user()->cover_photo)) {
                        Storage::delete('public/' . auth()->user()->cover_photo);
                    }
                }
            }
            if ($request->hasFile('photo')) {
                $image = $request->photo;
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('public/uploads/photos', $imageName);
                $photo = '/storage/uploads/photos/' . $imageName;
                if (auth()->user()->photo) {
                    if (Storage::exists('public/' . auth()->user()->photo)) {
                        Storage::delete('public/' . auth()->user()->photo);
                    }
                }
            }

            $user = User::where('id', auth()->id())->first();

            $isUpdated = User::where('id', auth()->id())->update([
                'username' => $request->username ? $request->username : $user->username,
                'email' => $request->email ? $request->email : $user->email,
                'bio' => $request->bio,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'private' => $request->private ? $request->private : $user->private,
                'name' => $request->name,
                'cover_photo' => $cover_photo,
                'photo' => $photo,
                'address' => $request->address,
                'job_title' => $request->job_title,
                'company' => $request->company,
                'phone' => $request->phone,
                'work_position'=> $request->work_position,
            ]);

            if (!$isUpdated) {
                return response()->json([

                    'message' => trans('backend.profile_updated_failed')
                ]);
            }

            $user = User::where('id', auth()->id())->get()->first();

            return response()->json([
                'message' => trans('backend.profile_updated_success'), 'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([

                'message' => $ex->getMessage()
            ]);
        }
    }

    public function userDirect()
    {
        $user = auth()->user();

        if ($user->user_direct) {
            User::where('id', $user->id)
                ->update(
                    [
                        'user_direct' => 0
                    ]
                );

            $user = User::find(auth()->id());

            return response()->json(['message' => trans('backend.platform_set_public'), 'profile' => new ProfileResource($user)]);
        }

        User::where('id', auth()->id())
            ->update(
                [
                    'user_direct' => 1
                ]
            );
        $user = User::find(auth()->id());
        return response()->json(['message' => trans('backend.first_platform_public'), 'profile' => new ProfileResource($user)]);
    }

    public function privateProfile()
    {

        $status = auth()->user()->private ? 'Public' : 'Private';

        User::where('id', auth()->id())
            ->update(
                [
                    'user_direct' => auth()->user()->user_direct ? 0 : 1
                ]
            );

        return response()->json(['message' => trans('backend.profile_set_to') . $status, 'data' => auth()->user()]);
    }

    public function search(SearchRequest $request)
    {
        $searchQuery = $request->input('query', '');

        if (empty($searchQuery)) {
            $users = User::all();
            $message = 'All users fetched successfully.';
        } else {
            $users = User::where('name', 'like', '%' . $searchQuery . '%')->get();
            if ($users->isEmpty()) {
                $message = 'No users found.';
            } else {
                $message = 'Users have been found.';
            }
        }

        return response()->json([
            'message' => $message,
            'data' => $users
        ]);
    }
}
