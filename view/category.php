<?php
$title            = 'Nihon | Category';
$meta_description = 'where you can see all your current stories of the moment';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\darkmode.js"];
ob_start();
?>
<section class="hero_category">
    <div class="hero_category_txt">
        <h1><span><?php echo $category->getCategory_name() ?></span></h1>
        <p><span><?php echo $category->getDescription() ?></span></p>
    </div>
</section>
<section class="manga_category">
    <?php foreach ($mangas as $manga): ?>
    <div>
        <a href="<?php echo BASE_URL ?>manga/<?php echo $manga->getId_manga(); ?>">
            <img src="<?php echo BASE_URL . $manga->getThumbnail(); ?>" loading="lazy" alt="<?php echo $manga->getName(); ?>">
            <figure>
                <svg class="like-btn" width="33" height="33" viewBox="0 0 33 33" fill="red" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4906 7.06174C13.7415 3.8478 9.15715 2.98326 5.71271 5.92627C2.26826 8.86928 1.78333 13.7898 4.48827 17.2706C6.73725 20.1645 13.5434 26.2681 15.7741 28.2436C16.0237 28.4647 16.1485 28.5752 16.294 28.6186C16.4211 28.6565 16.5601 28.6565 16.6871 28.6186C16.8327 28.5752 16.9575 28.4647 17.207 28.2436C19.4377 26.2681 26.2439 20.1645 28.4929 17.2706C31.1978 13.7898 30.7721 8.83832 27.2685 5.92627C23.7648 3.01422 19.2397 3.8478 16.4906 7.06174Z" stroke="#363333" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="like-count"><?php echo $manga->getLikesCount(); ?></span>
            </figure>
        </a>
    </div>
    <?php endforeach; ?>
</section>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>