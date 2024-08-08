<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $data =  [
            'id' => $this->id,
            'title' => $this->title,
            'total_members' => $this->total_members,
            'total_contacts' => $this->total_contacts,
            'active' => $this->active,
            'created_at' => defaultDateFormat($this->created_at),
        ];

        if (request()->segment(2) == 'groups') {
            $data['group_contacts'] = $this->getContacts();
            $data['group_members'] = $this->getMembers();
        }

        return $data;
    }

    private function getContacts()
    {
        return DB::table('group_contacts')->select(
            'phone_contacts.id as phone_contact_id',
            'phone_contacts.first_name as phone_contact_first_name',
            'phone_contacts.last_name as phone_contact_last_name',
            'phone_contacts.photo as phone_contact_photo'
        )
            ->join('phone_contacts', 'phone_contacts.id', 'group_contacts.contact_id')
            ->where('group_contacts.group_id', $this->id)
            ->get()
            ->toArray();
    }

    private function getMembers()
    {
        return DB::table('user_groups')->select(
            'users.id as phone_contact_id',
            'users.name as user_name',
            'users.username as user_username',
            'users.photo as user_photo'
        )
            ->join('users', 'users.id', 'user_groups.user_id')
            ->where('user_groups.group_id', $this->id)
            ->get()
            ->toArray();
    }
}
