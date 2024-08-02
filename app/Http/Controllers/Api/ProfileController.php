<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Admin\Category\Categoies;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;
use App\Http\Resources\Api\PlatformResource;
use App\Http\Resources\Api\ProfileResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $categoriesWithPlatforms = DB::table('categories')
            ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                'categories.name_sv as name_sv',
                'platforms.id as platform_id',
                'platforms.title',
                'platforms.icon',
                'platforms.input',
                'platforms.baseUrl',
                'platforms.category_id',
                'platforms.placeholder_en',
                'platforms.placeholder_sv',
                'platforms.description_en',
                'platforms.description_sv',
                'platforms.created_at',
                'platforms.updated_at'
            )
            ->leftJoin('platforms', 'platforms.category_id', '=', 'categories.id')
            ->get()
            ->groupBy('category_id');

        // Transform the grouped data into a more structured format
        $categories = $categoriesWithPlatforms->map(function ($platforms, $categoryId) {
            return [
                'category_id' => $categoryId,
                'category_name' => $platforms->first()->category_name,
                'name_sv' =>  $platforms->first()->name_sv,
                'platforms' => $platforms->map(function ($platform) {
                    return [
                        'id' => $platform->platform_id,
                        'title' => $platform->title,
                        'icon' => $platform->icon,
                        'input' => $platform->input,
                        'baseUrl' => $platform->baseUrl,
                        'category_id' => $platform->category_id,
                        'placeholder_en' => $platform->placeholder_en,
                        'placeholder_sv' => $platform->placeholder_sv,
                        'description_en' => $platform->description_en,
                        'description_sv' => $platform->description_sv,
                        'created_at'     => $platform->created_at,
                        'updated_at'     => $platform->updated_at,
                    ];
                }),
            ];
        });

        return response()->json(
            [
                'status' => 200,
                'message' => 'User Profile',
                'data' => new ProfileResource(auth()->user()),
                'categories' => $categories
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
                $cover_photo = 'uploads/coverPhotos/' . $imageName;
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
                $photo = 'uploads/photos/' . $imageName;
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
            ]);

            if (!$isUpdated) {
                return response()->json([
                    'status' => 400,
                    'message' => trans('backend.profile_updated_failed')
                ]);
            }

            $user = User::where('id', auth()->id())->get()->first();

            return response()->json([
                'status' => 200,
                'message' => trans('backend.profile_updated_success'), 'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 400,
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
}
