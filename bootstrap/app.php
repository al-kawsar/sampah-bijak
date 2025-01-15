<?php

use App\Http\Middleware\checkRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware) {
    $middleware->statefulApi();

    $middleware->web(append: [
        HandleInertiaRequests::class,
    ]);

    $middleware->alias([
        'role' => checkRole::class,
        'LaravelPwa' => \Ladumor\LaravelPwa\LaravelPwa::class,
        'Image' => Intervention\Image\Facades\Image::class,
    ]);

    $middleware->redirectGuestsTo(function (Request $request) {
        return route('auth.login.index');
    });

        // $middleware->validateCsrfTokens(except: [
        // ]);
})
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
        if (!app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
            return Inertia::render('Errors/Index', [
                'status' => $response->getStatusCode()
            ])
            ->toResponse($request)
            ->setStatusCode($response->getStatusCode());
        } elseif ($response->getStatusCode() === 419) {
            return back()->with([
                'message' => 'The page expired, please try again.',
            ]);
        }

        return $response;
    });
    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Record not found.'
            ], 404);
        }
    });

})->create();
