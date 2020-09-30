<?php

namespace Support\Eloquent\Concerns;

use Illuminate\Support\Facades\Auth;

trait HasCreator
{
    protected function initializeHasCreator(): void
    {
        $this->created_by_user_id = Auth::id();
    }
}
