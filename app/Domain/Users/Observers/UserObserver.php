<?php

namespace Domain\Users\Observers;

use Domain\Users\Actions\DeleteProfileAvatarsAction;
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
        (new DeleteProfileAvatarsAction())->execute($user);
    }
}
