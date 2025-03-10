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
            <figure class="test">
                <img src="<?php echo BASE_URL ?>public\asset\img\search.svg" alt="loup">
                <form action="" id="search-form-mobile" method="POST">
                    <input type="text" name="search" id="search-mobile" placeholder="Search">
                </form>

                <div id="search-results-mobile">

                </div>

            </figure>
            <div class="burger-menu menuBurger">
                <div class="menu-header">
                    <a href="<?php echo BASE_URL ?>" class="menu-logo"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Menu Logo"></a>
                    <span class="close-menu">×</span>
                </div>
                <ul>
                    <li><a href="<?php echo $this->router->generate("myProfile", ["id" => $_SESSION['id_user']]) ?>">Profil</a></li>
                    <li><a href="<?php echo BASE_URL ?>">Home</a></li>
                    <li><a href="<?php echo $this->router->generate("currentStorie") ?>">My Books</a></li>
                    <li><a href="<?php echo $this->router->generate("favoriteManga", ["id" => $_SESSION['id_user']]) ?>">Favorites</a></li>
                    <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
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
                    <li><a href="<?php echo $this->router->generate("myProfile", ["id" => $_SESSION['id_user']]) ?>">Profil</a></li>
                    <li><a href="<?php echo $this->router->generate("favoriteManga", ["id" => $_SESSION['id_user']]) ?>">My Favorites</a></li>
                    <li><a href="<?php echo $this->router->generate("currentStorie") ?>">My Boocks</a></li>
                    <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
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