<?php

namespace Support\Eloquent\Concerns;

use Keygen\Keygen;

trait HasRandomToken
{
    protected function initializeHasRandomToken(): void
    {
        if (property_exists($this, 'tokenWithTimestamps') && $this->tokenWithTimestamps) {
            $this->token = Keygen::numeric(7)->prefix(now()->format('ymd') . '-')->generate(true);
            return;
        }

        $this->token = Keygen::alphanum(7)->prefix(mt_rand(1, 9))->generate(true, 'strtoupper');
    }
}
