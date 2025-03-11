<?php
    $title            = 'Nihon | My Current Stories';
    $meta_description = 'where you can see all your current stories of the moment';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\current.js", "public\asset\js\darkmode.js"];
    ob_start();
?>
<main>
    <section class="bann-setting">
        <a href="<?php echo $this->router->generate("myProfile", ['id' => $_SESSION['id_user']]) ?>">‹ Back to my Profile</a>
        <h3>My Current Stories</h3>
    </section>
    <figure class="current-desktop"> 
        <img src="<?php echo BASE_URL ?>public\asset\img\current-active.svg" alt="">
    </figure>
    <section>
        <div class="card-current">
            <div class="current-storie">
                <figure><img src="<?php echo BASE_URL ?>public\asset\img\shojo\thomas.webp" alt=""></figure>
                <div class="current-info">
                    <h4>Le Coeur de thomas</h4>
                    <div>
                        <a href="#">catégory:<span>Shojo</span></a>
                        <a href="#">Author: <span>Akira Toriyama</span></a>
                        <a href="#">Editor: <span>Shueisha</span></a>
                    </div>
                </div>
            </div>
            <div class="chevron-container">
            <div class="chevron-current">
                <p><span>5</span> Days left</p>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="chevron-content" >
                <p>coucou</p>
                <p>Tu veux voir mon git ?</p>
            </div>
        </div>
        </div>
        <div class="card-current">
        <div class="current-storie">
            <figure><img src="<?php echo BASE_URL ?>public\asset\img\shonen\fairytail.webp" alt=""></figure>
            <div class="current-info">
                <h4>Fairy Tail</h4>
                <div>
                    <a href="#">catégory: <span> Shonen</span></a>
                    <a href="#">Author: <span>Hiro Mashima</span></a>
                    <a href="#">Editor: <span>Pika</span></a>
                </div>
            </div>
        </div>
            <div class="chevron-container">
            <div class="chevron-current">
                <p><span>5</span> Days left</p>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="chevron-content" >
                <p>coucou</p>
                <p>Tu veux voir mon git ?</p>
            </div>
        </div>
    </div>
    <div class="card-current">
        <div class="current-storie">
            <figure><img src="<?php echo BASE_URL ?>public\asset\img\shonen\onepiece.webp" alt=""></figure>
            <div class="current-info">
                <h4>One Piece</h4>
                <div>
                    <a href="#">catégory:<span>Seinen</span></a>
                    <a href="#">Author: <span>Eiichiro Oda</span></a>
                    <a href="#">Editor: <span>Glénat</span></a>
                </div>
            </div>
        </div>
            <div class="chevron-container">
            <div class="chevron-current">
                <p><span>5</span> Days left</p>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="chevron-content" >
                <p>coucou</p>
                <p>Tu veux voir mon git ?</p>
            </div>
        </div>
    </div>

    </section>
</main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>