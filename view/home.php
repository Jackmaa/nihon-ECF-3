<?php
    $title            = 'Nihon | Home';
    $meta_description = 'The best place to find your next manga\'s addiction ';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js"];
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

            <figure class="carousel-item"><img src="public\asset\img\ttttt.png" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></figure>
            <figure class="carousel-item"><img src="public\asset\img\ppkpojoi.png" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></figure>
            <figure class="carousel-item"><img src="public\asset\img\ouou.png" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></figure>
        </div>
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>
</section>

<section>
    <?php foreach ($mangas as $category => $manga): ?>
    <div class="category-slider">
        <h2><?php echo $category?></h2>
        <div class="slider">
            <div class="slider-wrapper">
                <?php foreach ($manga as $manga): ?>
                <div class="manga">
                    <a href="#"><img src="<?php echo $manga->getThumbnail()?>" alt=""><?php echo $manga->getName()?></a>
                    <span class="heart"><img src="public\asset\img\heart.svg" alt="Heart"></span>
                    <figure><img src="public\asset\img\star.svg" alt="">(300)</figure>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
<?php endforeach; ?>
</section>



<section id="our-fav">
    <div>
        <h2>Our favorites</h2><img src="public\asset\img\emptyheart.svg" alt="empty heart">
    </div>
    <div id="big-bubble-fav" >
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
</div>
</section>
<section>
    <div class="category-slider">
        <h2>Kodomo</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51-ngUbCgCL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51PAuxx-fyL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\61W4N3JE8GL._SX195_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Kilari-Star-tome-1_6963.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Nijika-actrice-de-reve-Tome-1-_1376.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Princesse-Kilala-T01_780.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51-ngUbCgCL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51PAuxx-fyL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\61W4N3JE8GL._SX195_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Kilari-Star-tome-1_6963.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Nijika-actrice-de-reve-Tome-1-_1376.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Princesse-Kilala-T01_780.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>

    <div class="category-slider">
        <h2>Shōnen</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\bleach.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public/asset/img/shonen/death_note.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\dragon_ball.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\naruto.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\fullmetal_alchemist.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\hunter_x_hunter.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>
    <div class="category-slider">
        <h2>Shōjo</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51-ngUbCgCL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51PAuxx-fyL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\61W4N3JE8GL._SX195_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Kilari-Star-tome-1_6963.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Nijika-actrice-de-reve-Tome-1-_1376.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Princesse-Kilala-T01_780.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>
    <div class="category-slider">
        <h2>Seinen</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\bleach.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public/asset/img/shonen/death_note.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\dragon_ball.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\naruto.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\fullmetal_alchemist.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\hunter_x_hunter.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>
    <div class="category-slider">
        <h2>Josei</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51-ngUbCgCL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\51PAuxx-fyL._SX210_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\61W4N3JE8GL._SX195_.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Kilari-Star-tome-1_6963.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Nijika-actrice-de-reve-Tome-1-_1376.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\kodomo\CVT_cvt_Princesse-Kilala-T01_780.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>
    <div class="category-slider">
        <h2>Seijin</h2>
        <div class="slider">
            <div class="slider-wrapper">
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\bleach.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public/asset/img/shonen/death_note.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\dragon_ball.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\naruto.webp" alt=""><figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\fullmetal_alchemist.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
                <div class="manga">
                    <a href="#"><img src="public\asset\img\shonen\hunter_x_hunter.webp" alt=""> <figure><img src="public\asset\img\heart_black_stroke.svg" alt="">300</figure></a>
                </div>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </div>
</section>
</body>

</html>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>