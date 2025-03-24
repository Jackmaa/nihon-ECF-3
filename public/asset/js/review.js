document
  .getElementById("leave-review")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch(this.action, {
      method: "POST",
      body: formData,
      headers: {
        Accept: "application/json", // Ensure server knows we expect JSON
      },
    })
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          // Create new review element
          var newReview = document.createElement("div");
          newReview.classList.add("cadre-review");
          newReview.innerHTML = `
              <div class="cadre-profile">
                  <img class="profile-picture" src="../${data.profile_pic}" alt="profile picture">
                  <p>${data.username}</p>
              </div>
              <div class="comm">
                  <p>${data.review}</p>
              </div>
          `;

          // Insert at the top of reviews section
          let reviewSection = document.querySelector(".review");
          reviewSection.appendChild(newReview);

          // Clear the review textarea
          this.querySelector('textarea[name="review"]').value = "";
        } else {
          alert(data.message || "Failed to post review.");
        }
      });
  });
