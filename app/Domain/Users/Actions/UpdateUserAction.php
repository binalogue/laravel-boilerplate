<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, UserData $data): User
    {
        $user = $this->update($user, $data);

        return $user;
    }

    private function update(User $user, UserData $data): User
    {
        // Do not update email!

        $user->name = $data->name ?? $user->name;
        $user->first_surname = $data->first_surname ?? $user->first_surname;
        $user->second_surname = $data->second_surname ?? $user->second_surname;

        if ($data->password) {
            $user->password = Hash::make($data->password);
            $user->password_changed_at = now();
        }

        $user->save();

        return $user;
    }
}
