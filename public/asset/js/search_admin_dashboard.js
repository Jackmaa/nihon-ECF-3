let searchFormManga = document.getElementById("search-form-manga");
let searchMangaInput = document.getElementById("search-manga");
const responseMangaDiv = document.getElementById("search-results-manga");
const buttonContainer = document.querySelector(".button-container");

searchMangaInput.addEventListener("input", function () {
  if (searchMangaInput.value.length < 2) {
    responseMangaDiv.innerHTML = "";
    buttonContainer.style.display = "block";
    return;
  }

  let formData = new FormData(searchFormManga);

  fetch("/searchManga", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((datas) => {
      responseMangaDiv.innerHTML = "";
      if (datas.error || datas.length === 0) {
        let noResult = document.createElement("p");
        noResult.textContent = "No result found";
        responseMangaDiv.appendChild(noResult);
        addButtonToDiv("Add", "popupAdd", responseMangaDiv);
      } else {
        datas.forEach((manga) => {
          console.log(manga);
          let mangaDiv = document.createElement("div");
          mangaDiv.classList.add("manga-result");

          let mangaTitle = document.createElement("p");
          let mangaThumbnail = document.createElement("img");
          mangaThumbnail.src = manga.manga.thumbnail;
          mangaThumbnail.style.width = "200px";
          mangaTitle.textContent = manga.manga.name;

          mangaDiv.append(mangaThumbnail, mangaTitle);
          responseMangaDiv.appendChild(mangaDiv);

          mangaDiv.addEventListener("click", function () {
            fillModifyPopup(manga);
            openPopup("popupModified");
          });
        });
        addButtonToDiv("Modify", "popupModified", responseMangaDiv);
        addButtonToDiv("Delete", "popupDeleteBook", responseMangaDiv);
      }
    });
});

function addButtonToDiv(text, popupId, responseDiv) {
  let button = document.createElement("button");
  button.classList.add("button");
  button.textContent = text;
  button.onclick = function () {
    openPopup(popupId);
  };
  responseDiv.appendChild(button);
}

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

// SEARCH USER
let searchFormUser = document.getElementById("search-form-user");
let searchUserInput = document.getElementById("search-user");
const responseUserDiv = document.getElementById("search-results-user");
const buttonContainerUser = document.querySelector(".button-container-user");

searchUserInput.addEventListener("input", function () {
  if (searchUserInput.value.length < 2) {
    responseUserDiv.innerHTML = "";
    return;
  }

  let formData = new FormData(searchFormUser);

  fetch("/searchUser", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((datas) => {
      responseUserDiv.innerHTML = "";
      if (datas.error || datas.length === 0) {
        let noResult = document.createElement("p");
        noResult.textContent = "No result found";
        responseUserDiv.appendChild(noResult);
        addButtonToDiv("Add", "popupAddUser", responseUserDiv);
      } else {
        datas.forEach((user) => {
          let userDiv = document.createElement("div");
          userDiv.classList.add("user-result");

          let userName = document.createElement("p");
          userName.textContent = user.username;

          userDiv.append(userName);
          responseUserDiv.appendChild(userDiv);

          userDiv.addEventListener("click", function () {
            fillModifyPopupUser(user);
            openPopup("popupUser");
          });
        });
        addButtonToDiv("Modify", "popupModifiedUser", responseUserDiv);
        addButtonToDiv("Delete", "popupDeleteUser", responseUserDiv);
      }
    });
});

function fillModifyPopupUser(user) {
  document.querySelector("#popupUser input:nth-of-type(1)").value =
    user.id_user;
  document.querySelector("#popupUser input:nth-of-type(2)").value =
    user.username;
  document.querySelector("#popupUser input:nth-of-type(3)").value = user.email;
}
