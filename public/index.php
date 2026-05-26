<?php

/*
|-------------------------------------------------------------------------------
| Bootstrap The Application
|-------------------------------------------------------------------------------
*/

require __DIR__ . '/../bootstrap/app.php';

use Zen\Http\Request;
use Zen\Http\Response;

/*
|-------------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------------
|
| Define your web routes here. Every handler receives a Request and Response
| and must return a Response. Middleware can be attached per-route or per-group.
|
| Quick reference:
|   $app->get($uri, $callback)
|   $app->post($uri, $callback)
|   $app->put($uri, $callback)
|   $app->patch($uri, $callback)
|   $app->delete($uri, $callback)
|
| Route parameters use a colon prefix: /users/:id
| Access them via: $request->getRouteParam('id')
|
*/

$app->get('/', function (Request $request, Response $response) use ($app): Response {
    return $app->view('home');
})->middleware('csrf');

// — Basic view with data -------------------------------------------------------
//
// $app->get('/about', function (Request $request, Response $response) use ($app): Response {
//     return $app->view('about', ['title' => 'About Us']);
// })->middleware('csrf');

// — Route parameter ------------------------------------------------------------
//
// $app->get('/users/:id', function (Request $request, Response $response) use ($app): Response {
//     $id   = (int) $request->getRouteParam('id');
//     $user = $app['db']->table('users')->find($id);
//
//     if ($user === null) {
//         return $response->status(404)->body('User not found.');
//     }
//
//     return $app->view('users/show', compact('user'));
// })->middleware('csrf');

// — POST with validation -------------------------------------------------------
//
// use Zen\Validation\ValidationException;
//
// $app->post('/users', function (Request $request, Response $response) use ($app): Response {
//     try {
//         $data = $app->validator($request->all(), [
//             'name'  => 'required|min:2|max:100',
//             'email' => 'required|email|max:255',
//         ])->validate();
//     } catch (ValidationException $e) {
//         return $app->view('users/create', ['errors' => $e->errors(), 'old' => $request->only('name', 'email')]);
//     }
//
//     $id = $app['db']->table('users')->insert($data);
//
//     return $response->redirect("/users/{$id}");
// })->middleware('csrf', 'auth');

// — Auth middleware (require login / require guest) ----------------------------
//
// $app->get('/dashboard', function (Request $request, Response $response) use ($app): Response {
//     return $app->view('dashboard', ['user' => $app['auth']->user()]);
// })->middleware('csrf', 'auth');
//
// $app->get('/login', function (Request $request, Response $response) use ($app): Response {
//     return $app->view('auth/login');
// })->middleware('csrf', 'guest');

// — Redirect -------------------------------------------------------------------
//
// $app->get('/home', function (Request $request, Response $response) use ($app): Response {
//     return $response->redirect('/');
// });

// — Cache ----------------------------------------------------------------------
//
// $app->get('/stats', function (Request $request, Response $response) use ($app): Response {
//     $stats = $app['cache']->remember('stats', 300, function () use ($app): array {
//         return ['users' => $app['db']->table('users')->count()];
//     });
//
//     return $app->view('stats', compact('stats'));
// })->middleware('csrf');

// — Route group ----------------------------------------------------------------
//
// $app->group('/admin', ['middleware' => ['csrf', 'auth']], function () use ($app): void {
//
//     $app->get('/', function (Request $request, Response $response) use ($app): Response {
//         return $app->view('admin/index');
//     });
//
//     $app->get('/users', function (Request $request, Response $response) use ($app): Response {
//         $users = $app['db']->table('users')->get();
//         return $app->view('admin/users', compact('users'));
//     });
//
// });

/*
|-------------------------------------------------------------------------------
| API Routes — /api/*
|-------------------------------------------------------------------------------
|
| Stateless JSON endpoints. Authenticate with a Bearer token via the built-in
| 'token' middleware. No CSRF needed for token-authenticated routes.
|
*/

// — Public JSON endpoint -------------------------------------------------------
//
// $app->get('/api/ping', function (Request $request, Response $response) use ($app): Response {
//     return $response->json(['message' => 'pong']);
// });

// — Token-protected endpoint ---------------------------------------------------
//
// $app->get('/api/me', function (Request $request, Response $response) use ($app): Response {
//     return $response->json(['user' => $app['auth']->user()]);
// })->middleware('token');

// — Rate-limited endpoint ------------------------------------------------------
//
// $app->post('/api/items', function (Request $request, Response $response) use ($app): Response {
//     try {
//         $data = $app->validator($request->all(), [
//             'name' => 'required|max:255',
//         ])->validate();
//     } catch (\Zen\Validation\ValidationException $e) {
//         return $response->json(['errors' => $e->errors()], 422);
//     }
//
//     $id   = $app['db']->table('items')->insert($data);
//     $item = $app['db']->table('items')->find((int) $id);
//
//     return $response->json($item, 201);
// })->middleware('token', 'throttle:60,1');

/*
|-------------------------------------------------------------------------------
| Run The Application
|-------------------------------------------------------------------------------
*/

$app->run();
