<?php

namespace App\Platform\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['string', 'email', 'max:255', 'unique:users'],
        ];
    }
}
