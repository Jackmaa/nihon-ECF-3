window.addEventListener("load", function () {
  let createForm = document.getElementById("create-form");
  let createAuthorInput = document.getElementById("author");
  let response = document.getElementById("response");

  createAuthorInput.addEventListener("input", function () {
    if (createAuthorInput.value.length <= 3) {
      response.innerHTML = "";
      return;
    }

    let formData = new FormData(createForm);
    fetch("/authorAJAX", {
      method: "POST",
      body: formData,
    })
      .then((datas) => datas.json())
      .then((datas) => {
        response.innerHTML = ""; // Clear previous suggestions
        const ulElement = document.createElement("ul");
        for (let author of datas) {
          // Use 'let' to properly scope 'author'
          let suggestionList = document.createElement("li");
          suggestionList.innerHTML = author.name;
          suggestionList.addEventListener("click", function () {
            createAuthorInput.value = author.name;
            response.innerHTML = ""; // Clear suggestions after selection
          });
          ulElement.appendChild(suggestionList);
        }
        response.appendChild(ulElement);
      });
  });
});
