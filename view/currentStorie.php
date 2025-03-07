<?php
$title            = 'Nihon | My Profile ';
$meta_description = 'it\'s your profile, your profile is incredible like a manga';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\header.js", "public\asset\js\profile.js"];
ob_start();
?>
<main>
    <section class="bann-setting" >
        <a href="<?php echo $this->router->generate("myProfile") ?>">‹ My current stories</a>
    </section>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>