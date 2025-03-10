document.querySelectorAll(".cart-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const mangaId = this.dataset.mangaId;
    const volumeId = this.dataset.volumeId;

    fetch("/cart/add", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `manga_id=${mangaId}&volume_id=${volumeId}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          this.innerText = "Added!";
          this.disabled = true;
        } else {
          alert(data.error);
        }
      });
  });
});
