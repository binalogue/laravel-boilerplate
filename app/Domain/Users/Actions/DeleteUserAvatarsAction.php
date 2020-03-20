<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Support\Facades\Storage;

class DeleteUserAvatarsAction
{
    public function execute(User $user): void
    {
        Storage::disk('public')->deleteDirectory($user->getAvatarsDirectory());
    }
}
