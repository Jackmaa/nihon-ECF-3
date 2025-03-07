<?php
$title            = 'Nihon | My Profile ';
$meta_description = 'it\'s your profile, your profile is incredible like a manga';
$scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public\asset\js\base.js", "public\asset\js\header.js", "public\asset\js\like.js", "public\asset\js\update-profile.js"];
ob_start();
?>
<main>
    <section class="head-profile">
        <div>
            <div class="head-edit-profile">
                <h2>Edit Profile</h2>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.9997 8.33332L11.6664 4.99999M2.08301 17.9167L4.90331 17.6033C5.24789 17.565 5.42018 17.5459 5.58121 17.4937C5.72408 17.4475 5.86005 17.3821 5.98541 17.2995C6.12672 17.2063 6.2493 17.0837 6.49445 16.8386L17.4997 5.83332C18.4202 4.91285 18.4202 3.42046 17.4997 2.49999C16.5792 1.57951 15.0868 1.57951 14.1664 2.49999L3.16112 13.5052C2.91596 13.7504 2.79339 13.8729 2.70021 14.0142C2.61753 14.1396 2.55219 14.2756 2.50594 14.4185C2.4538 14.5795 2.43466 14.7518 2.39637 15.0964L2.08301 17.9167Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <figure>
                <img id="profile-picture" class="profile-picture" src="<?php echo BASE_URL ?>public/asset/img/profile_picture.webp" alt="profile picture">
                <button class="change-picture" id="changePictureBtn">Change picture</button>
                <input type="file" id="fileInput" accept="image/*" style="display: none;">
                <p>USERNAME</p>
            </figure>
        </div>
    </section>
    <section class="modify-profile">
        <input type="text" placeholder="Username">
        <input type="text" placeholder="Email">
        <input type="text" placeholder="Password">
        <button>Update</button>

    </section>
</main>
<?php
$content = ob_get_contents();
ob_end_clean();
require_once 'view\base_html.php';
?>