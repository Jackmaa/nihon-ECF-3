<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public\asset\css\styles.css">

</head>

<body>
    <header class="p-all-2">
        <section class="menu-mobile">
            <figure class="menu-burger menuToggle">
                <img src="public/asset/img/menu_bar.svg" alt="bar menu">
            </figure>
            <figure><img src="public\asset\img\logo.svg" alt="Logo"></figure>
            <figure><img src="public\asset\img\search.svg" alt="search bar"></figure>
            <div class="burger-menu menuBurger">
                <div class="menu-header">
                    <img src="public\asset\img\logo.svg" alt="Menu Logo" class="menu-logo">
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
                <figure><a href="#"><img src="public\asset\img\logo.svg" alt="Logo"></a></figure>
                <figure><a href="#"><img src="public\asset\img\search.svg" alt="loup"></a></figure>
            </div>
        </section>

    </header>

    <main class=connexion>

        <section class="form-container">
            <h1> Connexion </h1>
            <form action="/login" method="post">
                <input type="text" name="username" placeholder="Username">
                <div>
                    <input type="password" name="password"
                        placeholder="Password">
                </div>
                <p>no account yet ? <a class=clickhere href="">Click here</a></p>
                <button type="submit">LOG IN</button>
            </form>

        </section>
        <figure>
            <img id="img-connexion" src="public\asset\img\connexion.webp" alt="image connexion">
        </figure>

        <?php
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username == 'admin' && $password == 'admin') {
                echo 'Login success';
            } else {
                echo 'Login failed';
            }
        }
        ?>
    </main>
    <footer>
        <p>Join us</p>
        <div class="flex1">
            <div class="flex">
                <a href="#"><img src="public\asset\img\Insta.svg" alt="insta"></a>
                <a href="#"><img src="public\asset\img\facebook.svg" alt="facebook"></a>
                <a href="#"><img src="public\asset\img\x.svg" alt="twitter"></a>
            </div>
            <div>
                <a href="#"><img src="public\asset\img\logo.svg" class=logo alt="logo"></a>
            </div>
        </div>
        <div class="copyright">
            <div>
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Security</a>
                <a href="#">Contact</a>
            </div>        
            <p>© 2025 Nihon. All right reserved.</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="public\asset\js\base.js"></script>
</body>

</html>