<?php
$title            = 'Nihon | Home';
$meta_description = 'The best place to find your next manga\'s addiction ';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\darkmode.js", "public\asset\js\cart.js"];
ob_start();
?>
<div class="container-homepage">
    <div class="wrap">
        <div class="bgWave waveOne"></div>
        <div class="bgWave waveTwo"></div>
    </div>
    <div class="cart"><a href="<?php echo $this->router->generate("cart") ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 2H3.30616C3.55218 2 3.67519 2 3.77418 2.04524C3.86142 2.08511 3.93535 2.14922 3.98715 2.22995C4.04593 2.32154 4.06333 2.44332 4.09812 2.68686L4.57143 6M4.57143 6L5.62332 13.7314C5.75681 14.7125 5.82355 15.2031 6.0581 15.5723C6.26478 15.8977 6.56108 16.1564 6.91135 16.3174C7.30886 16.5 7.80394 16.5 8.79411 16.5H17.352C18.2945 16.5 18.7658 16.5 19.151 16.3304C19.4905 16.1809 19.7818 15.9398 19.9923 15.6342C20.2309 15.2876 20.3191 14.8247 20.4955 13.8988L21.8191 6.94969C21.8812 6.62381 21.9122 6.46087 21.8672 6.3335C21.8278 6.22177 21.7499 6.12768 21.6475 6.06802C21.5308 6 21.365 6 21.0332 6H4.57143ZM10 21C10 21.5523 9.55228 22 9 22C8.44772 22 8 21.5523 8 21C8 20.4477 8.44772 20 9 20C9.55228 20 10 20.4477 10 21ZM18 21C18 21.5523 17.5523 22 17 22C16.4477 22 16 21.5523 16 21C16 20.4477 16.4477 20 17 20C17.5523 20 18 20.4477 18 21Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a></div>
    <section class="hero-mobile">
        <div class="carousel">
            <div class="carousel-wrapper">
                <div class="carousel-item red-background">
                    <p>“Now more books to borrow: 5 instead of 3!”</p>
                    <p><span id="extended" >“Extended loan duration: 4 weeks instead of 3!”</span></p>
                    <div class="button-container">
                        <button id="myButton" class="custom-btn btn-green coucou"> <span>Kakkoii mode</span></button>
                        <div class="gif-background"></div>
                    </div>
                </div>
                <?php foreach ($recommendations as $recommendation): ?>
                    <div class="carousel-item card-fav black-background">
                        <div class="bubble-fav">
                            <figure><img src="<?php echo $recommendation->manga->getThumbnail() ?>" alt="Naruto"></figure>
                            <div>
                                <hr>
                                <p><?php echo $recommendation->message ?><a href="<?php echo $this->router->generate("read", ["id" => $recommendation->manga->getId_manga()]) ?>">Read More...</a> </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
    </section>

    <section>
        <?php foreach ($mangas as $category => $manga):
            if (count($manga) == 0) {
                continue;
            }
        ?>
            <div class="category-slider">
                <div class="category-title">
                    <h2><?php echo $category ?></h2>
                    <a href="<?php echo $this->router->generate("readCategory", ["category_name" => $category]) ?>">See all</a>
                </div>
                <div class="slider">
                    <div class="slider-wrapper">
                        <?php foreach ($manga as $manga): ?>
                            <?php
                            $isLiked    = isset($_SESSION['id_user']) && $manga->isLikedByUser($_SESSION['id_user']);
                            $likedClass = $isLiked ? 'liked' : '';
                            ?>
                            <div class="manga">
                                <a href="/manga/<?php echo $manga->getId_manga() ?>">
                                    <img src="<?php echo $manga->getThumbnail() ?>" alt="<?php echo $manga->getName() ?>">
                                    <figure>
                                        <svg class="like-btn		                                                        	                                                         <?php echo $likedClass; ?>" data-manga-id="<?php echo $manga->getId_manga(); ?>" width="33" height="33" viewBox="0 0 33 33" fill="red" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4906 7.06174C13.7415 3.8478 9.15715 2.98326 5.71271 5.92627C2.26826 8.86928 1.78333 13.7898 4.48827 17.2706C6.73725 20.1645 13.5434 26.2681 15.7741 28.2436C16.0237 28.4647 16.1485 28.5752 16.294 28.6186C16.4211 28.6565 16.5601 28.6565 16.6871 28.6186C16.8327 28.5752 16.9575 28.4647 17.207 28.2436C19.4377 26.2681 26.2439 20.1645 28.4929 17.2706C31.1978 13.7898 30.7721 8.83832 27.2685 5.92627C23.7648 3.01422 19.2397 3.8478 16.4906 7.06174Z" stroke="#363333" stroke-linecap="round" stroke-linejoin="round" />
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
</div>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>