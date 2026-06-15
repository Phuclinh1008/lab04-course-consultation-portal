<?php

function h(?string $value): string
{
    return htmlspecialchars(
        $value ?? '',
        ENT_QUOTES,
        'UTF-8'
    );
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

function view(
    string $view,
    array $data = []
): void
{
    $viewFile = $view;

    extract($data);

    require __DIR__
        . '/../../views/layout.php';
}

function view_path(
    string $view
): string
{
    return __DIR__
        . '/../../views/'
        . $view
        . '.php';
}

function flash_set(
    string $key,
    mixed $value
): void
{
    $_SESSION['_flash'][$key] = $value;
}

function flash_get(
    string $key,
    mixed $default = null
): mixed
{
    $value =
        $_SESSION['_flash'][$key]
        ?? $default;

    unset($_SESSION['_flash'][$key]);

    return $value;
}

function old(
    string $key,
    string $default = ''
): string
{
    return $_SESSION['_old'][$key]
        ?? $default;
}

function errors(
    string $field
): ?string
{
    return $_SESSION['_errors'][$field]
        ?? null;
}

function flash_old_errors(
    array $old,
    array $errors
): void
{
    $_SESSION['_old'] = $old;
    $_SESSION['_errors'] = $errors;
}

function clear_old_errors(): void
{
    unset($_SESSION['_old']);
    unset($_SESSION['_errors']);
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {

        flash_set(
            'error',
            'Please login first.'
        );

        redirect('/login');
    }
}

function check_session_timeout(): void
{
    $idleLimit = 20; // Demo timeout 20 giây

    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $last =
        $_SESSION['last_activity_at']
        ?? time();

    if (
        time() - $last > $idleLimit
    ) {

        $_SESSION = [];

        flash_set(
            'error',
            'Your session has expired due to inactivity. Please login again.'
        );

        redirect('/login');
    }

    $_SESSION['last_activity_at']
        = time();
}

function check_session_context(): void
{
    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $currentAgent =
        $_SERVER['HTTP_USER_AGENT']
        ?? '';

    $savedAgent =
        $_SESSION['user_agent']
        ?? '';

    if (
        $savedAgent !== ''
        &&
        $savedAgent !== $currentAgent
    ) {

        logout_clean();

        session_start();

        flash_set(
            'error',
            'Session mismatch detected.'
        );

        redirect('/login');
    }
}

function logout_clean(): void
{
    $_SESSION = [];

    if (
        ini_get('session.use_cookies')
    ) {

        $params =
            session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}