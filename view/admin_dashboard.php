<?php
    $title            = 'Nihon | Home';
    $meta_description = 'The best place to find your next manga\'s addiction ';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/dashboard.js", "public/asset/js/header.js", "public/asset/js/search_admin_dashboard.js", "public\asset\js\darkmode.js", "public/asset/js/ajax.js"];
    ob_start();
?>
<main class="dashboard">
<div  class="block-gestion">
    <div>
<h2>Users Gestion</h2>
<form action="" id="search-form-user" method="POST">
    <input type="text" name="search" id="search-user" placeholder="Search">
</form>
</div>
<div id="search-results-user"></div>
</div>
<div  class="block-gestion">
<div>
<h2>Books</h2>
<form action="" id="search-form-manga" method="POST">
    <input type="text" name="search" id="search-manga" placeholder="Search">
</form>
</div>
<div id="search-results-manga"></div>
</div>
<!-- Overlay -->
<div class="overlay" id="overlay" onclick="closePopup('popupCreate'); closePopup('popupBan'); closePopup('popupDelete'); closePopup('popupAdd'); closePopup('popupModified'); closePopup('popupUser')"></div>

<div class="popup" id="popupCreate">
    <form action="/createUser" method="POST">
        <h3>Create User</h3>
        <p>Email</p>
        <input type="text" name="email">
        <button class="button" onclick="closePopup('popupCreate')">Create</button>
    </form>
</div>

<div class="popup" id="popupUser">
    <form action="/modifyUser" method="POST">
        <input name="name" type="text">
        <input name="email" type="text">
        <select name="role" id="role">
            <option value="1">Gaijin</option>
            <option value="2">Kami</option>
        </select>
        <select name="premium" id="premium">
            <option value="false">No</option>
            <option value="true">Yes</option>
        </select>
        <button type="submit" class="button" onclick="closePopup('popupUser')">Modify</button>
    </form>
</div>

<div class="popup" id="popupBan">
    <h3>Ban User</h3>
    <p>User Name</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupBan')">Ban</button>
</div>

<div class="popup" id="popupDelete">
    <h3>Delete User</h3>
    <p>User Name</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupDelete')">Delete</button>
</div>

<div class="popup" id="popupAdd">
    <form action="/create" method="post" enctype="multipart/form-data" id="create-form">
        <input type="text" name="name" placeholder="Title">
        <input type="text" name="author" placeholder="Author" id="author">
        <div id="response-author"></div>
        <textarea type="text" name="description" placeholder="Description"></textarea>
        <fieldset>
            <legend>Select up to 3 categories:</legend>
            <?php foreach ($categories as $category): ?>
                <label>
                    <input type="checkbox" name="category[]" value="<?php echo $category["id_category"]; ?>" onclick="limitSelection(this)">
                    <?php echo $category["category_name"]; ?>
                </label><br>
            <?php endforeach; ?>
        </fieldset>
        <small>Minimum 1, maximum 3 categories.</small>
            <select name="editor" id="editor">
                <?php foreach ($editors as $editor): ?>
                    <option value="<?php echo $editor["id_editor"] ?>"><?php echo $editor["name"] ?></option>
                <?php endforeach; ?>
            </select>
        <input type="date" name="published_date" id="published_date">
        <input type="file" name="thumbnail" id="thumbnail">
        <input type="number" name="volumes" id="volume" min="01">
        <button type="submit" class="button" onclick="closePopup('popupAdd')">Add</button>
    </form>
</div>

<div id="popupModified" class="popup">
    <span class="close" onclick="closePopup('popupModified')">&times;</span>
    <h2>Modify Manga</h2>

    <form id="modifyMangaForm" action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_manga"/>
        <label for="name">Name:</label>
        <input type="text" name="name" required />

        <label for="categories">Categories:</label>
        <input type="text" name="categories" required />

        <label for="author">Author:</label>
        <input type="text" name="author" required />

        <label for="editor">Editor:</label>
        <input type="text" name="editor" required />

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="thumbnail">Thumbnail:</label>
        <input type="file" name="thumbnail" accept="image/*" />

        <!-- Volume Section -->
        <h3>Volumes</h3>
        <div id="volumesContainer">
            <!-- Existing volumes will be displayed here -->
        </div>
        <div>
            <input type="number" id="newVolumeNumber" name="volumes[]" placeholder="Volume Number" />
            <button type="button" onclick="addVolume()">Add Volume</button>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</div>

</main>

<?php
    $content = ob_get_contents();
    ob_end_clean();
    require_once 'view/base_html.php';
?>
