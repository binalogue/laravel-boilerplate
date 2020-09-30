<?php

namespace Domain\Auth\DataTransferObjects;

use App\Platform\Auth\Requests\ForceResetPasswordRequest;
use Spatie\DataTransferObject\DataTransferObject;

class ForceResetPasswordData extends DataTransferObject
{
    public string $password;

    public static function fromRequest(
        ForceResetPasswordRequest $forceResetPasswordRequest
    ): self {
        return new self([
            'password' => $forceResetPasswordRequest->input('password'),
        ]);
    }
}
