<?php

namespace Support\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (App::environment('production')
            && $request->header('X-Inertia')
            && in_array($response->getStatusCode(), [403, 404, 500, 503])
        ) {
            return Inertia::render('ErrorPage', [
                'statusCode' => $response->getStatusCode(),
            ])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
        }

        return $response;
    }
}
