<?php

namespace App\Platform\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowResetFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
