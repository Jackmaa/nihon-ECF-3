<?php
    $title            = 'Nihon | Favorite Manga';
    $meta_description = 'Your favorite manga';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js"];
    ob_start();
?>
    <h2>COUCOU</h2>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>