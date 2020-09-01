<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Lukasoppermann\Httpstatus\Httpstatus;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $exception
     *
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param mixed $request
     * @param Throwable $e
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        $requestURI = $request->getRequestUri();

        if ($e instanceof HttpException) {
            $headers = $e->getHeaders();
            $isBasicHttpAuth = Arr::has($headers, 'WWW-Authenticate');
            $code = (string)$e->getStatusCode();
            $message = (new Httpstatus())->getReasonPhrase($code);

            if ($isBasicHttpAuth) {
                return parent::render($request, $e);
            }

            $parameters = [
                'data' => [
                    'code' => $code,
                    'message' => $message,
                    'version' => 'unknown'
                ]
            ];

            if (Str::startsWith($requestURI, '/api/v1')) {
                $parameters['data']['version'] = 'v1';
            }
        } else {
            $parameters = [
                'data' => [
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'version' => 'unknown'
                ]
            ];
        }

        if (config('app.errors_as_json')) {
            return app()->call('App\Http\Controllers\ErrorsController@process', $parameters);
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param mixed $request
     * @param AuthenticationException $e
     *
     * @return mixed
     *
     * @throws Throwable
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        if (config('app.errors_as_json')) {
            $parameters = [
                'data' => [
                    'code' => 401,
                    'message' => $e->getMessage(),
                    'url' => $request->getUri(),
                    'version' => 'unknown'
                ]
            ];

            return app()->call('App\Http\Controllers\ErrorsController@process', $parameters);
        }

        return parent::render($request, $e);
    }
}
