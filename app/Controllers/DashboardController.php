<?php

namespace App\Controllers;

class DashboardController
{
    public function index(): void
    {
        require_login();

        view('dashboard');
    }

    public function sessionDemo(): void
    {
        require_login();

        header(
            'Content-Type: text/plain'
        );

        print_r($_SESSION);
    }
}