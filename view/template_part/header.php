<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>public\asset\css\styles.css">
    <link rel="icon" href="<?php echo BASE_URL ?>public\asset\img\logo.ico">
    <meta name="description" content="<?php echo $meta_description ?>">
    <title><?php echo $title ?></title>
</head>

<body>
    <header class="p-all-2">
        <section class="menu-mobile">
            <figure class="menu-burger menuToggle">
                <img src="<?php echo BASE_URL ?>public/asset/img/menu_bar.svg" alt="bar menu">
            </figure>
            <figure><a href="<?php echo BASE_URL ?>"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Logo"></a></figure>
            <figure class="test" >
                    <img src="<?php echo BASE_URL ?>public\asset\img\search.svg" alt="loup">
                    <form action="" id="search-form-mobile" method="POST">
                        <input type="text" name="search" id="search-mobile" placeholder="Search">
                    </form>

                    <div id="search-results-mobile">

                    </div>

                </figure>
            <div class="burger-menu menuBurger">
                <div class="menu-header">
                    <img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Menu Logo" class="menu-logo">
                    <span class="close-menu">×</span>
                </div>
                <ul>
                    <li><a href="#">Connexion</a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">My Books</a></li>
                    <li><a href="#">Favorites</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </section>

        <section class="menu-desktop">
            <div>
                <figure><a href="<?php echo BASE_URL ?>"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Logo"></a></figure>
                <figure>
                    <img src="<?php echo BASE_URL ?>public\asset\img\search.svg" alt="loup">
                    <form action="" id="search-form-desktop" method="POST">
                        <input type="text" name="search" id="search-desktop" placeholder="Search">
                    </form>

                    <div id="search-results-desktop">

                    </div>

                </figure>
                <?php if (isset($_SESSION['id_user'])): ?>
                <figure class="profile" >
                    <a href="#"><img src="<?php echo BASE_URL ?>public\asset\img\profile_picture.webp" alt="profile picture"></a>
                <div class="dropdown">
                    <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">My Favorites</a></li>
                    <li><a href="#">My Boocks</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="<?php echo $this->router->generate('logout') ?>">Déconnexion</a></li>
                </ul>
                </div>
                </figure>
                <?php elseif (isset($_SESSION['admin_logged_in'])): ?>
                    <p>Welcome KAMI</p>
                <?php else: ?>
                <figure class="connexion">
                   <a href="<?php echo $this->router->generate('login') ?>">Connexion</a>
                </figure>
                <?php endif; ?>

            </div>
        </section>

    </header>