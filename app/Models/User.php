<?php

namespace App\Models;

use App\States\User\Active;
use Illuminate\Support\Str;
use App\Enums\AccountTypeEnum;
use App\States\User\UserStatus;
use App\Traits\MustVerifyPhone;
use Spatie\ModelStates\HasStates;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Support\Generators\OTPToken;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\VerificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasStates;
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;
    use MustVerifyPhone;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pin' => 'encrypted',
        'status' => UserStatus::class,
        'type' => AccountTypeEnum::class,
        'date_of_birth' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->uuid = Str::orderedUuid();
        });
    }

    public function getPhoneNumberAttribute(): string
    {
        return (string) PhoneNumber::make($this->phone, $this->phone_country)
                ->formatE164();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->first_name} {$this->middle_name}";
    }

    public function phoneIsVerified(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function accountIsVerified(): bool
    {
        return $this->status->equals(Active::class);
    }

    public function sendVerificationNotification(): void
    {
        $this->generateVerificationToken();

        $this->notify(new VerificationNotification());
    }

    public function generateVerificationToken(): void
    {
        DB::table('phone_verification_tokens')
            ->upsert([
                [
                    'phone' => $this->phone_number,
                    'token' => (string) OTPToken::generate(),
                    'created_at' => $this->freshTimestamp()
                ]
            ], ['phone'], ['token', 'created_at']);
    }

    public function getVerificationToken(): mixed
    {
        return DB::table('phone_verification_tokens')
            ->where('phone', $this->phone_number)
            ->value('token');
    }

    public function verifyAccount(): void
    {
        $this->markPhoneAsVerified();
        $this->status->transitionTo(Active::class);

        $this->deletePhoneVerificationToken();
    }

    public function isAdmin(): bool
    {
        return $this->type === "admin";
    }

    public function deletePhoneVerificationToken(): void
    {
        DB::table('phone_verification_tokens')
            ->where('phone', $this->phone_number)
            ->delete();
    }
}
