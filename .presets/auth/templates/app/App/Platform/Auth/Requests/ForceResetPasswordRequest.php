<?php

namespace App\Platform\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForceResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }
}
