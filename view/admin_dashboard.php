<?php
    $title            = 'Nihon | Home';
    $meta_description = 'The best place to find your next manga\'s addiction ';
    $scripts          = ["https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js", "public/asset/js/dashboard.js", "public/asset/js/header.js", "public/asset/js/search_admin_dashboard.js"];
    ob_start();
?>
<div class="headdashboard"></div>
<main class="dashboard">

<h1>Returns of the Day:</h1>
<p>Total:</p>

<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Title</th>
            <th>Validation</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Norauto</td>
            <td>Demon Slayer</td>
            <td><input type="checkbox" id="check1"></td>
        </tr>
        <tr>
            <td>Norauto</td>
            <td>Demon Slayer</td>
            <td><input type="checkbox" id="check2"></td>
        </tr>
        <tr>
            <td>Norauto</td>
            <td>Demon Slayer</td>
            <td><input type="checkbox" id="check3"></td>
        </tr>
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
<div class="overlay" id="overlay" onclick="closePopup('popupLoans'); closePopup('popupReturns'); closePopup('popupHistory'); closePopup('popupCreate'); closePopup('popupBan'); closePopup('popupDelete'); closePopup('popupAdd'); closePopup('popupModified'); closePopup('popupDeleteBook'); closePopup('popupUser')"></div>

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

<div class="popup" id="popupUser">
    <input type="text">
    <input type="text">
    <input type="text">
</div>

<div class="popup" id="popupCreate">
    <h3>Create User</h3>
    <p>User Name</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupCreate')">Create</button>
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
    <h3>Add Book</h3>
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
    <input type="file" accept=".webp">
    <button class="button" onclick="closePopup('popupAdd')">Add</button>
</div>

<div class="popup" id="popupModified">
    <h3>Modify Book</h3>
    <img src="public\asset\img\search.svg" alt=""><p>ID Book</p>
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

<div class="popup" id="popupDeleteBook">
    <h3>Delete Book</h3>
    <img src="public\asset\img\search.svg" alt=""><p>ID Book</p>
    <input type="text">
    <button class="button" onclick="closePopup('popupDeleteBook')">Delete</button>
</div>

</main>

<?php
    $content = ob_get_contents();
    ob_end_clean();
require_once 'view/base_html.php';
?>