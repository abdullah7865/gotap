<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'job_title' =>  $this->job_title,
            'company' =>  $this->company,
            'photo' =>  $this->photo,
            'cover_photo' =>  $this->cover_photo,
            'status' =>  $this->status,
            'is_suspended' =>  $this->is_suspended,
            'user_direct' =>  $this->user_direct,
            'address' =>  $this->address,
            'work_position' =>  $this->work_position,
            'gender' =>  $this->gender,
            'tiks' =>  $this->tiks,
            'dob' =>  $this->dob,
            'private' =>  $this->private,
            'verified' =>  $this->verified,
            'featured' =>  $this->featured,
            'bio' =>  $this->bio,
            'deactivated_at' =>  $this->deactivated_at,
            'created_at' => defaultDateFormat($this->created_at),
        ];
    }
}
