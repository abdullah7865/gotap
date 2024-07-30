<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Link\AddLinkRequest;
use App\Http\Requests\Api\Link\UpdateLinkRequest;
use App\Models\Link;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::where('user_id', auth()->id())->get();
        return response()->json(['links' => $links]);
    }

    public function add(AddLinkRequest $request)
    {
        try {
            $icon = null;
            if ($request->hasFile('icon')) {
                $image = $request->icon;
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('public/uploads/linkIcons', $imageName);
                $icon = 'uploads/linkIcons/' . $imageName;
            }
            $link = Link::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'icon' => $icon
            ]);

            return response()->json(['message' => trans('backend.link_created_success'), 'link' => $link]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    public function update(UpdateLinkRequest $request)
    {
        $link = Link::where('id', $request->link_id)->first();
        if (!$link) {
            return response()->json(['message' => trans('backend.link_not_found')]);
        }

        try {
            $icon = $link->icon;
            if ($request->hasFile('icon')) {
                $image = $request->icon;
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('public/uploads/linkIcons', $imageName);
                $icon = 'uploads/linkIcons/' . $imageName;
                if ($icon) {
                    if (Storage::exists('public/' . $icon)) {
                        Storage::delete('public/' . $icon);
                    }
                }
            }

            Link::where('id', $request->link_id)->update([
                'title' => $request->title,
                'icon' => $icon,
            ]);

            $link = Link::where('id', $request->link_id)->first();
            return response()->json(['message' => trans('backend.link_updated_success'), 'data' => $link]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    public function remove($id)
    {
        $link = Link::where('id', $id)->first();
        if (!$link) {
            return response()->json(['message' => trans('backend.link_not_found')]);
        }

        $icon = $link->icon;
        if ($icon) {
            if (Storage::exists('public/' . $icon)) {
                Storage::delete('public/' . $icon);
            }
        }

        $link->delete();
        return response()->json(['message' => trans('backend.link_deleted_success')]);
    }
}
