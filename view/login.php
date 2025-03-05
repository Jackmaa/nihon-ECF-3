<?php
    $title            = 'Nihon | Login';
    $meta_description = 'log in to your "Nihon" account';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js"];
    ob_start();
?>
    <main class=connexion>

        <section class="form-container">
            <h1> Connexion </h1>
            <form action="/login" method="post">
                <input type="text" name="email" placeholder="Email">
                <div>
                    <input type="password" name="password"
                        placeholder="Password">
                </div>
                <p>no account yet ? <a class=clickhere href="">Click here</a></p>
                <button type="submit">LOG IN</button>
            </form>

        </section>
        <figure>
            <img id="img-connexion" src="public\asset\img\connexion.webp" alt="image connexion">
        </figure>
    </main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    require_once 'view\base_html.php';

?>