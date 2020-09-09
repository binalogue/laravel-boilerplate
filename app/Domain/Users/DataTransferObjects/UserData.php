<?php

namespace Domain\Users\DataTransferObjects;

use App\Platform\Auth\Requests\AuthRegisterRequest;
use App\Platform\Users\Requests\ProfileUpdateRequest;
use App\Platform\Users\Requests\UpdateProfileAvatarRequest;
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

    public static function new($array): self
    {
        return new self($array);
    }

    public static function fromAuthRegisterRequest(
        AuthRegisterRequest $authRegisterRequest
    ): self {
        return new self([
            'first_name' => $authRegisterRequest->get('first_name'),
            'last_name' => $authRegisterRequest->get('last_name'),
            'email' => $authRegisterRequest->get('email'),
            'password' => $authRegisterRequest->get('password'),

            'google_id' => $authRegisterRequest->get('google_id'),
            'avatar' => $authRegisterRequest->get('avatar'),
        ]);
    }

    public static function fromSocialiteUser(User $socialiteUser, string $driver): self
    {
        $splitName = explode(' ', $socialiteUser->getName(), 2);

        return new self([
            'first_name' => $splitName[0],
            'last_name' => !empty($splitName[1])
                ? $splitName[1]
                : '',
            'email' => $socialiteUser->getEmail(),
            "{$driver}_id" => $socialiteUser->getId(),
            'avatar' => $socialiteUser->getAvatar(),
        ]);
    }

    public static function fromProfileUpdateRequest(
        ProfileUpdateRequest $profileUpdateRequest
    ): self {
        return new self([
            'first_name' => $profileUpdateRequest->get('first_name'),
            'last_name' => $profileUpdateRequest->get('last_name'),
            'email' => $profileUpdateRequest->get('email'),
            'password' => $profileUpdateRequest->get('password'),
        ]);
    }

    public static function fromUpdateProfileAvatarRequest(
        UpdateProfileAvatarRequest $updateProfileAvatarRequest
    ): self {
        return new self([
            'uploaded_avatar' => $updateProfileAvatarRequest->file('avatar'),
        ]);
    }
}
