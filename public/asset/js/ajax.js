window.addEventListener("load", function () {
  // Get references to the form, input field, and response container
  let createForm = document.getElementById("create-form");
  let createAuthorInput = document.getElementById("author");
  let response = document.getElementById("response-author");

  // Add event listener to the input field for user input
  createAuthorInput.addEventListener("input", function () {
    // Clear response if input length is less than or equal to 3
    if (createAuthorInput.value.length <= 3) {
      response.innerHTML = "";
      return;
    }

    // Create FormData object from the form
    let formData = new FormData(createForm);

    // Send AJAX request to the server
    fetch("/authorAJAX", {
      method: "POST",
      body: formData,
    })
      .then((datas) => datas.json()) // Parse the JSON response
      .then((datas) => {
        response.innerHTML = ""; // Clear previous suggestions
        const ulElement = document.createElement("ul"); // Create a new unordered list element

        // Iterate through the received data and create list items
        for (let author of datas) {
          let suggestionList = document.createElement("li");
          suggestionList.innerHTML = author.name;

          // Add click event listener to each suggestion
          suggestionList.addEventListener("click", function () {
            createAuthorInput.value = author.name; // Set input value to the selected suggestion
            response.innerHTML = ""; // Clear suggestions after selection
          });

          ulElement.appendChild(suggestionList); // Append suggestion to the list
        }

        response.appendChild(ulElement); // Append the list to the response container
      });
  });
});
