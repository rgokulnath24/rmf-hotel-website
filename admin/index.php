<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

$rememberUser =
    $_COOKIE['remember_user'] ?? '';

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | RMF Admin</title>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="css/login.css"
    >

</head>

<body>

<div class="login-page">

    <div class="login-brand">

        <img
            src="../images/logo.png"
            alt="Rajamadhi Foods"
        >

    </div>


    <div class="login-card">

        <div class="login-heading">

            <span>RMF ADMIN</span>

            <h1>Welcome back</h1>

            <p>
                Sign in to manage your restaurant menu.
            </p>

        </div>


        <form
            method="POST"
            action="login_credentials.php"
        >

            <div class="input-group">

                <label>
                    Username
                </label>

                <div class="input-wrapper">

                    <i class="fa-regular fa-user"></i>

                    <input
                        type="text"
                        name="username"
                        placeholder="Enter username"
                        value="<?= htmlspecialchars($rememberUser) ?>"
                        required
                    >

                </div>

            </div>


            <div class="input-group">

                <label>
                    Password
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Enter password"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword()"
                    >
                        <i
                            id="passwordIcon"
                            class="fa-regular fa-eye"
                        ></i>
                    </button>

                </div>

            </div>


            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                >

                <span>Remember username</span>

            </label>


            <button
                type="submit"
                class="login-btn"
            >
                Sign In
                <i class="fa-solid fa-arrow-right"></i>
            </button>

        </form>

    </div>


    <p class="login-footer">
        © 2026 Rajamadhi Foods
    </p>

</div>


<script>

function togglePassword() {

    const input =
        document.getElementById("password");

    const icon =
        document.getElementById("passwordIcon");

    if (input.type === "password") {

        input.type = "text";

        icon.className =
            "fa-regular fa-eye-slash";

    } else {

        input.type = "password";

        icon.className =
            "fa-regular fa-eye";

    }

}

</script>

</body>
</html>