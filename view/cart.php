<?php
    var_dump($_SESSION["cart"]);
    echo "Je suis trop nul en PHP";
?>

<form action="/cart/clear" method="post">
    <input type="submit" name="clear-cart" value="clear cart"/>
</form>