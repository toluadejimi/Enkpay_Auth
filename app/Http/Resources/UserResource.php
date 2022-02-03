<?php

namespace App\Http\Resources;

use JetBrains\PhpStorm\ArrayShape;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** Transform the resource into an array. */
    #[ArrayShape(['uuid' => "mixed", 'name' => "mixed", 'phone_number' => "mixed", 'roles' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection", 'permissions' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])]
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->full_name,
            'phone_number' => PhoneNumber::make($this->phone, $this->phone_country)->formatInternational(),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
