<?php

namespace Domain\Users\DataTransferObjects;

use App\Platform\Auth\Requests\RegisterRequest;
use App\Platform\Users\Requests\UpdateUserAvatarRequest;
use App\Platform\Users\Requests\UpdateUserRequest;
use Illuminate\Http\UploadedFile;
use Laravel\Socialite\Contracts\User;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public ?string $first_name;
    public ?string $last_name;
    public ?string $email;
    public ?string $password;

    // OAuth
    public ?string $google_id;

    // Extra Attributes
    public ?string $avatar;
    public ?UploadedFile $uploaded_avatar;

    public function hasVerifiedEmail(): bool
    {
        return (bool) $this->google_id;
    }

    public static function new(array $array): self
    {
        return new self($array);
    }

    public static function fromRegisterRequest(
        RegisterRequest $registerRequest
    ): self {
        return new self([
            'first_name' => $registerRequest->get('first_name'),
            'last_name' => $registerRequest->get('last_name'),
            'email' => $registerRequest->get('email'),
            'password' => $registerRequest->get('password'),

            'google_id' => $registerRequest->get('google_id'),
            'avatar' => $registerRequest->get('avatar'),
        ]);
    }

    public static function fromSocialiteUser(User $socialiteUser, string $driver): self
    {
        $splitName = explode(' ', $socialiteUser->getName(), 2);

        return new self([
            'first_name' => $splitName[0],
            'last_name' => ! empty($splitName[1])
                ? $splitName[1]
                : '',
            'email' => $socialiteUser->getEmail(),
            "{$driver}_id" => $socialiteUser->getId(),
            'avatar' => $socialiteUser->getAvatar(),
        ]);
    }

    public static function fromUpdateUserRequest(
        UpdateUserRequest $updateUserRequest
    ): self {
        return new self([
            'first_name' => $updateUserRequest->get('first_name'),
            'last_name' => $updateUserRequest->get('last_name'),
            'email' => $updateUserRequest->get('email'),
            'password' => $updateUserRequest->get('password'),
        ]);
    }

    public static function fromUpdateUserAvatarRequest(
        UpdateUserAvatarRequest $updateUserAvatarRequest
    ): self {
        return new self([
            'uploaded_avatar' => $updateUserAvatarRequest->file('avatar'),
        ]);
    }
}
