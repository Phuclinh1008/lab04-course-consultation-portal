<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Mini Course Consultation Portal
    </title>

    <link rel="stylesheet"
          href="/assets/style.css">
</head>

<body>

<nav class="navbar">

    <div class="logo">
        Mini Course Consultation Portal
    </div>

    <div class="menu">

        <a href="/">Home</a>

        <a href="/consultations">
            Consultations
        </a>

        <a href="/consultations/create">
            New Request
        </a>

        <a href="/dashboard">
            Dashboard
        </a>

        <a href="/login">
            Login
        </a>

        <?php if(is_logged_in()): ?>

            <form method="POST"
                  action="/logout"
                  class="inline-form">

                <button type="submit">
                    Logout
                </button>

            </form>

        <?php endif; ?>

    </div>

</nav>

<main class="container">

    <?php if($success = flash_get('success')): ?>
        <div class="alert success">
            <?= h($success) ?>
        </div>
    <?php endif; ?>

    <?php if($error = flash_get('error')): ?>
        <div class="alert error">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <?php require view_path($viewFile); ?>

</main>

</body>
</html>