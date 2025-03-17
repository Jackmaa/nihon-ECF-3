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
        <?php foreach ($mangas as $manga): ?>
        <div class="card-current">
            
            <div class="current-storie">
                <figure><img src="<?php echo $manga->manga->manga->getThumbnail() ?>" alt="<?php echo $manga->manga->manga->getName()?>"></figure>
                <div class="current-info">
                    <h4><?php echo $manga->manga->manga->getName()?></h4>
                    <div>
                        <a href="#">catégory:<span><?php echo $manga->manga->categories?></span></a>
                        <a href="#">Author: <span><?php echo $manga->manga->author?></span></a>
                        <a href="#">Editor: <span><?php echo $manga->manga->editor?></span></a>
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
        <?php endforeach; ?>
    </section>
</main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>