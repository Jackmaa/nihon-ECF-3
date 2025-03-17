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

<header>

    <body>
        <?php if ($title == 'Nihon | Login' || $title == 'Nihon | Register'): ?>

            <body id="css-body">
            <?php else: ?>

                <body>
                <?php endif; ?>
                <section class="menu-mobile">
                    <figure class="menu-burger menuToggle">
                        <img src="<?php echo BASE_URL ?>public/asset/img/menu_bar.svg" alt="bar menu">
                    </figure>
                    <figure class="logoo"><a href="<?php echo BASE_URL ?>"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Logo"></a></figure>
                    <figure id="#search-bar-mobile" class="mobile-input-header">
                        <div class="loup-search">
                            <img class="loup" src="<?php echo BASE_URL ?>public\asset\img\search.svg" alt="loup">
                            <form action="" id="search-form-mobile" method="POST">
                                <input type="text" name="search" id="search-mobile" placeholder="Search">
                            </form>
                        </div>
                        <div id="search-results-mobile"></div>
                    </figure>
                    <div class="burger-menu menuBurger">
                        <div class="menu-header">
                            <a href="<?php echo BASE_URL ?>" class="menu-logo"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Logo"></a>
                            <span class="close-menu">×</span>
                        </div>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <ul>
                                <li><a href="<?php echo $this->router->generate("myProfile", ["id" => $_SESSION['id_user']]) ?>">Profil</a></li>
                                <li><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li><a href="<?php echo $this->router->generate("currentStorie") ?>">My Book</a></li>
                                <li><a href="<?php echo $this->router->generate("favoriteManga", ["id" => $_SESSION['id_user']]) ?>">Favorites</a></li>
                                <li><a href="#" class="toggle-theme">Darkmode
                                        <span class="icon-wrapper">
                                            <svg class="mode-icon" width="33" height="19" viewBox="0 0 33 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 18.875C28.0729 18.875 33 14.6758 33 9.5C33 4.32422 28.0729 0.125 22 0.125L11 0.125C4.92708 0.125 0 4.32422 0 9.5C0 14.6758 4.92708 18.875 11 18.875L22 18.875ZM11 14.1875C9.54131 14.1875 8.14236 13.6936 7.11091 12.8146C6.07946 11.9355 5.5 10.7432 5.5 9.5C5.5 8.2568 6.07946 7.06451 7.11091 6.18544C8.14236 5.30636 9.54131 4.8125 11 4.8125C12.4587 4.8125 13.8576 5.30636 14.8891 6.18544C15.9205 7.06451 16.5 8.2568 16.5 9.5C16.5 10.7432 15.9205 11.9355 14.8891 12.8146C13.8576 13.6936 12.4587 14.1875 11 14.1875Z" fill="#C0C0C0" />
                                            </svg>
                                        </span>
                                    </a></li>
                                <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
                                <li><a href="<?php echo $this->router->generate('logout') ?>">Log-out</a></li>
                            </ul>
                        <?php else: ?>
                            <ul>
                                <li><a href="<?php echo $this->router->generate("login") ?>">Login</a></li>
                                <li><a href="<?php echo $this->router->generate("register") ?>">Register</a></li>
                                <li><a href="<?php echo BASE_URL ?>">Home</a></li>
                                <li><a href="#" class="toggle-theme">Darkmode
                                        <span class="icon-wrapper">
                                            <svg class="mode-icon" width="33" height="19" viewBox="0 0 33 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 18.875C28.0729 18.875 33 14.6758 33 9.5C33 4.32422 28.0729 0.125 22 0.125L11 0.125C4.92708 0.125 0 4.32422 0 9.5C0 14.6758 4.92708 18.875 11 18.875L22 18.875ZM11 14.1875C9.54131 14.1875 8.14236 13.6936 7.11091 12.8146C6.07946 11.9355 5.5 10.7432 5.5 9.5C5.5 8.2568 6.07946 7.06451 7.11091 6.18544C8.14236 5.30636 9.54131 4.8125 11 4.8125C12.4587 4.8125 13.8576 5.30636 14.8891 6.18544C15.9205 7.06451 16.5 8.2568 16.5 9.5C16.5 10.7432 15.9205 11.9355 14.8891 12.8146C13.8576 13.6936 12.4587 14.1875 11 14.1875Z" fill="#C0C0C0" />
                                            </svg>
                                        </span>
                                    </a></li>
                                <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
                            </ul>
                        <?php endif; ?>

                    </div>
                </section>
                <section class="menu-desktop">
                    <div>
                        <figure><a class="logo" href="<?php echo BASE_URL ?>"><img src="<?php echo BASE_URL ?>public\asset\img\logo.svg" alt="Logo"></a></figure>
                        <figure id="search-bar-desktop">
                            <div>
                                <img class="loup" src="<?php echo BASE_URL ?>public\asset\img\search.svg" alt="loup">
                                <form action="" id="search-form-desktop" method="POST">
                                    <input type="text" name="search" id="search-desktop" placeholder="Search">
                                </form>
                            </div>
                            <div id="search-results-desktop"></div>
                        </figure>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <figure class="profile">
                                <div id="username-picture">
                                    <a href="<?php echo $this->router->generate("myProfile", ["id" => $_SESSION['id_user']]) ?>"><?php echo  $_SESSION['name'] ?></a>
                                    <a href="#"><img src="<?php echo BASE_URL ?><?php echo $_SESSION['profile_pic'] ?>" alt="profile picture"></a>
                                </div>
                                <div class="dropdown">
                                    <ul>
                                        <li><a href="<?php echo $this->router->generate("myProfile", ["id" => $_SESSION['id_user']]) ?>">Profil</a></li>
                                        <li><a href="<?php echo $this->router->generate("favoriteManga", ["id" => $_SESSION['id_user']]) ?>">My Favorites</a></li>
                                        <li><a href="<?php echo $this->router->generate("currentStorie") ?>">My Book</a></li>
                                        <li><a href="<?php echo BASE_URL ?>contact">Contact</a></li>
                                        <li><a href="#" class="toggle-theme">Darkmode
                                                <span class="icon-wrapper">
                                                    <svg class="mode-icon" width="33" height="19" viewBox="0 0 33 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M22 18.875C28.0729 18.875 33 14.6758 33 9.5C33 4.32422 28.0729 0.125 22 0.125L11 0.125C4.92708 0.125 0 4.32422 0 9.5C0 14.6758 4.92708 18.875 11 18.875L22 18.875ZM11 14.1875C9.54131 14.1875 8.14236 13.6936 7.11091 12.8146C6.07946 11.9355 5.5 10.7432 5.5 9.5C5.5 8.2568 6.07946 7.06451 7.11091 6.18544C8.14236 5.30636 9.54131 4.8125 11 4.8125C12.4587 4.8125 13.8576 5.30636 14.8891 6.18544C15.9205 7.06451 16.5 8.2568 16.5 9.5C16.5 10.7432 15.9205 11.9355 14.8891 12.8146C13.8576 13.6936 12.4587 14.1875 11 14.1875Z" fill="#C0C0C0" />
                                                    </svg>
                                                </span>
                                            </a></li>

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