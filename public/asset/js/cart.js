// Add event listeners to all "Add to Cart" buttons
document.querySelectorAll(".cart-btn").forEach((button) => {
  button.addEventListener("click", function () {
    // Convert manga and volume IDs to integers
    const mangaId = parseInt(this.dataset.mangaId);
    const volumeId = parseInt(this.dataset.volumeId);
    // Disable button to prevent multiple clicks
    this.disabled = true;
    this.innerText = "Adding...";

    // Send a POST request to add the item to the cart
    fetch("/cart/add", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_manga: mangaId, id_volume: volumeId }),
    })
      .then((response) =>
        response.json().then((data) => ({ status: response.status, data }))
      ) // Handle HTTP errors
      .then(({ status, data }) => {
        if (status === 200 && data.success) {
          this.innerText = "Added!";
        } else {
          alert(data.error || "An error occurred.");
          this.disabled = false; // Re-enable button if there's an error
          this.innerText = "Add to Cart";
        }
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
        alert("Failed to add to cart. Please try again.");
        this.disabled = false; // Re-enable button if there's a network error
        this.innerText = "Add to Cart";
      });
  });
});
