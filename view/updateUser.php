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
            <img id="profile-picture" class="profile-picture" src="<?php echo BASE_URL . $_SESSION['profile_pic'] ?>" alt="profile picture">
            <button type="button" class="change-picture" id="changePictureBtn">Change picture</button>
            <p><?php echo htmlspecialchars($_SESSION['name']) ?></p>
        </figure>
    </div>
</section>

<section class="modify-profile">
    <form action="<?php echo $this->router->generate("updateUser", ["id" => $user->getId_user()]) ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_pic" id="fileInput" style="display: none;">
        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($_SESSION['name']) ?>">
        <input type="email" name="email" placeholder="Email" value="<?php echo $user->getEmail() ?>">
        <input type="password" name="password" placeholder="New Password">
        <input type="password" name="password_verify" placeholder="Confirm New Password">

        <button type="submit">Update</button>
    </form>
</section>

    <figure class="update-user-desktop"><img src="<?php echo BASE_URL ?>public\asset\img\update-user.svg" alt="picture update user"></figure>
</main>
<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view\base_html.php';
?>