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

  fetch("/searchAdmin", {
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
        addButtonToDiv("Add", "popupAdd");
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
        addButtonToDiv("Modify", "popupModified");
        addButtonToDiv("Delete", "popupDeleteBook");
      }
    });
});

function addButtonToDiv(text, popupId) {
  let button = document.createElement("button");
  button.classList.add("button");
  button.textContent = text;
  button.onclick = function () {
    openPopup(popupId);
  };
  responseMangaDiv.appendChild(button);
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
