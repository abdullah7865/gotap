<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;

    public $preview_photo, $preview_cover_photo, $heading;

    public
        $user_id,
        $name,
        $email,
        $photo,
        $cover_photo,
        $username,
        $job_title,
        $phone,
        $company,
        $bio,
        $verified,
        $featured;

    public function mount($id)
    {
        $this->user_id = $id;
        $user = User::where('id', $id)->first();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->preview_photo = $user->photo;
        $this->preview_cover_photo = $user->cover_photo;
        $this->username = $user->username;
        $this->job_title = $user->job_title;
        $this->phone = $user->phone;
        $this->company = $user->company;
        $this->bio = $user->bio;
        $this->verified = $user->verified;
        $this->featured = $user->featured;
    }

    protected function rules()
    {
        return [
            'name'         => ['sometimes'],
            'email'        => ['required', 'email'],
            'photo'        => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
            'cover_photo'  => ['nullable', 'mimes:jpeg,jpg,png', 'max:2000'],
            'username'     => ['required'],
            'job_title'    => ['sometimes'],
            'phone'        => ['sometimes'],
            'company'      => ['sometimes'],
            'bio'          => ['sometimes'],
            'verified'     => ['sometimes', 'not_in:-1'],
            'featured'     => ['sometimes', 'not_in:'],
        ];
    }

    protected function messages()
    {
        return [
            'name.sometimes'          => 'The name field is optional.',
            'email.required'          => 'The email field is required.',
            'email.email'             => 'The email must be a valid email address.',
            'photo.mimes'             => 'The photo must be a file of type: jpeg, jpg, png.',
            'photo.max'               => 'The photo may not be greater than 2000 kilobytes.',
            'cover_photo.mimes'       => 'The cover photo must be a file of type: jpeg, jpg, png.',
            'cover_photo.max'         => 'The cover photo may not be greater than 2000 kilobytes.',
            'username.required'       => 'The username field is required.',
            'job_title.sometimes'     => 'The job title field is optional.',
            'phone.sometimes'         => 'The phone field is optional.',
            'company.sometimes'       => 'The company field is optional.',
            'bio.sometimes'           => 'The bio field is optional.',
            'verified.sometimes'      => 'The verified field is optional.',
            'verified.not_in'         => 'The selected value for verified is invalid.',
            'featured.sometimes'      => 'The featured field is optional.',
            'featured.not_in'         => 'The selected value for featured is invalid.',
        ];
    }

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function deleteImage($type, $image)
    {
        if ($image) {
            if (Storage::exists('public/' . $image)) {
                Storage::delete('public/' . $image);
            }
        }
        if ($type == 'photo') {
            $this->preview_photo = null;
            User::where('id', $this->user_id)->update([
                'photo' => null
            ]);
        }
        if ($type == 'cover_photo') {
            $this->preview_cover_photo = null;
            User::where('id', $this->user_id)->update([
                'cover_photo' => null
            ]);
        }
    }

    public function update()
    {
        $data = $this->validate();

        if (!$data['photo']) {
            $data['photo'] = $this->preview_photo;
        } else {
            $image = $this->photo;
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/uploads/photos', $imageName);
            $data['photo'] = 'uploads/photos/' . $imageName;
            if ($this->preview_photo) {
                if (Storage::exists('public/' . $this->preview_photo)) {
                    Storage::delete('public/' . $this->preview_photo);
                }
            }
        }

        if (!$data['cover_photo']) {
            $data['cover_photo'] = $this->preview_cover_photo;
        } else {
            $image = $this->cover_photo;
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/uploads/coverPhotos', $imageName);
            $data['cover_photo'] = 'uploads/coverPhotos/' . $imageName;
            if ($this->preview_cover_photo) {
                if (Storage::exists('public/' . $this->preview_cover_photo)) {
                    Storage::delete('public/' . $this->preview_cover_photo);
                }
            }
        }
        User::where('id', $this->user_id)->update($data);

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'User updated successfully!',
        ]);
    }

    public function render()
    {
        $this->heading = "Edit";

        return view('livewire.admin.user.edit')
            ->layout('layouts.app');
    }
}
