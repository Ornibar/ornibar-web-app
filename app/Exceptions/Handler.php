<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
    }


    // /**
    //  * Report or log an exception.
    //  *
    //  * @param  \Throwable  $exception
    //  * @return void
    //  *
    //  * @throws \Exception
    //  */
    // public function report(Throwable $exception)
    // {
    //     parent::report($exception);
    // }

    // public function render($request, Throwable $exception)
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'error' => 'Unauthenticated'
    //         ], JsonResponse::HTTP_UNAUTHORIZED);
    //     }

    //     if ($exception instanceof MethodNotAllowedHttpException) {
    //         abort(JsonResponse::HTTP_METHOD_NOT_ALLOWED, 'Method not allowed');
    //     }

    //     if ($request->isJson() && $exception instanceof ValidationException) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => [
    //                 'errors' => $exception->getMessage(),
    //                 'fields' => $exception->validator->getMessageBag()->toArray()
    //             ]
    //         ], JsonResponse::HTTP_PRECONDITION_FAILED);
    //     }

    //     return parent::render($request, $exception);
    // }

}
