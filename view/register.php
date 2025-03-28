<?php
$title            = 'Nihon | Register';
$meta_description = 'Register your "Nihon" account';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/login.js", "public/asset/js/darkmode.js", "public/asset/js/register.js"];
ob_start();
?>
<main class="connexion">
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
  <div class="form-container">
    <h1> Subscription </h1>
    <form action="/register" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" id="email" placeholder="john.doe@example.com" required aria-errormessage='email-error'>
    <div class="error" id='email-error' aria-live="polite">Please enter a valid email address</div>
      <div class="password-container">
        <input type="password" name="password" id="password" placeholder="Password" minlength="8" required aria-errormessage='password-error' pattern="^(?=.*[A-Za-z])(?=.*\d).+$">
        <button type="button" class="togglePassword"><img src="public/asset/img/oeilferme.svg" alt="oeil" class="eye-icon"> </button>
      </div>
      <input type="password" name="password_verify" placeholder="Confirm Password">
      <p>(8 caractères minimums)</p>
      <p>You have already an account ? <a href="<?php echo $this->router->generate("login") ?>">Click here</a></p>
      <button class="loginregister" type="submit">SUBSCRIRE</button>
    </form>
  </div>
  <!-- <figure><img id="img-subscrire" src="public/asset/img/subscrire.webp" alt="image subscrire"></figure> -->
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>