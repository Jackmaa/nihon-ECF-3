<?php
    $title            = 'Nihon | Home';
    $meta_description = 'The best place to find your next manga\'s addiction ';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js"];
    ob_start();
?>

<section class="hero-mobile">
    <div class="carousel">
        <div class="carousel-wrapper">
            <div class="carousel-item">
                <p>“Now more books to borrow: 5 instead of 3!”</p>
                <p>“Extended loan duration: 4 weeks instead of 3!”</p>
                <button class="custom-btn btn-green"> <span>Kakkoii mode</span></button>
            </div>

            <figure class="carousel-item"><img src="public\asset\img\ttttt.png" alt="">
                <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure>
            </figure>
            <figure class="carousel-item"><img src="public\asset\img\ppkpojoi.png" alt="">
                <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure>
            </figure>
            <figure class="carousel-item"><img src="public\asset\img\ouou.png" alt="">
                <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure>
            </figure>
        </div>
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>
</section>

<section>
<?php foreach ($mangas as $category => $manga):
        if (count($manga) == 0) {
            continue;
    }?>
				<div class="category-slider">
				    <div class="category-title">
				        <h2><?php echo $category ?></h2>
				        <a href="#">See all</a>
				    </div>
				        <div class="slider">
				            <div class="slider-wrapper">
				                <?php foreach ($manga as $manga): ?>
				                <div class="manga">
				                    <a href="/manga/<?php echo $manga->getId_manga() ?>"><img src="<?php echo $manga->getThumbnail() ?>" alt="<?php echo $manga->getName() ?>">
				                        <figure>
				                            <svg class="like-btn" data-manga-id="<?php echo $manga->getId_manga(); ?>" width="33" height="33" viewBox="0 0 33 33" fill="red" xmlns="http://www.w3.org/2000/svg">
				                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4906 7.06174C13.7415 3.8478 9.15715 2.98326 5.71271 5.92627C2.26826 8.86928 1.78333 13.7898 4.48827 17.2706C6.73725 20.1645 13.5434 26.2681 15.7741 28.2436C16.0237 28.4647 16.1485 28.5752 16.294 28.6186C16.4211 28.6565 16.5601 28.6565 16.6871 28.6186C16.8327 28.5752 16.9575 28.4647 17.207 28.2436C19.4377 26.2681 26.2439 20.1645 28.4929 17.2706C31.1978 13.7898 30.7721 8.83832 27.2685 5.92627C23.7648 3.01422 19.2397 3.8478 16.4906 7.06174Z" stroke="#363333" stroke-linecap="round" stroke-linejoin="round"/>
				                            </svg>
				                            <span class="like-count"><?php echo $manga->getLikesCount(); ?></span>
				                        </figure>
				                    </a>
				                </div>
				                <?php endforeach; ?>
                </div>
                <button class="prev">❮</button>
        <button class="next">❯</button>
            </div>
    </div>
<?php endforeach; ?>

</section>

<section id="our-fav">
    <div>
        <h2>Our favorites</h2><img src="public\asset\img\emptyheart.svg" alt="empty heart">
    </div>
    <div id="big-bubble-fav">
        <div class="bubble-fav">
            <figure><img src="public\asset\img\naruto.webp" alt="Naruto"></figure>
            <div>
                <h3>Naruto</h3>
                <hr>
                <p>Twelve years before the start of the series, the Nine-Tails attacked Konohagakure, destroying much of the village and taking many lives. The leader of the village, the Fourth Hokage, sacrificed his life to seal the Nine-Tails into a newborn, Naruto Uzumaki. <a href="#">Read More...</a> </p>
            </div>

        </div>
        <div class="bubble-fav">
            <figure><img src="public\asset\img\shonen\bleach.webp" alt="Bleach"></figure>
            <div>
                <h3>Bleach</h3>
                <hr>
                <p>Ichigo Kurosaki is a teenager from Karakura Town who can see ghosts, a talent which lets him meet supernatural trespasser Rukia Kuchiki. Rukia is one of the Soul Reapers, soldiers trusted with ushering the souls of the dead from the World of the Living to the Soul Society. <a href="#">Read More...</a> </p>
            </div>
        </div>
        <div class="bubble-fav">
            <figure><img src="public\asset\img\shonen\death_note.webp" alt="Death Note"></figure>
            <div>
                <h3>Death Note</h3>
                <hr>
                <p>Light Yagami is a high school student who discovers the "Death Note", a notebook that kills anyone whose name is written in it, as long as the writer has seen the person's face. After experimenting with the notebook, Light meets the Shinigami Ryuk, the notebook's original owner, who dropped the notebook to relieve his boredom. <a href="#">Read More...</a> </p>
            </div>
        </div>
        <div class="bubble-fav">
            <figure><img src="public\asset\img\shonen\dragon_ball.webp" alt="Dragon Ball"></figure>
            <div>
                <h3>Dragon Ball</h3>
                <hr>
                <p>Dragon Ball follows the adventures of the protagonist Goku, a strong, naive boy who, upon meeting Bulma, sets out to gather the seven Dragon Balls. These Dragon Balls summon a wish-granting dragon when collected. <a href="#">Read More...</a></p>
            </div>
        </div>
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>
</div>

<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>