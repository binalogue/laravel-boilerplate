<?php

namespace App\Platform\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthPreRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];
    }
}
