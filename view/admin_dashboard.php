<?php
    $title            = 'Nihon | Home';
    $meta_description = 'The best place to find your next manga\'s addiction ';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/dashboard.js", "public/asset/js/header.js", "public/asset/js/search_admin_dashboard.js", "public\asset\js\darkmode.js", "public/asset/js/borrowAdminValidation", "public/asset/js/ajax.js"];
    ob_start();
?>
<div class="headdashboard"></div>
<main class="dashboard">

<h1>Returns of the Day:</h1>
<p>Total:</p>
<div class="filters">
    <button onclick="sortTable(0)">Sort by User</button>
    <button onclick="sortTable(1)">Sort by Manga</button>
    <button onclick="sortTable(3)">Sort by Return Date</button>
</div>
<table>
    <thead>
        <tr>
            <th>id_user</th>
            <th>id_manga</th>
            <th>id_volume</th>
            <th>date_return</th>
            <th>validation</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($borrows as $borrow): ?>
        <tr>
            <td><?php echo $borrow->getId_user(); ?></td>
            <td><?php echo $borrow->getId_manga(); ?></td>
            <td><?php echo $borrow->getId_volume(); ?></td>
            <td><?php echo $borrow->getReturn_date(); ?></td>
            <td>
            <select name="status"
                        class="status-borrow"
                        data-id="<?php echo $borrow->getId_borrow(); ?>">
                    <?php foreach ($enumValues as $value): ?>
                    <option value="<?php echo $value; ?>"
                        <?php echo($borrow->getStatus() == $value) ? 'selected' : ''; ?>>
                        <?php echo ucfirst(strtolower($value)); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h1>Loans Managing</h1>
<div class="button-container">
    <button class="button" onclick="openPopup('popupLoans')">Loans</button>
    <button class="button" onclick="openPopup('popupReturns')">Returns</button>
    <button class="button" onclick="openPopup('popupHistory')">History</button>
</div>

<h1>Users Gestion</h1>
<form action="" id="search-form-user" method="POST">
    <input type="text" name="search" id="search-user" placeholder="Search">
</form>
<div id="search-results-user"></div>

<h1>Books</h1>
<form action="" id="search-form-manga" method="POST">
    <input type="text" name="search" id="search-manga" placeholder="Search">
</form>
<div id="search-results-manga"></div>

<!-- Overlay -->
<div class="overlay" id="overlay" onclick="closePopup('popupLoans'); closePopup('popupReturns'); closePopup('popupHistory'); closePopup('popupCreate'); closePopup('popupBan'); closePopup('popupDelete'); closePopup('popupAdd'); closePopup('popupModified'); closePopup('popupUser')"></div>

<!-- Popups -->
<div class="popup" id="popupLoans">
    <h3>Loans Managing !</h3>
    <img src="public\asset\img\search.svg" alt=""><p>ID Book</p>
    <input type="text">
    <p>Loan date</p>
    <input type="text">
    <p>User</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupLoans')">Valider</button>
</div>

<div class="popup" id="popupReturns">
    <h3>Returns Managing !</h3>
    <img src="public\asset\img\search.svg" alt=""><p>ID Book</p>
    <input type="text">
    <p>Return date</p>
    <input type="text">
    <p>User</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupReturns')">Valider</button>
</div>

<div class="popup" id="popupHistory">
    <h3>History</h3>
    <img src="public\asset\img\search.svg" alt=""><p>ID book</p>
    <input type="text">
    <p>Date Return</p>
    <input type="text">
    <img src="public\asset\img\search.svg" alt=""><p>Loan default</p>
    <p>User</p>
    <input type="text">
    <p>Loan Date</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupHistory')">Close</button>
</div>

<div class="popup" id="popupCreate">
    <form action="/createUser" method="POST">
        <h3>Create User</h3>
        <p>Email</p>
        <input type="text" name="email">
        <button class="button" onclick="closePopup('popupCreate')">Create</button>
    </form>
</div>

<div class="popup" id="popupUser">
    <input type="text">
    <input type="text">
    <input type="text">
    <button type="submit" class="button" onclick="closePopup('popupUser')">Modify</button>
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
        <button type="submit" class="button" onclick="closePopup('popupAdd')">Add</button>
    </form>
</div>

<div class="popup" id="popupModified">
    <h3>Modify Book</h3>
    <input type="text">
    <p>Book Title</p>
    <input type="text">
    <p>Book category</p>
    <input type="text">
    <p>Book author</p>
    <input type="text">
    <p>Book Editor</p>
    <input type="text">
    <p>Book Summary</p>
    <input type="text">
    <p>Picture</p>
    <input type="file"accept=".webp">

    <button class="button" onclick="closePopup('popupModified')">Modify</button>
</div>
</main>

<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view/base_html.php';
?>