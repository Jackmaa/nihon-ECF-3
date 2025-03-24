function openPopup(popupId) {
  document.getElementById("overlay").style.display = "block";
  document.getElementById(popupId).style.display = "block";
}

function closePopup(popupId) {
  document.getElementById("overlay").style.display = "none";
  document.getElementById(popupId).style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
  // Handle review deletion
  document.querySelectorAll(".delete-review").forEach((button) => {
    button.addEventListener("click", function () {
      const reviewId = this.getAttribute("data-review-id");
      document.getElementById("reviewIdToDelete").value = reviewId;
      openPopup("popupDeleteReview");
      document
        .querySelector("#deleteReviewForm")
        .setAttribute("action", `deleteReview/${reviewId}`);
    });
  });

  // AJAX form submission for review deletion
  document
    .getElementById("deleteReviewForm")
    ?.addEventListener("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch(this.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Remove the deleted review from the table
            const row = document
              .querySelector(
                `.delete-review[data-review-id="${data.review_id}"]`
              )
              ?.closest("tr");
            if (row) {
              row.remove();
            }
            closePopup("popupDeleteReview");
          } else {
            alert(
              "Error deleting review: " + (data.message || "Unknown error")
            );
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while deleting the review.");
        });
    });
});
