<?php
$title            = 'Nihon | Category';
$meta_description = 'where you can see all your current stories of the moment';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\darkmode.js", "public\asset\js\cart.js"];
ob_start();
?>
<?php
    var_dump($_SESSION["cart"]);
    echo "Je suis trop nul en PHP";
?>

<form action="/cart/clear" method="POST">
    <input type="submit" name="clear-cart" value="clear cart"/>
</form>
<form action="/cart/validate" method="POST">
    <input type="submit" name="validate-cart" value="Validate"/>
</form>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>