<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;

class DestroyUserAction
{
    public function execute(User $user): void
    {
        $user->delete();
    }
}
