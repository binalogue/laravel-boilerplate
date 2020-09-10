<?php

namespace App\Platform\Users\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateProfileAvatarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.mimes' => __('validation.custom.avatar.mimes'),
            'avatar.max' => __('validation.custom.avatar.max'),
        ];
    }

    /** @throws \Illuminate\Validation\ValidationException */
    protected function failedValidation(Validator $validator): void
    {
        flash()->error($validator->errors()->getMessageBag()->first());

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
