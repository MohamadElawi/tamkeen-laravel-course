<?php

namespace App\Http\Resources\Admin\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'status' => $this->status->translate(),
            'status_value' => $this->status ,
            'created_at' => formatDate($this->created_at) ,
//            'permission_names' => PermissionResource::collection($this->permissions)
            'permission_names' => $this->getPermissionNames(),
            'role_names' => $this->getRoleNames()

        ];

    }
}
