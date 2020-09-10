<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @see \Domain\Users\Actions\CreateUserActionTest */
class CreateUserAction
{
    public function execute(UserData $data): User
    {
        $user = $this->create($data);

        return $user;
    }

    private function create(UserData $data): User
    {
        $user = new User();

        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;

        $user->email = $data->email;
        $user->email_verified_at = $data->hasVerifiedEmail()
            ? now()
            : null;

        $user->password = $data->password
            ? Hash::make($data->password)
            : Hash::make(Str::random(22));
        $user->password_changed_at = $data->password
            ? now()
            : null;

        $user->google_id = $data->google_id ?? null;

        $user->extra_attributes->set([
            'avatar' => $data->avatar ?? null,
        ]);

        $user->save();

        return $user;
    }
}
