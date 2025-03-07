<?php
    $title            = 'Nihon | ' . $manga->manga->getName();
    $meta_description = $manga->manga->getName() . 'it a great manga';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\header.js", "public\asset\js\like.js"];
    ob_start();
?>
<main>
    <section>
        <div class="mangaPage-frst-section">
            <div class="mangaPage">
                <img src=".<?php echo $manga->manga->getThumbnail(); ?>" alt="<?php echo $manga->manga->getName(); ?>">
                <h2><?php echo $manga->manga->getName(); ?></h2>
                <svg class="like-btn" data-manga-id="<?php echo $manga->manga->getId_manga(); ?>" width="33" height="33" viewBox="0 0 33 33" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4906 7.06174C13.7415 3.8478 9.15715 2.98326 5.71271 5.92627C2.26826 8.86928 1.78333 13.7898 4.48827 17.2706C6.73725 20.1645 13.5434 26.2681 15.7741 28.2436C16.0237 28.4647 16.1485 28.5752 16.294 28.6186C16.4211 28.6565 16.5601 28.6565 16.6871 28.6186C16.8327 28.5752 16.9575 28.4647 17.207 28.2436C19.4377 26.2681 26.2439 20.1645 28.4929 17.2706C31.1978 13.7898 30.7721 8.83832 27.2685 5.92627C23.7648 3.01422 19.2397 3.8478 16.4906 7.06174Z" stroke="#363333" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="like-count"><?php echo $manga->manga->getLikesCount(); ?></span>
            </div>
            <div class="summary-desktop">
                <div class="sum-manga">
                    <h2>In Summary...</h2>
                    <p>"<?php echo $manga->manga->getDescription() ?>"</p>
                </div>
                <div class="char-manga">
                    <div>
                        <p>category :</p> <a href="#"><?php echo $manga->categories ?></a>
                    </div>
                    <div>
                        <p>Author : </p><a href="#"><?php echo $manga->author ?></a>
                    </div>
                    <div>
                        <p>Editor : </p><a href="#"><?php echo $manga->editor ?></a>
                    </div>
                </div>
    </section>
    <div class="mangaPage-scd-section">
        <div class="comm-desktop" >
        <section class="review">
                <h2>review</h2>
                <div class="cadre-review">
                    <div class="cadre-profile">
                        <img class="profile-picture" src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture">
                        <p>DarkSasuke78</p>
                    </div>
                    <div class="comm">
                        <p>Naruto is more than a manga, it's a life lesson! His journey, his determination, his values… It’s impossible not to be inspired!</p>
                    </div>
                </div>
                <hr>
                <div class="cadre-review">
                    <div class="cadre-profile">
                        <img class="profile-picture" src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture">
                        <p>DarkSasuke78</p>
                    </div>
                    <div class="comm">
                        <p>Naruto is more than a manga, it's a life lesson! His journey, his determination, his values… It’s impossible not to be inspired!</p>
                    </div>
                </div>
                <hr>
                <div class="cadre-review">
                    <div class="cadre-profile">
                        <img class="profile-picture" src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture">
                        <p>DarkSasuke78</p>
                    </div>
                    <div class="comm">
                        <p>Naruto is more than a manga, it's a life lesson! His journey, his determination, his values… It’s impossible not to be inspired!</p>
                    </div>
                </div>
                <hr>
                <div class="cadre-review">
                    <div class="cadre-profile">
                        <img class="profile-picture" src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture">
                        <p>DarkSasuke78</p>
                    </div>
                    <div class="comm">
                        <p>Naruto is more than a manga, it's a life lesson! His journey, his determination, his values… It’s impossible not to be inspired!</p>
                    </div>
                </div>
                <hr>
                <div class="cadre-review">
                    <div class="cadre-profile">
                        <img class="profile-picture" src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture">
                        <p>DarkSasuke78</p>
                    </div>
                    <div class="comm">
                        <p>Naruto is more than a manga, it's a life lesson! His journey, his determination, his values… It’s impossible not to be inspired!</p>
                    </div>
                </div>
                <hr>
        </section>
        <div id="leave-review">
            <input type="text"><button>Leave a review</button>
        </div>
        </div>
        <section class="also-liked">
            <h2><?php echo $manga->manga->getName() ?> Readers also liked</h2>
            <div class="also-liked-contain">
                <div>
                    <figure><img src="<?php echo BASE_URL ?>public\asset\img\shonen\chainsawman.webp" alt="Berserk"></figure>
                    <p>chainsawman</p>
                </div>
                <div>
                    <figure><img src="<?php echo BASE_URL ?>public\asset\img\shonen\one_piece.webp" alt="One Piece"></figure>
                    <p>One Piece</p>
                </div>
                <div>
                    <figure><img src="<?php echo BASE_URL ?>public\asset\img\shonen\l_attaque_des_titans.webp" alt="Attack on Titan"></figure>
                    <p>Attack on titan</p>
                </div>
            </div>
        </div>
    </section>
    </div>
    <section class="see-volume">
        <div class="all-volume">
            <figure><img src="<?php echo BASE_URL ?>public\asset\img\book_open.svg" alt="Book open"></figure>
            <h2>All Volumes</h2>
        </div>
        <div class="list-volume">
            <?php foreach ($volumes as $volume): ?>
                <h2>Volume&nbsp;<?php echo $volume ?></h2>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>