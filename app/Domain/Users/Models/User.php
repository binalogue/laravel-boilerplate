<?php

namespace Domain\Users\Models;

use Database\Factories\UserFactory;
use Domain\Users\Builders\UserBuilder;
use Domain\Users\Concerns\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Support\Eloquent\User as Authenticatable;
use Support\Notifications\Notifiable;
use Support\SchemalessAttributes\HasExtraAttributes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasExtraAttributes;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $guarded = [
        'id',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'password_changed_at',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'extra_attributes' => 'array',
        'has_notifications_enabled' => 'boolean',
        'password_changed_at' => 'datetime',
    ];

    protected $appends = [
        'avatar',
        'full_name',
    ];

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getFirstNameAttribute($value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    public function getLastNameAttribute($value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional Getters
    |--------------------------------------------------------------------------
    */

    public function getAvatarAttribute(): string
    {
        $avatar = $this->extra_attributes->avatar;

        if (is_null($avatar) || !Storage::disk('public')->exists($avatar)) {
            $avatar = asset('/images/default-avatar.png');
        }

        if (Str::startsWith($avatar, 'http')) {
            return $avatar;
        }

        return Storage::url($avatar);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = mb_strtolower($value, 'utf-8');
    }

    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = mb_strtolower($value, 'utf-8');
    }

    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    //

    /*
    |--------------------------------------------------------------------------
    | Custom
    |--------------------------------------------------------------------------
    */

    public function getAvatarsDirectory(): string
    {
        return "avatars/{$this->id}";
    }
}
