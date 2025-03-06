<?php
$title            = 'Nihon | Login';
$meta_description = 'log in to your "Nihon" account';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/login.js"];
ob_start();
?>





<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>
