<?php
$title = 'Nihon | DashBoardLogin';
$meta_description = 'log in to your "Nihon" account';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/login.js", "public/asset/js/darkmode.js", "public/asset/js/register.js"];
ob_start();
?>

<main class="admin-login">
    <h1>Login</h1>
    <form class="admin-login-form" method="POST" action="/dashboard-access">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? '' ?>">
        <label for="username">Username:</label>
        <input type="text" name="credential" required placeholder="Username">
        <label for="password">Password:</label>
        <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Password" minlength="8" required aria-errormessage='password-error' pattern="^(?=.*[A-Za-z])(?=.*\d).+$">
            <button type="button" class="togglePassword"><img src="public\asset\img\oeilferme.svg" alt="oeil"
                    class="eye-icon"> </button>
        </div>
        <p>(8 caractères minimums)</p>

        <button class="buttonlogin" type="submit">Login</button>
    </form>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>