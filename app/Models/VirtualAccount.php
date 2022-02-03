<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VirtualAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var <int, string> */
    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (VirtualAccount $virtualAccount) {
            $virtualAccount->uuid = Str::orderedUuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
