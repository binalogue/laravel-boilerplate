<?php

namespace Support\Exceptions;

use Exception as BaseException;
use Illuminate\Support\Facades\Redirect;

class Exception extends BaseException
{
    public function __construct()
    {
        $this->message = __('exceptions.default');
    }

    public function render($request)
    {
        flash([
            'status' => $this->message,
            'isError' => true,
        ]);

        return Redirect::back();
    }
}
