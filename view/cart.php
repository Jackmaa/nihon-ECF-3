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