<?php
$title = 'Nihon | CONTACT';
$meta_description = 'Contact us for any questions or suggestions';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js"];
ob_start();
?>
    <main>
        
    </main>
    <?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>