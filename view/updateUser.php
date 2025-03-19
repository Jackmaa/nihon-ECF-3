<?php
$title            = 'Nihon | My Profile ';
$meta_description = 'it\'s your profile, your profile is incredible like a manga';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\header.js", "public\asset\js\like.js", "public\asset\js\update-profile.js", "public\asset\js\darkmode.js"];
ob_start();
?>
<main class="update-user">
    <section class="head-profile">
        <div>
            <div class="head-edit-profile">
                <h2>Edit Profile</h2>
            </div>
            <figure>
                <img id="profile-picture" class="profile-picture" src="<?php echo BASE_URL ?><?php echo $_SESSION['profile_pic'] ?>" alt="profile picture">
                <button class="change-picture" id="changePictureBtn">Change picture</button>
                <input type="file" id="fileInput" accept="image/*" style="display: none;">
                <p>USERNAME</p>
            </figure>
        </div>
    </section>
    <section class="modify-profile">
        <form action="">
            <input type="text" placeholder="Username">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Password">
            <button>Update</button>
        </form>


    </section>
    <figure class="update-user-desktop"><img src="<?php echo BASE_URL ?>public\asset\img\update-user.svg" alt="picture update user"></figure>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>