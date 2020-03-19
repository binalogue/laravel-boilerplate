<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;

class UpdateUserAvatarAction
{
    public function execute(User $user, UserData $userData): User
    {
        $user->extra_attributes->set([
            'avatar' => !is_null($userData->uploaded_avatar)
                ? $userData->uploaded_avatar->store($user->getAvatarsDirectory(), 'public')
                : $user->extra_attributes->avatar,
        ]);

        $user->save();

        return $user;
    }
}
