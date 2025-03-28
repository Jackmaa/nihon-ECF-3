<?php
    $title            = 'Nihon | Login';
    $meta_description = 'log in to your "Nihon" account';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/login.js", "public\asset\js\darkmode.js", "public/asset/js/register.js"];
    ob_start();
?>
<main class="login">
<div class="cloud-content">
    <div class="cloud-1 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-2 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-3 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-4 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-5 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-6 cloud-block">
      <div class="cloud"></div>
    </div>
    <div class="cloud-7 cloud-block">
      <div class="cloud"></div>
    </div>
  </div>
    <section class="form-container">
        <h1> Connexion </h1>
        <form action="/login" method="post">
            <input type="text" name="credential" placeholder="Email or Username">
            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Password" >
                <button type="button" class="togglePassword"><img src="public\asset\img\oeilferme.svg" alt="oeil" class="eye-icon"> </button>
            </div>
            <p>no account yet ? <a class="clickhere" href="<?php echo $this->router->generate("register") ?>">Click here</a></p>
            <button class="loginconnexion" type="submit">LOG IN</button>
        </form>
    </section>
    <figure>
        <!-- <img id="img-connexion" src="public/asset/img/connexion.webp" alt="image connexion">
    </figure> -->
</main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view/base_html.php';
?>