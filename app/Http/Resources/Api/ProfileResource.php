<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' =>  $this->name ?? null,
            'email' => $this->email ?? null,
            'username' => $this->username ?? null,
            'phone' => $this->phone ?? null,
            'job_title' =>  $this->job_title ?? null,
            'company' =>  $this->company ?? null,
            'photo' =>  $this->photo ?? null,
            'cover_photo' =>  $this->cover_photo ?? null,
            'status' =>  $this->status ?? null,
            'is_suspended' =>  $this->is_suspended ?? null,
            'user_direct' =>  $this->user_direct ?? null,
            'address' =>  $this->address ?? null,
            'work_position' =>  $this->work_position ?? null,
            'gender' =>  $this->gender ?? null,
            'tiks' =>  $this->tiks ?? null,
            'dob' =>  $this->dob ?? null,
            'private' =>  $this->private ?? null,
            'verified' =>  $this->verified ?? null,
            'featured' =>  $this->featured ?? null,
            'bio' =>  $this->bio ?? null,
            'deactivated_at' =>  $this->deactivated_at ?? null,
            'created_at' => defaultDateFormat($this->created_at) ?? null,
        ];
    }
}
