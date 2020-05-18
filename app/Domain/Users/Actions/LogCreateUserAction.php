<?php

namespace Domain\Users\Actions;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Log;

class LogCreateUserAction extends CreateUserAction
{
    public function execute(UserData $userData): User
    {
        Log::info("A new user has registered: {$userData->email}");

        return parent::execute($userData);
    }
}
