<?php
$title = 'Nihon | About Us';
$meta_description = 'Learn more about Nihon';
$scripts = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/base.js", "public/asset/js/header.js", "public/asset/js/aboutus.js", "public/asset/js/darkmode.js"];
ob_start();
?>
<body>
    
<main class="aboutus">
    <section>
        <h1>NIHON</h1>
        <h2>Why NIHON? What does it mean?</h2>
        <p>Nihon is an online manga library designed to provide an organized and user-friendly way to explore and manage your favorite manga. The name Nihon was chosen as a play on words: in Japanese, Hon (本) means "book," and we wanted a name that reflects both our passion for manga and its cultural origins.</p>
        <h2>Our Goal</h2>
        <p>Create a comprehensive and user-friendly online manga library that allows users to browse, search, and borrow their favorite mangas. Nihon aims to provide a smooth and intuitive experience, following MVC principles for clean and scalable architecture, and ensuring a visually appealing and responsive UI.</p>
        <h2>Ultimately, the goal is to make Nihon a go-to platform for manga enthusiasts, offering an organized, efficient, and enjoyable way to explore and track their favorite manga.</h2>
        <h2>Our Team</h2>
        <p> This project is brought to you by an amazing team of developers: 
        <div class="flexcenter"> 
            <br>
            @Mel00w <br>
            @fab7669 <br>
            @SamyMechiche <br>
            @Jackmaa
        </p>
        </div>   
    </section>
     <!-- Ajouter des nuages -->
     <div class="cloud-container">
     <div class="cloud" style="top: 10%; left: 20%;"></div>
    <div class="cloud" style="top: 30%; left: 50%;"></div>
    <div class="cloud" style="top: 50%; left: 70%;"></div>
    <div class="cloud" style="top: 70%; left: 30%;"></div>
    <div class="cloud" style="top: 90%; left: 80%;"></div>
    <div class="cloud" style="top: 20%; left: 10%;"></div>
    <div class="cloud" style="top: 40%; left: 40%;"></div>
    <div class="cloud" style="top: 60%; left: 90%;"></div>
    <div class="cloud" style="top: 80%; left: 60%;"></div>
    <div class="cloud" style="top: 5%; left: 80%;"></div>
    <div class="cloud" style="top: 25%; left: 10%;"></div>
    <div class="cloud" style="top: 45%; left: 40%;"></div>
    <div class="cloud" style="top: 65%; left: 90%;"></div>  
    <div class="cloud" style="top: 85%; left: 60%;"></div>
    <div class="cloud" style="top: 15%; left: 80%;"></div>
    <div class="cloud" style="top: 35%; left: 10%;"></div>
    <div class="cloud" style="top: 55%; left: 40%;"></div>
    <div class="cloud" style="top: 75%; left: 90%;"></div>
    <div class="cloud" style="top: 95%; left: 60%;"></div>
    


</main>
</body>

<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view/base_html.php';
?>