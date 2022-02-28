<?php

namespace App\Http\Resources;

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
                ->formatE164(),
            'account_type' => $this->type,
            'account_number' => $this->account_number,
            'account_balance' => $this->virtual_account_balance,
        ];
    }
}
