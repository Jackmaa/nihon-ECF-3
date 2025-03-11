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
      )
      .then(({ status, data }) => {
        if (status === 200 && data.success) {
          this.innerText = "Added!";
          // Add a "Delete from Cart" button after successful addition
          addDeleteButton(this, mangaId, volumeId);
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

// Function to add a "Delete from Cart" button
function addDeleteButton(addButton, mangaId, volumeId) {
  // Create a new delete button
  const deleteButton = document.createElement("button");
  deleteButton.className = "delete-btn";
  deleteButton.innerText = "Delete from Cart";
  deleteButton.dataset.mangaId = mangaId;
  deleteButton.dataset.volumeId = volumeId;

  // Insert the delete button next to the add button
  addButton.insertAdjacentElement("afterend", deleteButton);

  // Add event listener to the delete button
  deleteButton.addEventListener("click", function () {
    // Disable button to prevent multiple clicks
    this.disabled = true;
    this.innerText = "Removing...";

    // Send a POST request to remove the item from the cart
    fetch("/cart/remove", {
      method: "POST", // Use POST for consistency with backend
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_manga: mangaId, id_volume: volumeId }),
    })
      .then((response) =>
        response.json().then((data) => ({ status: response.status, data }))
      )
      .then(({ status, data }) => {
        if (status === 200 && data.success) {
          this.innerText = "Removed!";
          // Optionally, remove the delete button after successful removal
          setTimeout(() => {
            this.remove();
            addButton.disabled = false; // Re-enable the add button
            addButton.innerText = "Add to Cart";
          }, 1000); // Wait 1 second before removing the button
        } else {
          alert(data.error || "An error occurred.");
          this.disabled = false; // Re-enable button if there's an error
          this.innerText = "Delete from Cart";
        }
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
        alert("Failed to remove from cart. Please try again.");
        this.disabled = false; // Re-enable button if there's a network error
        this.innerText = "Delete from Cart";
      });
  });
}
