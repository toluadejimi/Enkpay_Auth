<?php

namespace App\Http\Resources;

use JetBrains\PhpStorm\ArrayShape;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** Transform the resource into an array. */

    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->full_name,
            'phone_number' => PhoneNumber::make($this->phone, $this->phone_country)
                ->formatInternational(),
            'account_type' => $this->type,
            'account' => VirtualAccountResource::collection($this->whenLoaded('virtual_account')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
