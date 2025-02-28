<?php
$title = 'Nihon | Register';
$meta_description = 'Register your "Nihon" account';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js"];
ob_start();
?>
    <main class=connexion>
        <div class="form-container">
            <h1> Subscription </h1>
            <form action="/nihon/register" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="password_verify" placeholder="Confirm Password">
                <p>(8 caractères minimums)</p>
                <p>You have already an account ? <a href="">Click here</a></p>
                <button type="submit">SUBSCRIRE</button>
            </form>
        </div>
        <figure><img id="img-subscrire" src="public\asset\img\subscrire.webp" alt="image subscrire"></figure>
    </main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once('view\base_html.php');
?>