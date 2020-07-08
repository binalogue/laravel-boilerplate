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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response|\Inertia\Response
     *
     * @throws \Throwable
     */
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
