document.addEventListener("DOMContentLoaded", () => {
  // Fetch the mangas the user has liked
  fetch("/getLikedMangas")
    .then((response) => response.json())
    .then((data) => {
      const likedMangas = new Set(data.liked_mangas.map(String)); // Convert IDs to strings

      document.querySelectorAll(".like-btn").forEach((button) => {
        const mangaId = button.dataset.mangaId;
        if (likedMangas.has(mangaId)) {
          button.classList.add("liked");
        }
      });
    });
  document.querySelectorAll(".like-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const mangaId = this.dataset.mangaId;
      const likeCountElement = this.nextElementSibling;

      fetch("/like", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ manga_id: mangaId }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.error) {
            alert(data.error);
            return;
          }

          if (data.liked) {
            this.classList.add("liked");
          } else {
            this.classList.remove("liked");
          }

          likeCountElement.textContent = data.like_count;
        });
    });
  });
});
