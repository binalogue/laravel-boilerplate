<?php

namespace Domain\Users\Observers;

use Domain\Users\Actions\DeleteUserAvatarsAction;
use Domain\Users\Models\User;

class UserObserver
{
    /**
     * Handle the user "deleting" event.
     *
     * @param  \Domain\Users\Models\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \Domain\Users\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        (new DeleteUserAvatarsAction())->execute($user);
    }
}
