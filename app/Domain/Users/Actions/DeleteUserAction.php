<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;

class DeleteUserAction
{
    public function execute(User $user): void
    {
        $user->delete();
    }
}
