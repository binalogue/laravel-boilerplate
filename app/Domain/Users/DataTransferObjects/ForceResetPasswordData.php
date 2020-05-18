<?php

namespace Domain\Users\DataTransferObjects;

use App\Platform\Users\Requests\ForceResetPasswordRequest;
use Spatie\DataTransferObject\DataTransferObject;

class ForceResetPasswordData extends DataTransferObject
{
    public string $password;

    public static function fromRequest(
        ForceResetPasswordRequest $forceResetPasswordRequest
    ): self {
        return new self([
            'password' => $forceResetPasswordRequest->get('password'),
        ]);
    }
}
