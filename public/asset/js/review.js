document
  .getElementById("leave-review")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    fetch(this.action, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          var newReview = document.createElement("div");
          newReview.classList.add("cadre-review");
          newReview.innerHTML = `
                <div class="cadre-profile">
                    <img class="profile-picture" src="/public/asset/img/profile_picture.webp" alt="profile picture">
                    <p>${data.username}</p>
                </div>
                <div class="comm">
                    <p>${data.review}</p>
                </div>
            `;
          document
            .querySelector(".review")
            .insertBefore(
              newReview,
              document.querySelector(".review").firstChild
            );
          document.getElementById("review").value = "";
        } else {
          alert("Failed to post review.");
        }
      });
  });
