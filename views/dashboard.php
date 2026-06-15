<h2>Consultant Dashboard</h2>

<div class="dashboard">

    <div class="card">

        <h3>User</h3>

        <p>
            <?= h($_SESSION['name']) ?>
        </p>

    </div>

    <div class="card">

        <h3>Role</h3>

        <p>
            <?= h($_SESSION['role']) ?>
        </p>

    </div>

    <div class="card">

        <h3>Login Time</h3>

        <p>
            <?= date(
                'Y-m-d H:i:s',
                $_SESSION['login_at']
            ) ?>
        </p>

    </div>

    <div class="card">

        <h3>Last Activity</h3>

        <p>
            <?= date(
                'Y-m-d H:i:s',
                $_SESSION['last_activity_at']
            ) ?>
        </p>

    </div>

</div>

<p>
    Session Status:
    Logged In
</p>

<a href="/session-demo">
    View Session Debug
</a>