//<button class="borrow-btn" data-manga-id="1" data-premium="true">Borrow</button>
document.querySelectorAll(".borrow-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const mangaId = this.dataset.mangaId;
    const isPremium = this.dataset.premium === "true";
    let extraWeek = false;

    if (isPremium) {
      extraWeek = confirm("Do you want an extra week?");
    }

    fetch("/borrow", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `manga_id=${mangaId}&extra_week=${extraWeek}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          this.innerText = "Borrowed!";
          this.disabled = true;
        } else {
          alert(data.error);
        }
      });
  });
});
