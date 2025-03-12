<?php
$title = 'Nihon | Kakoii Mode';
$meta_description = 'Activate Kakoii Mode';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/kakoii.js", "public\asset\js\darkmode.js"];
ob_start();
?>
<section class="formkakoii">
    <div class="headkakkoii"></div>
    <main class="kakkoii">

        <div class="flexcenter">
            <h1>ACTIVATE KAKKOII MODE !</h1>
        </div>
        <div class="wrapper">
            <div class="char-kakkoii">
                <img src="public/asset/img/check.svg" alt="check">
                <p>More books that can be borrowed: 5 instead of 3 !</p>
            </div>
            <div class="char-kakkoii">
                <img src="public/asset/img/check.svg" alt="check">
                <p>Extended loan duration: 4 weeks instead of 3 !</p>
            </div>
            <div class="char-kakkoii">
                <img src="public/asset/img/check.svg" alt="check">
                <p>Exclusive access to special titles !</p>
            </div>
            <div class="char-kakkoii">
                <img src="public/asset/img/check.svg" alt="check">
                <p>Personalized notifications for new arrivals !</p>
            </div>
        </div>
        <div class="kakkoiiflex">
            <div class="center">
                <h2>KAKKOII MONTHLY</h2>
                <p>9.99$</p>
                <button class="open-popup" data-popup="popupMonthly">Buy now</button>
            </div>

            <div class="center">
                <h2>KAKKOII ANNUAL</h2>
                <p>99.99$</p>
                <p>$19.89 Savings</p>
                <button class="open-popup" data-popup="popupAnnual">Buy now</button>
            </div>
        </div>
        <!-- Popups -->
        <div class="overlay" id="overlay"></div>

        <div class="popup" id="popupMonthly">
            <div class="headkakkoiilogo"></div>
            <h3>KAKKOII MONTHLY</h3>
            <p>Subscribe to the monthly plan for 9.99$</p>
            <h2>Formulaire de Paiement</h2>
            <form action="/submit-payment" method="post">
                <div class="form-group">
                    <label for="card-number"> <img src="public\asset\img\carte.svg" alt="carte"> Numéro de Carte de
                        Crédit:</label>
                    <input type="number" id="card-number" name="card-number" required>
                </div>
                <div class="form-group">
                    <label for="expiry-date"> <img src="public\asset\img\date.svg" alt="date"> Date
                        d'Expiration:</label>
                    <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/AA" required>
                </div>
                <div class="form-group">
                    <label for="cvv"> <img src="public\asset\img\codesecu.svg" alt="code"> Code de Sécurité
                        (CVV):</label>
                    <input type="password" id="cvv" name="cvv" required>
                </div>
            </form>
            <button class="close-popup">Pay 9.99$</button>
        </div>

        <div class="popup" id="popupAnnual">
            <div class="headkakkoiilogo"></div>
            <h3>KAKKOII ANNUAL</h3>
            <p>Subscribe to the annual plan for 99.99$</p>
            <h2>Formulaire de Paiement</h2>
            <form action="/submit-payment" method="post">
                <div class="form-group">
                    <label for="card-number"> <img src="public\asset\img\carte.svg" alt="carte"> Numéro de Carte de Crédit:</label>
                    <input type="number" id="card-number" name="card-number" required>
                </div>
                <div class="form-group">
                    <label for="expiry-date"> <img src="public\asset\img\date.svg" alt="date"> Date d'Expiration:</label>
                    <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/AA" required>
                </div>
                <div class="form-group">
                    <label for="cvv"> <img src="public\asset\img\codesecu.svg" alt="code">Code de Sécurité (CVV):</label>
                    <input type="password" id="cvv" name="cvv" required>
                </div>
            </form>
            <button class="close-popup">Pay 99.99$</button>
        </div>

    </main>
</section>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>