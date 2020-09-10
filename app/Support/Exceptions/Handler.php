<?php

namespace Support\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as BaseHandler;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Throwable;

class Handler extends BaseHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /** @throws \Exception */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /** @throws \Throwable */
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        if (App::environment('production')
            && $request->header('X-Inertia')
            && in_array($response->status(), [403, 404, 500, 503])
        ) {
            return Inertia::render('ErrorPage', [
                'statusCode' => $response->status(),
            ])
                ->toResponse($request)
                ->setStatusCode($response->status());
        }

        return $response;
    }
}
