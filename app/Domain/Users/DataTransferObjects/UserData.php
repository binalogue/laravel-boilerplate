<?php

namespace Domain\Users\DataTransferObjects;

use App\Platform\Users\Requests\AuthRegisterRequest;
use App\Platform\Users\Requests\ProfileUpdateRequest;
use App\Platform\Users\Requests\UpdateProfileAvatarRequest;
use Illuminate\Http\UploadedFile;
use Laravel\Socialite\Contracts\User;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public ?string $name;
    public ?string $first_surname;
    public ?string $second_surname;
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
            'name' => $authRegisterRequest->get('name'),
            'first_surname' => $authRegisterRequest->get('first_surname'),
            'second_surname' => $authRegisterRequest->get('second_surname'),
            'email' => $authRegisterRequest->get('email'),
            'password' => $authRegisterRequest->get('password'),

            'google_id' => $authRegisterRequest->get('google_id'),
            'avatar' => $authRegisterRequest->get('avatar'),
        ]);
    }

    public static function fromSocialiteUser(User $socialiteUser, string $driver): self
    {
        $splitName = explode(' ', $socialiteUser->getName(), 3);

        return new self([
            'name' => $splitName[0],
            'first_surname' => ! empty($splitName[1])
                ? $splitName[1]
                : '',
            'second_surname' => ! empty($splitName[2])
                ? $splitName[2]
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
            'name' => $profileUpdateRequest->get('name'),
            'first_surname' => $profileUpdateRequest->get('first_surname'),
            'second_surname' => $profileUpdateRequest->get('second_surname'),
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
