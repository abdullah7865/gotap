<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id ?? null,
            'title' => $this->title ?? null,
            'icon' => $this->icon ?? null,
            'input' => $this->input ?? null,
            'baseUrl' => $this->baseUrl ?? null,
            'placeholder_en' => $this->placeholder_en ?? null,
            'placeholder_sv' => $this->placeholder_sv ?? null,
            'description_en' => $this->description_en ?? null,
            'description_sv' => $this->description_sv ?? null,
            // 'created_at' => defaultDateFormat($this->created_at) ?? null,
            'path' => $this->path ?? null,
            'label' => $this->label ?? null,
            'direct' => $this->direct ?? null,
            'platform_order' => $this->platform_order ?? null,
        ];

        if (request()->segment(2) == 'profile') {
            $data['saved'] = 1;
        }

        return $data;
    }
}
