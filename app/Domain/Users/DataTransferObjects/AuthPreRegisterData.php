<?php

namespace Domain\Users\DataTransferObjects;

use App\Platform\Users\Requests\AuthPreRegisterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class AuthPreRegisterData extends DataTransferObject
{
    public string $email;

    public static function fromRequest(AuthPreRegisterRequest $request): self
    {
        return new self([
            'email' => $request->get('email'),
        ]);
    }
}
