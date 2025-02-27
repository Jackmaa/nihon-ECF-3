<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public\css\styles.scss">
</head>

<body>

    <header>
        <figure><img src="./public\asset\img\menu.svg" alt="menu"></figure>
        <figure><img src="./public\asset\img\logo.svg" alt="logo"></figure>
        <figure><img src="./public\asset\img\search.svg" alt="search"></figure>
    </header>


    <main class=connexion>
        <div class="form-container">
            <h1> Subscription </h1>
            <form action="/nihon/register" method="POST">

                     <input class="font-barlow-condensed backform mb-10" type="text" name="username" placeholder="Username">
                     <div>
                    <input class="font-barlow-condensed backform mb-10" type="email" name="email" placeholder="Email">
                     </div>
                      <div>
                    <input class="font-barlow-condensed backform mb-10" type="password" name="password"
                        placeholder="Password">
                    </div>
                     <div>
                    <input class="font-barlow-condensed backform mb-10" type="password" name="password_verify"
                        placeholder="Confirm Password">
                        <p>(8 caractères minimums)</p>
                    </div>
                    
                    <div>
                        <p>You have already an account ? <a class=clickhere href="">Click here</a></p>
                        <button class="button font-bangers" type="submit">Subscrire</button>
                    </div>
            </form>
        </div>
        
            <figure><img id="img-subscrire" src="public\asset\img\subscrire.webp" alt="image subscrire"></figure>
        </div>
    </main>
    <footer>
        <p>Join us</p>
        <div class="flex1">
            <div class="flex">
                <figure><img src="public\asset\img\Insta.svg" alt="insta"></figure>
                <figure><img src="public\asset\img\facebook.svg" alt="facebook"></figure>
                <figure><img src="public\asset\img\x.svg" alt="twitter"></figure>
                <figure><img src="public\asset\img\Apple.svg" alt="Apple"></figure>
            </div>
            <div>
                <figure><img src="public\asset\img\logo.svg" class=logo alt="logo"></figure>
            </div>
        </div>
        <div class="copyright">
            <p>Terms Privacy Security Status Docs Contact Manage cookies </p>
            <p><img src="public\asset\img\Copyright.svg" alt="copyright"></p>
        </div>
    </footer>
</body>

</html>