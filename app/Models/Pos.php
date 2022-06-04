<?php

namespace App\Models;

use App\Enums\DeviceTypeEnum;
use App\Enums\DeviceStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pos extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => DeviceStatusEnum::class,
        'device_type' => DeviceTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
