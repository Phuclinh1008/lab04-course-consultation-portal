<?php

namespace App\Controllers;

class CourseConsultationController
{
    private string $storage;

    public function __construct()
    {
        $this->storage =
            __DIR__
            . '/../../storage/consultations.json';
    }

    /*
    |--------------------------------------------------------------------------
    | List
    |--------------------------------------------------------------------------
    */

    public function index(): void
{
    $items = [];

    if (file_exists($this->storage)) {

        $json =
            file_get_contents(
                $this->storage
            );

        $items =
            json_decode(
                $json,
                true
            ) ?? [];
    }

    view('consultations/index', [
        'items' => $items
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    public function create(): void
    {
        view('consultations/create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(): void
    {
        $old = [
            'full_name' =>
                trim($_POST['full_name'] ?? ''),

            'email' =>
                trim($_POST['email'] ?? ''),

            'phone' =>
                trim($_POST['phone'] ?? ''),

            'course' =>
                trim($_POST['course'] ?? ''),

            'study_mode' =>
                trim($_POST['study_mode'] ?? ''),

            'goal' =>
                trim($_POST['goal'] ?? '')
        ];

        /*
        |--------------------------------------------------------------------------
        | Honeypot
        |--------------------------------------------------------------------------
        */

        if (
            !empty($_POST['website'])
        ) {

            flash_set(
                'error',
                'Spam detected.'
            );

            redirect(
                '/consultations/create'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Rate Limit
        |--------------------------------------------------------------------------
        */

        if (
            isset(
                $_SESSION['last_submit']
            )
            &&
            (
                time()
                -
                $_SESSION['last_submit']
            ) < 5
        ) {

            flash_set(
                'error',
                'Please wait 5 seconds before submitting again.'
            );

            redirect(
                '/consultations/create'
            );
        }

        $errors = [];

        /*
        |--------------------------------------------------------------------------
        | Required
        |--------------------------------------------------------------------------
        */

        if (
            strlen(
                $old['full_name']
            ) < 2
        ) {

            $errors['full_name']
                = 'Full name must contain at least 2 characters.';
        }

        if (
            !filter_var(
                $old['email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors['email']
                = 'Invalid email.';
        }

        if (
            !preg_match(
                '/^[0-9+\-\s]{8,15}$/',
                $old['phone']
            )
        ) {

            $errors['phone']
                = 'Invalid phone number.';
        }

        $courses = [
            'Web Development',
            'Data Analysis',
            'Digital Marketing',
            'UI/UX Design',
            'English Communication'
        ];

        if (
            !in_array(
                $old['course'],
                $courses
            )
        ) {

            $errors['course']
                = 'Invalid course.';
        }

        $modes = [
            'Online',
            'Offline',
            'Hybrid'
        ];

        if (
            !in_array(
                $old['study_mode'],
                $modes
            )
        ) {

            $errors['study_mode']
                = 'Invalid study mode.';
        }

        if (
            strlen(
                $old['goal']
            ) < 10
        ) {

            $errors['goal']
                = 'Goal must contain at least 10 characters.';
        }

        /*
        |--------------------------------------------------------------------------
        | Validation Failed
        |--------------------------------------------------------------------------
        */

        if (!empty($errors)) {

            flash_old_errors(
                $old,
                $errors
            );

            flash_set(
                'error',
                'Please correct the form.'
            );

            redirect(
                '/consultations/create'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save JSON
        |--------------------------------------------------------------------------
        */

        $items = [];

        if (file_exists($this->storage)) {

            $items =
                json_decode(
                    file_get_contents(
                        $this->storage
                    ),
                    true
                ) ?? [];
        }

        $items[] = [

            'id' =>
                'C'
                . str_pad(
                    count($items) + 1,
                    3,
                    '0',
                    STR_PAD_LEFT
                ),

            'full_name' =>
                $old['full_name'],

            'email' =>
                $old['email'],

            'phone' =>
                $old['phone'],

            'course' =>
                $old['course'],

            'study_mode' =>
                $old['study_mode'],

            'goal' =>
                $old['goal'],

            'status' =>
                'New',

            'created_at' =>
                date(
                    'Y-m-d H:i:s'
                )
        ];

        file_put_contents(
            $this->storage,
            json_encode(
                $items,
                JSON_PRETTY_PRINT
            )
        );

        $_SESSION['last_submit']
            = time();

        flash_set(
            'success',
            'Consultation submitted successfully.'
        );

        redirect('/consultations');
    }
}