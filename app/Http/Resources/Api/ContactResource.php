<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'photo' => $this->photo,
            'work_email' => $this->work_email,
            'company_name' => $this->company_name,
            'job_title' => $this->job_title,
            'address' => $this->address,
            'phone' => $this->phone,
            'work_phone' => $this->work_phone,
            'website' => $this->website,
        ];
    }
}
