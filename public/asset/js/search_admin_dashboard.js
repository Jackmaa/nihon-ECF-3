// *********************************
// ***********SEARCH***********
// *********************************

let searchFormManga = document.getElementById("search-form-manga");
let searchMangaInput = document.getElementById("search-manga");
const responseMangaDiv = document.getElementById("search-results-manga");

searchMangaInput.addEventListener("input", function () {
  if (searchMangaInput.value.length < 2) {
    responseMangaDiv.innerHTML = "";
    return;
  }
  if (searchMangaInput.value.length > 2) {
    let formData = new FormData(searchFormManga);

    fetch("/searchAdmin", {
      method: "POST",
      body: formData,
    })
      .then((datas) => datas.json())
      .then((datas) => {
        console.log(datas);
        responseMangaDiv.innerHTML = "";
        if (datas.error) {
          let noResult = document.createElement("p");
          noResult.textContent = "No result found";
          responseMangaDiv.appendChild(noResult);
        }
        datas.forEach((manga) => {
          let mangaDiv = document.createElement("div");
          let mangaTitle = document.createElement("p");
          let mangaThumbnail = document.createElement("img");
          mangaThumbnail.src = manga.thumbnail;
          mangaThumbnail.style.width = "200px";
          mangaTitle.textContent = manga.name;
          mangaDiv.append(mangaThumbnail, mangaTitle);
          responseMangaDiv.appendChild(mangaDiv);
        });
      });
  }
});
