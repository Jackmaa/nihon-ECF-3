<?php
$title = 'Nihon | Category';
$meta_description = 'where you can see all your current stories of the moment';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\darkmode.js", "public\asset\js\cart.js"];
ob_start();

?>
<main class="pagecart">
    <div class="panier"></div>
    <?php
    var_dump($_SESSION["cart"]);

    ?>
    <h1>My Cart</h1>

    <div class="cartgrid">
        <div class="gap">
            <img class="battle" src="public\asset\img\horror\battleroyale.webp" alt="battleroyale">
            <div class="flexcenter">
                <p>Battle Royale</p>
                <p>Volume 1</p>
                <div class="trash">
                    <svg viewBox="0 0 40 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_570_2472)">
                            <path
                                d="M12.0714 1.6248C12.5536 0.624219 13.5446 0 14.625 0H25.375C26.4554 0 27.4464 0.624219 27.9286 1.6248L28.5714 2.9375H37.1429C38.7232 2.9375 40 4.2502 40 5.875C40 7.4998 38.7232 8.8125 37.1429 8.8125H2.85714C1.27679 8.8125 0 7.4998 0 5.875C0 4.2502 1.27679 2.9375 2.85714 2.9375H11.4286L12.0714 1.6248ZM2.85714 11.75H37.1429V41.125C37.1429 44.3654 34.5804 47 31.4286 47H8.57143C5.41964 47 2.85714 44.3654 2.85714 41.125V11.75ZM11.4286 17.625C10.6429 17.625 10 18.2859 10 19.0938V39.6562C10 40.4641 10.6429 41.125 11.4286 41.125C12.2143 41.125 12.8571 40.4641 12.8571 39.6562V19.0938C12.8571 18.2859 12.2143 17.625 11.4286 17.625ZM20 17.625C19.2143 17.625 18.5714 18.2859 18.5714 19.0938V39.6562C18.5714 40.4641 19.2143 41.125 20 41.125C20.7857 41.125 21.4286 40.4641 21.4286 39.6562V19.0938C21.4286 18.2859 20.7857 17.625 20 17.625ZM28.5714 17.625C27.7857 17.625 27.1429 18.2859 27.1429 19.0938V39.6562C27.1429 40.4641 27.7857 41.125 28.5714 41.125C29.3571 41.125 30 40.4641 30 39.6562V19.0938C30 18.2859 29.3571 17.625 28.5714 17.625Z"
                                fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_570_2472">
                                <rect width="40" height="47" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
        <div class="gap">
            <img class="battle" src="public\asset\img\horror\battleroyale.webp" alt="battleroyale">
            <div class="flexcenter">
                <p>Battle Royale</p>
                <p>Volume 1</p>
                <img class="trash" src="public\asset\img\trash.svg" alt="trash">
            </div>
        </div>

        <div class="gap">
            <img class="battle" src="public\asset\img\horror\battleroyale.webp" alt="battleroyale">
            <div class="flexcenter">
                <p>Battle Royale</p>
                <p>Volume 1</p>
                <img class="trash" src="public\asset\img\trash.svg" alt="trash">
            </div>
        </div>
    </div>
    <div class="flexcenter">
        <form class="form-cart" action="/cart/clear" method="POST">
            <input class="cartbutton" type="submit" name="clear-cart" value="Clear Cart" />
        </form>
        <form class="form-cart" action="/cart/validate" method="POST">
            <input class="cartbutton" type="submit" name="validate-cart" value="Validate" />
        </form>
    </div>
</main>
<?php


$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>