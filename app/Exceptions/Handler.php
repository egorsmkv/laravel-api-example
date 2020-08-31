<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Controllers\ErrorsController;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * @param Request $request
     * @param Exception $e
     *
     * @return mixed
     */
    public function render($request, Exception $e)
    {
        $requestURI = $request->getRequestUri();

        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            $parameters = [
                'data' => [
                    'code' => $code,
                    'message' => Response::$statusTexts[$code],
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
     * @param Request $request
     * @param AuthenticationException $exception
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return app()->call('App\Http\Controllers\ErrorsController@loginRequired');
        }

        return redirect()->guest('login');
    }
}
