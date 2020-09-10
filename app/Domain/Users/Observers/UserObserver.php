<?php

namespace Domain\Users\Observers;

use Domain\Users\Actions\DeleteUserAvatarsAction;
use Domain\Users\Models\User;

class UserObserver
{
    public function deleting(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {
        (new DeleteUserAvatarsAction())->execute($user);
    }
}
