<?php
$title            = 'Nihon | Favorite Manga';
$meta_description = 'Your favorite manga';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\home.js", "public/asset/js/header.js", "public/asset/js/like.js", "public\asset\js\darkmode.js", "public\asset/js/favorite.js"];
ob_start();
?>
<main>
    <section class="bann-setting">
        <a href="<?php echo $this->router->generate("myProfile", ['id' => $_SESSION['id_user']]) ?>">‹ Back to my Profile</a>
        <h3>My Favorite Manga</h3>
    </section>
    <figure class="current-desktop">
        <img src="<?php echo BASE_URL ?>public\asset\img\current-active.svg" alt="">
    </figure>
    <section>
    <label for="sort-options">Sort by :</label>
    <select id="sort-options">
        <option value="default">Default</option>
        <option value="name-asc">Name (A-Z)</option>
        <option value="name-desc">Name (Z-A)</option>
        <option value="date-recent">Date (from latest to oldest)</option>
        <option value="date-old">Date (from oldest to latest)</option>
    </select>

    <div id="fav-container">
        <?php foreach ($favs as $fav): ?>
            <div class="card-current" 
                 data-name="<?php echo strtolower($fav->manga->getName()); ?>" 
                 data-date="<?php echo $fav->manga->getPublished_date()->format('Y-m-d'); ?>">
                <div class="current-storie">
                    <figure><img src="<?php echo $fav->manga->getThumbnail() ?>" alt="<?php echo $fav->manga->getName()?>"></figure>
                    <div class="current-info">
                        <h4><?php echo $fav->manga->getName()?></h4>
                        <div>
                            <a href="#">Category: <span><?php echo $fav->categories?></span></a>
                            <a href="#">Author: <span><?php echo $fav->author?></span></a>
                            <a href="#">Editor: <span><?php echo $fav->editor?></span></a>
                        </div>
                    </div>
                </div>
                <div class="chevron-container">
                    <div class="chevron-current">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="chevron-content">
                        <p>coucou</p>
                        <p>Tu veux voir mon git ?</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>


    <div class="separation">AJOUTER UNE SÉPARATION ICI SVP</div><br><br>

    <?php if (empty($userstats)): ?>
        <p>No Statistics</p>
    <?php else: ?>
        <?php
        $maxFavs = max(array_column($userstats, 'total_fav'));
        ?>
        <div class="statistique">
            <?php foreach ($userstats as $index => $stat): 
                // Calculate the height of the bar in a percentage
                $height = ($stat['total_fav'] / $maxFavs) * 100;
                // Switch the color of the bar
                $colorClass = $index % 2 == 0 ? 'color-one' : 'color-two';
            ?>
                <div class="statistique-barre" style="height: <?= $height ?>%; background: <?= $index % 2 == 0 ? 'linear-gradient(9deg, rgba(48,226,74,1) 0%, rgba(40,218,213,1) 49%, rgba(33,150,243,1) 100%)' : 'linear-gradient(0deg, rgba(228,0,43,1) 0%, rgba(227,0,27,1) 49%, rgba(255,0,0,1) 100%)' ?>;">
                <?php
                    $categoryName = htmlspecialchars($stat['category_name']);
                    if (strpos($categoryName, ' ') !== false) {
                        $words = explode(' ', $categoryName);
                        $initials = '';
                        foreach ($words as $word) {
                            $initials .= strtoupper($word[0]);
                        }
                        echo $initials . ': ';
                    } else {
                        echo $categoryName . ': ';
                    }
                    ?>
                    <span><?= htmlspecialchars($stat['total_fav']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>