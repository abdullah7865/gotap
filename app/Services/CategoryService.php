<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Platform;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public function categoryWithPlatorms($id  = null)
    {
        // $categories = Category::join('platforms', 'platforms.category_id', 'categories.id')->get();
        $categories = Category::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('platforms')
                ->whereRaw('platforms.category_id = categories.id')
                ->where('platforms.status', '=', '1');
    })
        ->get();
        $userPlatforms = DB::table('user_platforms')
            ->select(
                'platforms.id as platform_id'
            )
            ->join('platforms', 'platforms.id', 'user_platforms.platform_id')
            ->where('user_id', $id)
            ->get()
            ->toArray();

        $userPlatforms = array_column($userPlatforms, 'platform_id');

        // Create an empty array to hold the transformed data
        $transformedResponse = [];

        // Loop through each category in the original response
        foreach ($categories as $category) {
            $totalPlatforms = 0;
            // Create a new array to hold the transformed category data
            $transformedCategory = [];

            // Add the desired properties to the transformed category
            $transformedCategory['id'] = $category->id;
            $transformedCategory['name'] = $category->name;
            $transformedCategory['title_en'] = $category->name;
            $transformedCategory['title_sv'] = $category->name_sv;

            // Create an empty array to hold the transformed platforms
            $transformedPlatforms = [];

            $platforms = Platform::where('category_id', $category->id)->where('status', 1)->get();

            // Loop through each platform in the category
            foreach ($platforms as $platform) {
                $totalPlatforms = $totalPlatforms + 1;
                // Create a new array to hold the transformed platform data
                $transformedPlatform = [];

                //Get extra details from user_platforms table
                $userPlatform = $this->getUserPlatformDetails($platform->id);

                // Add the desired properties to the transformed platform
                $transformedPlatform['id'] = $platform->id;
                $transformedPlatform['title'] = $platform->title;
                $transformedPlatform['icon'] = $platform->icon;
                $transformedPlatform['input'] = $platform->input;
                $transformedPlatform['baseURL'] = $platform->baseURL;
                $transformedPlatform['pro'] = (string) $platform->pro;
                $transformedPlatform['category_id'] = (string) $platform->category_id;
                $transformedPlatform['status'] = (string) $platform->status;
                $transformedPlatform['placeholder_en'] = $platform->placeholder_en;
                $transformedPlatform['placeholder_sv'] = $platform->placeholder_sv;
                $transformedPlatform['description_en'] = $platform->description_en;
                $transformedPlatform['description_sv'] = $platform->description_sv;
                $transformedPlatform['created_at'] = defaultDateFormat($platform->created_at);
                $transformedPlatform['updated_at'] = defaultDateFormat($platform->updated_at);
                $transformedPlatform['category'] = $category->name;
                $transformedPlatform['category_sv'] = $category->name_sv;
                $transformedPlatform['path'] = $userPlatform ? $userPlatform['path'] : null;
                $transformedPlatform['saved'] =  $userPlatforms ? $this->checkPlatformSaved($platform->id, $userPlatforms) : 0;
                $transformedPlatform['direct'] =  $userPlatform ? $userPlatform['direct'] : 0;

                // Add the transformed platform to the array of transformed platforms
                $transformedPlatforms[] = $transformedPlatform;
            }

            // Add the array of transformed platforms to the transformed category
            $transformedCategory['totalPlatforms'] = $totalPlatforms;
            $transformedCategory['platforms'] = $transformedPlatforms;


            // Add the transformed category to the array of transformed categories
            $transformedResponse[] = $transformedCategory;
        }

        return $transformedResponse;
    }

    private function checkPlatformSaved($platformId, $userPlatforms)
    {
        if (in_array($platformId, $userPlatforms)) {
            return 1;
        }
        return 0;
    }

    private function getUserPlatformDetails($id)
    {
        
        
        
        $userPlatform = DB::table('user_platforms')
            ->where('platform_id', $id)
            ->where('user_id', auth()->id())
            ->first();
            
        
        
        if ($userPlatform) {
            // dd($userPlatform->path);
            return ['path' => $userPlatform->path, 'direct' => $userPlatform->direct];
        }
        return null;
    }
}
