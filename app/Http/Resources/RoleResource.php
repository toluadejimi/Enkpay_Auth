<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class RoleResource extends JsonResource
{
    #[ArrayShape(['name' => "mixed", 'permission' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function toArray($request): array
    {
        return [
            //'id' => $this->id,
            'name' => $this->name,
            'permission' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
