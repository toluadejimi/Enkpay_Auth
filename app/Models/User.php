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
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerificationNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
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
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->uuid = Str::orderedUuid();
        });
    }

    public function getPhoneNumberAttribute(): string
    {
        return (string) PhoneNumber:: make($this->phone, $this->phone_country)
                ->formatInternational();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->first_name} {$this->middle_name}";
    }

    public function phoneIsVerified(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function accountIsVerified()
    {
        return $this->status->equals(Active::class);
    }

    public function sendVerificationNotification()
    {
        $this->generateVerificationToken();

        $this->notify(new VerificationNotification());
    }

    public function generateVerificationToken()
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

    public function getVerificationToken()
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

    public function deletePhoneVerificationToken()
    {
        DB::table('phone_verification_tokens')
            ->where('phone', $this->phone_number)
            ->delete();
    }

    public function virtual_account(): HasOne
    {
        return $this->hasOne(VirtualAccount::class, 'user_id');
    }
}
