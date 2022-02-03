<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class PermissionResource extends JsonResource
{
    #[ArrayShape(['name' => "mixed"])]
    public function toArray($request): array
    {
        return [
            //'id' => $this->id,
            'name' => $this->name
        ];
    }
}
