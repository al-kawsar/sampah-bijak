<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

trait ApiResponse
{
    /**
     * Format response success.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success($data = null, $message = 'Success', $statusCode = 200, $pagination = null): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        // Jika ada pagination, tambahkan metadata dan links
        if ($pagination) {
            $response['meta'] = $pagination['meta'];
            $response['links'] = $pagination['links'];
        }

        return response()->json($response, $statusCode, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Format response error.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error($message = 'Something went wrong', $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    /**
     * Format response not found.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function notFound($message = 'Resource not found', $statusCode = 404): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    /**
     * Format response for validation errors.
     *
     * @param array $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    public function validationError($errors, $statusCode = 422): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Format response for unauthorized access.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function unauthorized($message = 'Unauthorized', $statusCode = 401): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    /**
     * Format response for internal server error.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function internalServerError($message = 'Internal server error', $statusCode = 500, $errorDetails = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $errorDetails
        ], $statusCode);
    }

    /**
     * Handle a general exception.
     *
     * @param Throwable $exception
     * @return JsonResponse
     */
    public function handleException(Throwable $exception): JsonResponse
    {
        $statusCode = $this->getStatusCodeFromException($exception);
        $message = $exception->getMessage() ?: 'An error occurred';

        // Return a generic error response
        return $this->error($message, $statusCode);
    }

    /**
     * Get the status code based on the exception type.
     *
     * @param Throwable $exception
     * @return int
     */
    private function getStatusCodeFromException(Throwable $exception): int
    {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return 404;  // Not Found
        }

        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return 401;  // Unauthorized
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return 422;  // Validation Error
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return 404;  // Not Found
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
            return 403;  // Forbidden
        }

        return 500;  // Internal Server Error (default for unhandled exceptions)
    }
}
