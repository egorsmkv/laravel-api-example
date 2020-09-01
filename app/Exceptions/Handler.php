<?php

namespace App\Exceptions;

use Exception;
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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
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
     * @param Exception $e
     *
     * @return mixed
     */
    public function render($request, Exception $e)
    {
        $requestURI = $request->getRequestUri();

        if ($e instanceof HttpException) {
            $code = (string)$e->getStatusCode();
            $message = (new Httpstatus())->getReasonPhrase($code);

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

            return app()->call('App\Http\Controllers\ErrorsController@process', $parameters);
        } else if ($e instanceof Exception) {
            $parameters = [
                'data' => [
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'version' => 'unknown'
                ]
            ];

            return app()->call('App\Http\Controllers\ErrorsController@process', $parameters);
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param mixed $request
     * @param AuthenticationException $exception
     *
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $parameters = [
            'data' => [
                'code' => 401,
                'message' => $exception->getMessage(),
                'url' => $request->getUri(),
                'version' => 'unknown'
            ]
        ];

        return app()->call('App\Http\Controllers\ErrorsController@process', $parameters);
    }
}
