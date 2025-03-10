// Add event listeners to all "Add to Cart" buttons
document.querySelectorAll(".cart-btn").forEach((button) => {
  button.addEventListener("click", function () {
    // Get manga and volume IDs from the button's data attributes
    const mangaId = this.dataset.mangaId;
    const volumeId = this.dataset.volumeId;

    // Send a POST request to add the item to the cart
    fetch("/cart/add", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_manga: mangaId, id_volume: volumeId }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          // Update the button text and disable it
          this.innerText = "Added!";
          this.disabled = true;
        } else {
          // Show an error message
          alert(data.error);
        }
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
      });
  });
});
