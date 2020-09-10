<?php

namespace Domain\Auth\DataTransferObjects;

use App\Platform\Auth\Requests\PreRegisterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class PreRegisterData extends DataTransferObject
{
    public ?string $email;

    public static function fromRequest(PreRegisterRequest $preRegisterRequest): self
    {
        return new self([
            'email' => $preRegisterRequest->input('email'),
        ]);
    }
}
