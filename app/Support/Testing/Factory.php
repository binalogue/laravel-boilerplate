<?php

namespace Support\Testing;

use Christophrumpel\LaravelFactoriesReloaded\BaseFactory;

abstract class Factory extends BaseFactory
{
    public function raw(array $extra = []): array
    {
        return parent::build($extra, 'make')->toArray();
    }
}
