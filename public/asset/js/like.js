document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".like-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Empêche la redirection du lien parent

      const mangaId = this.dataset.mangaId;
      const likeCountElement = this.nextElementSibling;

      fetch("/like", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ manga_id: mangaId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.liked) {
            this.classList.add("liked"); // Change color
          } else {
            this.classList.remove("liked"); // Revert color
          }
          likeCountElement.textContent = data.like_count;
        });
    });
  });
});
