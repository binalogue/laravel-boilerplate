<?php

namespace Domain\Users\Models;

use Domain\Users\Builders\UserBuilder;
use Domain\Users\Concerns\UserHasRoles;
use Support\SchemalessAttributes\HasExtraAttributes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Support\Eloquent\User as Authenticatable;
use Support\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasExtraAttributes;
    use Notifiable;
    use SoftDeletes;
    use UserHasRoles;

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'email_verified_at',
        'password_changed_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'password_changed_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'extra_attributes' => 'array',
        'password_changed_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'full_name',
    ];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Domain\Users\Builders\UserBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get the user's first surname.
     *
     * @param  string  $value
     * @return string
     */
    public function getFirstSurnameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get the user's second surname.
     *
     * @param  string  $value
     * @return string
     */
    public function getSecondSurnameAttribute($value)
    {
        return ucwords($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Additional Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's avatar.
     *
     * @return string
     */
    public function getAvatarAttribute()
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

    /**
     * Get the user's full-name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->first_surname}";
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Set the user's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtolower($value, 'utf-8');
    }

    /**
     * Set the user's first surname.
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstSurnameAttribute($value)
    {
        $this->attributes['first_surname'] = mb_strtolower($value, 'utf-8');
    }

    /**
     * Set the user's second surname.
     *
     * @param  string  $value
     * @return void
     */
    public function setSecondSurnameAttribute($value)
    {
        $this->attributes['second_surname'] = mb_strtolower($value, 'utf-8');
    }

    /**
     * Set the user's email.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
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
