<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\CourseConsultationController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Session Security
|--------------------------------------------------------------------------
*/

$isHttps = (
    !empty($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] !== 'off'
);

session_name('COURSEPORTALSESSID');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

check_session_timeout();
check_session_context();

/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
*/

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get(
    '/consultations',
    [CourseConsultationController::class, 'index']
);

$router->get(
    '/consultations/create',
    [CourseConsultationController::class, 'create']
);

$router->post(
    '/consultations',
    [CourseConsultationController::class, 'store']
);

$router->get('/login', [AuthController::class, 'login']);

$router->post(
    '/login',
    [AuthController::class, 'handleLogin']
);

$router->post(
    '/logout',
    [AuthController::class, 'logout']
);

$router->get(
    '/dashboard',
    [DashboardController::class, 'index']
);

$router->get(
    '/session-demo',
    [DashboardController::class, 'sessionDemo']
);

$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);