// Get references to the manga search form and input field
let searchFormManga = document.getElementById("search-form-manga");
let searchMangaInput = document.getElementById("search-manga");

// Get references to the div where manga search results will be displayed
const responseMangaDiv = document.getElementById("search-results-manga");

// Get references to the button container for manga
const buttonContainer = document.querySelector(".button-container");

// Get references to the user search form and input field
let searchFormUser = document.getElementById("search-form-user");
let searchUserInput = document.getElementById("search-user");

// Get references to the div where user search results will be displayed
const responseUserDiv = document.getElementById("search-results-user");

// Get references to the button container for user
const buttonContainerUser = document.querySelector(".button-container-user");

// Get references for the main to send the table
const mainDashboard = document.querySelector(".dashboard");

// Function to add a button to a specified div with optional onClick callback and popup opening
function addButtonToDiv(text, popupId, responseDiv, onClickCallback) {
  let button = document.createElement("button");
  button.classList.add("button");
  button.textContent = text;
  button.onclick = function () {
    if (onClickCallback) {
      onClickCallback();
    }
    if (popupId) {
      // Open the specified popup if `popupId` is provided
      openPopup(popupId);
    }
  };
  responseDiv.appendChild(button);
}

// Function to handle the display of manga search results
function handleMangaResults(datas) {
  responseMangaDiv.innerHTML = "";

  // Check if there's an error or no results
  if (datas.error || datas.length === 0) {
    responseMangaDiv.innerHTML = "<p>No result found</p>";
    // Add an "Add" button to allow adding a new manga
    addButtonToDiv("Add", "popupAdd", responseMangaDiv);
  } else {
    // Loop through each manga result and create a div for it
    datas.forEach((manga) => {
      let mangaDiv = document.createElement("div");
      mangaDiv.classList.add("manga-result");
      mangaDiv.setAttribute("data-id", manga.manga.id_manga); // Store the manga ID

      // Create and append the manga thumbnail and title
      let mangaTitle = document.createElement("p");
      let mangaThumbnail = document.createElement("img");
      mangaThumbnail.src = manga.manga.thumbnail;
      mangaThumbnail.style.width = "200px";
      mangaTitle.textContent = manga.manga.name;

      mangaDiv.append(mangaThumbnail, mangaTitle);
      responseMangaDiv.appendChild(mangaDiv);

      // Add a "Modify" button to edit the manga
      addButtonToDiv("Modify", "popupModified", mangaDiv, () => {
        fillModifyPopup(manga);
        openPopup("popupModified");
      });

      // Add a "Delete" button to delete the manga
      addButtonToDiv("Delete", null, mangaDiv, () => {
        let mangaId = manga.manga.id_manga;
        if (!mangaId) {
          console.error("Manga ID not found");
          return;
        }

        // Confirm deletion with the user
        if (!confirm("Are you sure you want to delete this manga?")) {
          return;
        }
        // Send a POST request to delete the manga
        fetch(`/delete/${mangaId}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then((response) => response.json())
          .then((data) => {
            mangaDiv.remove(); // Remove the manga element from the DOM
          });
      });

      // Add a click event to the thumbnail to open the modify popup
      mangaThumbnail.addEventListener("click", function () {
        fillModifyPopup(manga);
        openPopup("popupModified");
      });
    });
  }
}

// Add an input event listener to the manga search input field
searchMangaInput.addEventListener("input", function () {
  // Clear results if the input is too short
  if (searchMangaInput.value.length < 2) {
    responseMangaDiv.innerHTML = "";
    buttonContainer.style.display = "block";
    return;
  }

  // Send a POST request to search for manga
  let formData = new FormData(searchFormManga);
  fetch("/searchManga", { method: "POST", body: formData })
    .then((response) => response.json())
    .then(handleMangaResults);
});

// Function to handle the display of user search results
function handleUserResults(datas) {
  responseUserDiv.innerHTML = "";
  // Check if there's an error or no results
  if (datas.error || datas.length === 0) {
    responseUserDiv.innerHTML = "<p>No result found</p>";
    // Add an "Add" button to allow creating a new user
    addButtonToDiv("Add", "popupCreate", responseUserDiv, () => {
      document.querySelector("#popupCreate input[name='email']").value =
        searchUserInput.value;
    });
  } else {
    // Loop through each user result and create a div for it
    datas.forEach((user) => {
      let userDiv = document.createElement("div");
      userDiv.classList.add("user-result");
      let userName = document.createElement("p");
      userName.textContent = user.username;
      userDiv.append(userName);
      responseUserDiv.appendChild(userDiv);

      // Add a get user items button
      addButtonToDiv("View loans/cart", null, userDiv, () => {
        fetchUserItems(user.id_user);
      });
    });

    // Add "Modify" and "Delete" buttons for the user
    addButtonToDiv("Modify", "popupUser", responseUserDiv, () => {
      fillModifyPopupUser(datas[0]);
    });
    addButtonToDiv("Delete", "popupDeleteUser", responseUserDiv);
  }
}

// Add an input event listener to the user search input field
searchUserInput.addEventListener("input", function () {
  // Clear results if the input is too short
  if (searchUserInput.value.length < 2) {
    responseUserDiv.innerHTML = "";
    return;
  }

  // Send a POST request to search for users
  let formData = new FormData(searchFormUser);
  fetch("/searchUser", { method: "POST", body: formData })
    .then((response) => response.json())
    .then(handleUserResults);
});

// Function to fill the user modify popup with user data
function fillModifyPopupUser(user) {
  document.querySelector("#popupUser input:nth-of-type(1)").value =
    user.id_user;
  document.querySelector("#popupUser input:nth-of-type(2)").value =
    user.username;
  document.querySelector("#popupUser input:nth-of-type(3)").value = user.email;
}

function fillModifyPopup(manga) {
  document.querySelector("#popupModified input[name='id_manga']").value =
    manga.manga.id_manga;
  document.querySelector("#popupModified input[name='name']").value =
    manga.manga.name;
  document.querySelector("#popupModified input[name='categories']").value =
    manga.categories;
  document.querySelector("#popupModified input[name='author']").value =
    manga.author;
  document.querySelector("#popupModified input[name='editor']").value =
    manga.editor;
  document.querySelector("#popupModified textarea[name='description']").value =
    manga.manga.description;

  // Fetch and display existing volumes
  fetch(`/getVolumes/${manga.manga.id_manga}`)
    .then((response) => response.json())
    .then((data) => {
      const volumesContainer = document.getElementById("volumesContainer");
      volumesContainer.innerHTML = ""; // Clear existing content

      if (data.length === 0) {
        volumesContainer.innerHTML = "<p>No volumes found.</p>";
      } else {
        data.forEach((volume) => {
          const volumeDiv = document.createElement("div");
          volumeDiv.classList.add("volume-item");
          volumeDiv.innerHTML = `
            <span>Volume ${volume.id_volume}</span>
            <button type="button" onclick="deleteVolume(${volume.id_volume}, ${manga.manga.id_manga})">Delete</button>
          `;
          volumesContainer.appendChild(volumeDiv);
        });
      }
    })
    .catch((error) => console.error("Error fetching volumes:", error));
}

// Function to limit the selection of categories to 3
function limitSelection(checkbox) {
  let checkedBoxes = document.querySelectorAll(
    'input[name="category[]"]:checked'
  );
  if (checkedBoxes.length > 3) {
    checkbox.checked = false; // Prevent selecting more than 3
    alert("You can select up to 3 categories only.");
  }
}

function fetchUserItems(userId) {
  updateUserItems(`/getUserItems/${userId}`, "User Items", userId);
}

function updateUserItems(url, title, userId) {
  let existingItemsDiv = document.querySelector(".user-items");
  if (existingItemsDiv) existingItemsDiv.remove();

  const itemsDiv = document.createElement("div");
  itemsDiv.classList.add("user-items", "fade-in");

  const closeButton = document.createElement("button");
  closeButton.textContent = "✖";
  closeButton.classList.add("close-btn");
  closeButton.addEventListener("click", () => {
    itemsDiv.classList.add("fade-out");
    setTimeout(() => itemsDiv.remove(), 300);
  });

  // Tabs
  const tabs = document.createElement("div");
  tabs.classList.add("tabs");

  const borrowedTab = document.createElement("button");
  borrowedTab.textContent = "Current Borrows";
  borrowedTab.classList.add("active");
  borrowedTab.onclick = () => switchTab("borrowedTable");

  const historyTab = document.createElement("button");
  historyTab.textContent = "History";
  historyTab.onclick = () => switchTab("historyTable");

  const cartTab = document.createElement("button");
  cartTab.textContent = "Cart";
  cartTab.onclick = () => switchTab("cartTable");

  tabs.appendChild(borrowedTab);
  tabs.appendChild(historyTab);
  tabs.appendChild(cartTab);

  // Table containers
  const borrowedTableContainer = document.createElement("div");
  borrowedTableContainer.id = "borrowedTable";

  const historyTableContainer = document.createElement("div");
  historyTableContainer.id = "historyTable";
  historyTableContainer.style.display = "none"; // Hidden by default

  const cartTableContainer = document.createElement("div");
  cartTableContainer.id = "cartTable";
  cartTableContainer.style.display = "none"; // Hidden by default

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      if (data.borrowed.length === 0 && data.cart.length === 0) {
        borrowedTableContainer.innerHTML = "<p>No items found.</p>";
        return;
      }

      // Handle borrowed items
      const borrowedItems = data.borrowed.filter(
        (item) => item.status !== "BACK"
      );
      const returnedItems = data.borrowed.filter(
        (item) => item.status === "BACK"
      );

      // Create tables for borrowed and returned items
      if (borrowedItems.length > 0) {
        borrowedTableContainer.appendChild(
          createTable("borrowed", { borrowed: borrowedItems })
        );
      } else {
        borrowedTableContainer.innerHTML = "<p>No borrowed items.</p>";
      }

      if (returnedItems.length > 0) {
        historyTableContainer.appendChild(
          createTable("borrowed", { borrowed: returnedItems })
        );
      } else {
        historyTableContainer.innerHTML = "<p>No returned items.</p>";
      }

      // Handle cart items
      const cartItems = data.cart || [];

      if (cartItems.length > 0) {
        cartTableContainer.appendChild(
          createTable("cart", { cart: cartItems })
        );
      } else {
        cartTableContainer.innerHTML = "<p>No items in cart.</p>";
      }

      // Append tabs and tables to the pop-up
      itemsDiv.appendChild(tabs);
      itemsDiv.appendChild(borrowedTableContainer);
      itemsDiv.appendChild(historyTableContainer);
      itemsDiv.appendChild(cartTableContainer);
      itemsDiv.appendChild(closeButton);
      mainDashboard.appendChild(itemsDiv);
    });
}

// Function to switch between tabs
function switchTab(tabId) {
  const borrowedTable = document.getElementById("borrowedTable");
  const historyTable = document.getElementById("historyTable");
  const cartTable = document.getElementById("cartTable");

  if (borrowedTable)
    borrowedTable.style.display = tabId === "borrowedTable" ? "block" : "none";
  if (historyTable)
    historyTable.style.display = tabId === "historyTable" ? "block" : "none";
  if (cartTable)
    cartTable.style.display = tabId === "cartTable" ? "block" : "none";

  // Update active tab
  document
    .querySelectorAll(".tabs button")
    .forEach((btn) => btn.classList.remove("active"));
  document
    .querySelector(
      `.tabs button:nth-child(${
        tabId === "borrowedTable" ? 1 : tabId === "historyTable" ? 2 : 3
      })`
    )
    .classList.add("active");
}

// Function to create a table
function createTable(type, data) {
  const table = document.createElement("table");
  table.innerHTML =
    type === "borrowed" ? getBorrowTableHead() : getCartTableHead();
  const tbody = table.querySelector("tbody");

  if (type === "borrowed") {
    data.borrowed.forEach((item) => tbody.appendChild(createBorrowRow(item)));
  } else {
    data.cart.forEach((item) => tbody.appendChild(createCartRow(item)));
  }

  return table;
}

// Function to get the table header for borrowed items
function getBorrowTableHead() {
  return `
    <thead>
      <tr>
        <th>Manga</th>
        <th>Volume</th>
        <th>Return Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody></tbody>`;
}

// Function to get the table header for cart items
function getCartTableHead() {
  return `
    <thead>
      <tr>
        <th>Manga</th>
        <th>Volume</th>
        <th>Placed</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>`;
}

// Function to create a row for borrowed items
function createBorrowRow(item) {
  const row = document.createElement("tr");
  row.innerHTML = `
    <td>${item.name}</td>
    <td>Volume ${item.id_volume}</td>
    <td>${item.return_date}</td>
    <td>
      <select class="status-dropdown" data-id="${item.id_borrow}">
        ${["pending", "approved", "back", "late", "rejected"]
          .map(
            (status) => `<option value="${status}" ${
              item.status === status.toUpperCase() ? "selected" : ""
            }>
            ${status.charAt(0).toUpperCase() + status.slice(1)}</option>`
          )
          .join("")}
      </select>
      <span class="status-checkmark">✔</span>
    </td>`;
  return row;
}

// Function to create a row for cart items
function createCartRow(item) {
  const row = document.createElement("tr");
  row.dataset.cartId = item.id_cart; // Store cart ID for easy reference

  row.innerHTML = `
    <td>${item.name}</td>
    <td>Volume ${item.id_volume}</td>
    <td>${item.placed}</td>
    <td>
      <button onclick="validateCartItem(${item.id_manga}, ${item.id_volume}, ${item.id_user}, this)" class="validate-cart">✔ Validate</button>
      <button onclick="deleteCartItem(${item.id_manga}, ${item.id_volume}, ${item.id_user}, this)" class="delete-cart">✖ Delete</button>
    </td>`;

  return row;
}

// Event delegation for delete buttons
document.addEventListener("click", (event) => {
  if (event.target.classList.contains("delete-cart")) {
    const row = event.target.closest("tr");
    const cartId = event.target.dataset.id;
    deleteCartItem(cartId, row);
  }
});

// Function to validate a cart item
function validateCartItem(idManga, idVolume, idUser, button) {
  fetch("/validateCartItem", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      id_manga: idManga,
      id_volume: idVolume,
      id_user: idUser,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Manga successfully validated! 📚✅");
        button.closest("tr").remove(); // Remove the row on success
      } else {
        alert("Error: " + data.error);
      }
    })
    .catch((error) => console.error("Fetch error:", error));
}

// Function to delete a cart item
function deleteCartItem(idManga, idVolume, idUser, button) {
  fetch("/deleteCartItem", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      id_manga: idManga,
      id_volume: idVolume,
      id_user: idUser,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Item deleted from cart! 🗑️");
        button.closest("tr").remove();
      } else {
        alert("Error: " + data.error);
      }
    });
}
