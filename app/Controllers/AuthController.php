<?php

namespace App\Controllers;

class AuthController
{
    public function login(): void
    {
        view('auth/login');
    }

    public function handleLogin(): void
    {
        $email =
            trim(
                $_POST['email']
                ?? ''
            );

        $password =
            trim(
                $_POST['password']
                ?? ''
            );

        if (
            empty($email)
            ||
            empty($password)
        ) {

            flash_set(
                'error',
                'Email and password are required.'
            );

            redirect('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | Demo Account
        |--------------------------------------------------------------------------
        */

        if (
            $email
                !==
            'admin@courseportal.com'
            ||
            $password
                !==
            '123456'
        ) {

            flash_set(
                'error',
                'Invalid credentials.'
            );

            redirect('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        session_regenerate_id(
            true
        );

        $_SESSION['user_id']
            = 1;

        $_SESSION['name']
            = 'Course Consultant';

        $_SESSION['role']
            = 'admin';

        $_SESSION['login_at']
            = time();

        $_SESSION['last_activity_at']
            = time();

        $_SESSION['user_agent']
            =
            $_SERVER[
                'HTTP_USER_AGENT'
            ] ?? '';

        flash_set(
            'success',
            'Login successful.'
        );

        redirect('/dashboard');
    }

    public function logout(): void
    {
        logout_clean();

        session_start();

        flash_set(
            'success',
            'Logged out successfully.'
        );

        redirect('/login');
    }
}