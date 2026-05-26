<?php

/*
|-------------------------------------------------------------------------------
| Register The Autoloader
|-------------------------------------------------------------------------------
|
| Composer generates a class loader that handles PSR-4 autoloading for all
| framework and application classes throughout the codebase.
|
*/

require __DIR__ . '/../vendor/autoload.php';

use Zen\Application;
use Zen\Http\Request;
use Zen\Http\Response;
use Zen\Auth\AuthServiceProvider;
use Zen\Cache\CacheServiceProvider;
use Zen\Config\ConfigServiceProvider;
use Zen\Console\ConsoleServiceProvider;
use Zen\Database\DatabaseServiceProvider;
use Zen\Encryption\EncryptionServiceProvider;
use Zen\Events\EventServiceProvider;
use Zen\Hashing\HashingServiceProvider;
use Zen\Logging\LoggingServiceProvider;
use Zen\Mail\MailServiceProvider;
use Zen\Middleware\AuthMiddleware;
use Zen\Middleware\CsrfMiddleware;
use Zen\Middleware\GuestMiddleware;
use Zen\Middleware\RateLimitMiddleware;
use Zen\Middleware\TokenAuthMiddleware;
use Zen\Queue\QueueServiceProvider;
use Zen\Routing\RoutingServiceProvider;
use Zen\Scheduling\SchedulingServiceProvider;
use Zen\Session\SessionServiceProvider;
use Zen\Storage\StorageServiceProvider;
use Zen\Validation\ValidatorServiceProvider;
use Zen\View\ViewServiceProvider;
use App\Providers\AppServiceProvider;

/*
|-------------------------------------------------------------------------------
| Create The Application
|-------------------------------------------------------------------------------
|
| Bootstraps the application, loads configuration, and registers all core
| service providers. The base path anchors all path helpers.
|
*/

$app = new Application(dirname(__DIR__));

/*
|-------------------------------------------------------------------------------
| Register Service Providers
|-------------------------------------------------------------------------------
|
| Register every provider your application needs. ConfigServiceProvider must
| come first — all others read config during their register() call.
| Remove any provider your project does not use.
|
*/

$app->registerProviders([
    new ConfigServiceProvider(),
    new EncryptionServiceProvider(),
    new HashingServiceProvider(),
    new SessionServiceProvider(),
    new AuthServiceProvider(),
    new CacheServiceProvider(),
    new DatabaseServiceProvider(),
    new EventServiceProvider(),
    new LoggingServiceProvider(),
    new RoutingServiceProvider(),
    new ViewServiceProvider(),
    new ValidatorServiceProvider(),
    new ConsoleServiceProvider(),
    new StorageServiceProvider(),
    new MailServiceProvider(),
    new QueueServiceProvider(),
    new SchedulingServiceProvider(),
    new AppServiceProvider(),
]);

/*
|-------------------------------------------------------------------------------
| Register Middleware Aliases
|-------------------------------------------------------------------------------
|
| Short names for middleware classes. Factories receive ($app, $params) so
| dependencies are resolved lazily at dispatch time.
|
*/

$app->registerMiddlewareAlias('csrf', function ($app) {
    return new CsrfMiddleware($app['session'], $app['view']);
});

$app->registerMiddlewareAlias('auth', function ($app) {
    return new AuthMiddleware($app['auth']);
});

$app->registerMiddlewareAlias('guest', function ($app) {
    return new GuestMiddleware($app['auth']);
});

$app->registerMiddlewareAlias('token', function ($app) {
    return new TokenAuthMiddleware($app['tokens'], $app['auth']);
});

$app->registerMiddlewareAlias('throttle', function ($app, $params) {
    return new RateLimitMiddleware(
        $app['cache'],
        (int) ($params[0] ?? 60),
        (int) ($params[1] ?? 60),
    );
});

/*
|-------------------------------------------------------------------------------
| Register Middleware Groups
|-------------------------------------------------------------------------------
|
| Bundle related aliases under a single name for cleaner route definitions.
|
*/

$app->registerMiddlewareGroup('web', ['csrf']);
$app->registerMiddlewareGroup('api', ['token']);

/*
|-------------------------------------------------------------------------------
| Register Global Middleware
|-------------------------------------------------------------------------------
|
| Middleware registered here runs on every request, wrapping the entire dispatch
| cycle. Use an alias string or a MiddlewareInterface instance.
|
*/

// $app->registerMiddleware('cors');

/*
|-------------------------------------------------------------------------------
| Register Error Handlers
|-------------------------------------------------------------------------------
|
| Each handler receives ($request, $response, $throwable) and must return a
| Response. Use $request->isJson() or $request->isAjax() to decide whether to
| render a view or return JSON.
|
*/

$app->registerErrorHandler(404, function (Request $request, Response $response, \Throwable $e): Response {
    if ($request->isJson() || $request->isAjax()) {
        return $response->status(404)->json(['message' => 'Not Found.']);
    }

    return $response->status(404)->body('Page not found.');
});

$app->registerErrorHandler(500, function (Request $request, Response $response, \Throwable $e): Response {
    if ($request->isJson() || $request->isAjax()) {
        return $response->status(500)->json(['message' => 'Server Error.']);
    }

    return $response->status(500)->body('Something went wrong.');
});
