<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Platform;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    // Get the original API response
    public function index()
    {

        $categoryService =  new CategoryService();
        $transformedResponse = $categoryService->categoryWithPlatorms(auth()->id());

        // Return the transformed response
        return response()->json(['categories' => $transformedResponse]);
    }
}
