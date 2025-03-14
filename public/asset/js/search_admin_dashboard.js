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

      // Add a "View Borrowed Items" button
      addButtonToDiv("View Borrowed Items", null, userDiv, () => {
        fetchUserBorrowedItems(user.id_user);
      });

      // Add a "View Cart Items" button
      addButtonToDiv("View Cart Items", null, userDiv, () => {
        fetchUserCartItems(user.id_user);
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

// Function to fill the manga modify popup with manga data
function fillModifyPopup(manga) {
  document.querySelector("#popupModified input:nth-of-type(1)").value =
    manga.manga.id_manga;
  document.querySelector("#popupModified input:nth-of-type(2)").value =
    manga.manga.name;
  document.querySelector("#popupModified input:nth-of-type(3)").value =
    manga.categories;
  document.querySelector("#popupModified input:nth-of-type(4)").value =
    manga.author;
  document.querySelector("#popupModified input:nth-of-type(5)").value =
    manga.editor;
  document.querySelector("#popupModified input:nth-of-type(6)").value =
    manga.manga.description;
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

function fetchUserBorrowedItems(userId) {
  updateUserItems(`/getUserBorrow/${userId}`, "Borrowed Items", userId);
}

function fetchUserCartItems(userId) {
  updateUserItems(`/getUserCart/${userId}`, "Cart Items", userId);
}

function updateUserItems(url, title, userId) {
  let existingItemsDiv = document.querySelector(".user-items");
  if (existingItemsDiv) {
    existingItemsDiv.remove();
  }

  const itemsDiv = document.createElement("div");
  itemsDiv.classList.add("user-items", "fade-in");
  itemsDiv.innerHTML = `<h3>${title}</h3>`;

  const closeButton = document.createElement("button");
  closeButton.textContent = "✖";
  closeButton.classList.add("close-btn");
  closeButton.addEventListener("click", () => {
    itemsDiv.classList.add("fade-out");
    setTimeout(() => itemsDiv.remove(), 300);
  });

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      itemsDiv.innerHTML = `<h3>${title}</h3>`;
      itemsDiv.appendChild(closeButton);

      if (data.length === 0) {
        itemsDiv.innerHTML += "<p>No items found.</p>";
        return;
      }
      if (url === `/getUserBorrow/${userId}`) {
        const table = document.createElement("table");
        table.innerHTML = `
          <thead>
            <tr>
              <th>Manga</th>
              <th>Volume</th>
              <th>Return Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        `;

        const tbody = table.querySelector("tbody");
        data.borrowed.forEach((item) => {
          const row = document.createElement("tr");

          row.innerHTML = `
          <td>${item.name}</td>
          <td>Volume ${item.id_volume}</td>
          <td>${item.return_date}</td>
          <td>
            <select class="status-dropdown" data-id="${item.id_borrow}">
              ${["pending", "approved", "back", "late", "rejected"]
                .map(
                  (status) =>
                    `<option value="${status}" ${
                      item.status === status ? "selected" : ""
                    }>${
                      status.charAt(0).toUpperCase() + status.slice(1)
                    }</option>`
                )
                .join("")}
            </select>
          </td>
        `;

          tbody.appendChild(row);
        });

        itemsDiv.appendChild(table);
        mainDashboard.appendChild(itemsDiv);

        // Use event delegation to handle status change
        itemsDiv.addEventListener("change", function (event) {
          if (event.target.classList.contains("status-dropdown")) {
            const borrowId = event.target.getAttribute("data-id");
            const newStatus = event.target.value;
            let checkmark = event.target.nextElementSibling;

            if (
              !checkmark ||
              !checkmark.classList.contains("status-checkmark")
            ) {
              checkmark = document.createElement("span");
              checkmark.classList.add("status-checkmark");
              checkmark.innerHTML = "✔";
              event.target.parentNode.appendChild(checkmark);
            }

            fetch("/adminBorrowStatus", {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ id_borrow: borrowId, status: newStatus }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                  checkmark.style.opacity = "1";
                  setTimeout(() => (checkmark.style.opacity = "0"), 1500);
                  console.log("Status updated successfully!");
                } else {
                  console.error("Failed to update status.");
                }
              });
          }
        });
      } else {
        const table = document.createElement("table");
        table.innerHTML = `
          <thead>
            <tr>
              <th>Manga</th>
              <th>Volume</th>
              <th>Placed</th>
              <th>Validate</th>
            </tr>
          </thead>
          <tbody></tbody>
        `;

        const tbody = table.querySelector("tbody");
        data.cart.forEach((item) => {
          const row = document.createElement("tr");

          row.innerHTML = `
          <td>${item.name}</td>
          <td>Volume ${item.id_volume}</td>
          <td>${item.placed}</td>
          <td></td>
        `;

          tbody.appendChild(row);
        });
        itemsDiv.appendChild(table);
        mainDashboard.appendChild(itemsDiv);
      }
    });
}
