<?php

namespace App\Http\Livewire\Admin\Platform;

use App\Models\Category;
use App\Models\Platform;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;

    public $heading, $platform_id, $categories, $icon_preview = null;

    public
        $title,
        $icon,
        $pro,
        $category_id,
        $status,
        $placeholder_en,
        $placeholder_sv,
        $description_en,
        $description_sv,
        $baseURL,
        $input;

    protected function rules()
    {
        return [
            'title'             => ['required'],
            'icon'              => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
            'pro'               => ['required', 'not_in:'],
            'category_id'       => ['required', 'not_in:'],
            'status'            => ['required', 'not_in:'],
            'placeholder_en'    => ['sometimes'],
            'placeholder_sv'    => ['sometimes'],
            'description_en'    => ['sometimes'],
            'description_sv'    => ['sometimes'],
            'baseURL'           => ['sometimes'],
            'input'             => ['required', 'not_in:'],
        ];
    }

    protected function messages()
    {
        return [
            'title.required'            => 'required',
            'icon.nullable'             => 'nullable',
            'icon.mimes'                => 'mimes:jpeg,jpg,png',
            'icon.max'                  => 'max:2000',
            'pro.required'              => 'required',
            'pro.not_in'                => 'Invalid selection for pro',
            'category_id.required'      => 'required',
            'category_id.not_in'        => 'Invalid selection for category_id',
            'status.required'           => 'required',
            'status.not_in'             => 'Invalid selection for status',
            'placeholder_en.sometimes'  => 'sometimes',
            'placeholder_sv.sometimes'  => 'sometimes',
            'description_en.sometimes'  => 'sometimes',
            'description_sv.sometimes'  => 'sometimes',
            'baseURL.sometimes'         => 'sometimes',
            'input.required'            => 'required',
            'input.not_in'              => 'Invalid selection for input',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function mount($id)
    {
        $this->platform_id = $id;
        $platform = Platform::where('id', $id)->first();

        $this->title = $platform->title;
        $this->icon_preview = $platform->icon;
        $this->pro = $platform->pro;
        $this->category_id = $platform->category_id;
        $this->status = $platform->status;
        $this->placeholder_en = $platform->placeholder_en;
        $this->placeholder_sv = $platform->placeholder_sv;
        $this->description_en = $platform->description_en;
        $this->description_sv = $platform->description_sv;
        $this->baseURL = $platform->baseURL;
        $this->input = $platform->input;


        $this->categories = Category::all()->pluck('name', 'id')->toArray();
    }

    public function deleteImage($image)
    {
        if ($image) {
            if (Storage::exists('public/' . $image)) {
                Storage::delete('public/' . $image);
            }
        }
        $this->icon_preview = null;
        Platform::where('id', $this->platform_id)->update([
            'icon' => null
        ]);
    }

    public function update()
    {
        $data = $this->validate();

        if (!$data['icon']) {
            $data['icon'] = $this->icon_preview;
        } else {
            $image = $data['icon'];
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/uploads/platforms', $imageName);
            $data['icon'] = 'uploads/platforms/' . $imageName;
            if ($this->icon_preview) {
                if (Storage::exists('public/' . $this->icon_preview)) {
                    Storage::delete('public/' . $this->icon_preview);
                }
            }
        }

        Platform::where('id', $this->platform_id)->update($data);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Platform updated successfully!',
        ]);
    }

    public function render()
    {
        $this->heading = "Edit";
        return view('livewire.admin.platform.edit')
            ->layout('layouts.app');
    }
}
