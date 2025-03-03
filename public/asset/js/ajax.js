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
        const ulElement = document.createElement("ul");
        for (author of datas) {
          let suggestionList = document.createElement("li");
          suggestionList.innerHTML = author.name;
          ulElement.appendChild(suggestionList);
        }
        response.appendChild(ulElement);
      });
  });
});
