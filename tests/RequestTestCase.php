<?php

namespace Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Validation\Factory as Validator;

abstract class RequestTestCase extends TestCase
{
    protected Validator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = App::get('validator');
    }

    protected function validate(array $attributes): bool
    {
        return $this->validator
            ->make($attributes, $this->rules)
            ->passes();
    }

    protected function overwriteDefaults(array $attributes): array
    {
        return array_merge($this->getDefaults(), $attributes);
    }

    protected function getDefaults(): array
    {
        return [];
    }
}
