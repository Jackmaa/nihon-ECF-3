<?php
$title = 'Nihon | CONTACT';
$meta_description = 'Contact us for any questions or suggestions';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public\asset\js\darkmode.js"];
ob_start();
?>

<main>

<figure class="flexcenter img-contact "></figure>


<form class=formulaire action="#" method="post">

<h2>Contact Us</h2>
    <input type="text" id="name" name="name" placeholder="Nom" required>

    <input type="email" id="email" name="email" placeholder="Email" required>

    <textarea id="message" name="message" rows="5" placeholder="Votre message" required></textarea>

    <button class=button type="submit">Submit</button>
</form>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once('view\base_html.php');
?>