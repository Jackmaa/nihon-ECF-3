<?php
    $title            = 'Nihon | Register';
    $meta_description = 'Register your "Nihon" account';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js","public\asset\js\login.js"];
    ob_start();
?>
    <main class=connexion>
        <div class="form-container">
            <h1> Subscription </h1>
            <form action="/register" method="POST">
                <input type="text" name="username" placeholder="Username">
                <input type="email" name="email" placeholder="Email">
                <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" >
                <button type="button" class="togglePassword"><img src="public\asset\img\oeilferme.svg" alt="oeil" class="eye-icon"> </button>
            </div>
                <input type="password" name="password_verify" placeholder="Confirm Password">
                
                <p>(8 caractères minimums)</p>
                <p>You have already an account ? <a href="">Click here</a></p>
                <button class="login" type="submit">SUBSCRIRE</button>
            </form>
        </div>
        <figure><img id="img-subscrire" src="public\asset\img\subscrire.webp" alt="image subscrire"></figure>
    </main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>