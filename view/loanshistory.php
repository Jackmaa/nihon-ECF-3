<?php
$title            = 'Nihon | Login';
$meta_description = 'log in to your "Nihon" account';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/login.js"];
ob_start();
?>

<div class="headkakkoii"></div>
<main class="kakkoii">

<div class="flexcenter">
<h1>ACTIVATE KAKKOII MODE !</h1>
</div>
<div class="wrapper">
    <div class="char-kakkoii" >
    <img src="public\asset\img\check.svg" alt="check"><p>More books that can be borrowed: 5 instead of 3 !</p>
    </div>
    <div class="char-kakkoii">
    <img src="public\asset\img\check.svg" alt="check"><p>Extended loan duration: 4 weeks instead of 3 !</p>
    </div>
    <div class="char-kakkoii">
    <img src="public\asset\img\check.svg" alt="check"><p>Exclusive access to special titles !</p>
    </div>
    <div class="char-kakkoii">
    <img src="public\asset\img\check.svg" alt="check"><p>Personalized notifications for new arrivals !</p>
    </div>
</div>



<div class="center">
    <h2>KAKKOII MONTHLY</h2>
    <P>9.99$</P>
    <button>Buy now</button>
</div>

<div class="center">
    <h2>KAKKOII ANNUAL</h2>
    <P>99.99$</P>
    <P>$19.89 Savings</P>
    <button>Buy now</button>
</div>




















</main>



<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>
