// Function to fetch cart state from the server
function fetchCartState() {
  return fetch("/cart/state", {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  }).then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    return response.json();
  });
}

// Function to update the state of a button (enable/disable, change text)
function updateButtonState(button, isInCart) {
  if (isInCart) {
    button.disabled = true;
    button.innerText = "Added!";
  } else {
    button.disabled = false;
    button.innerText = "Add to Cart";
  }
}

// Initialize the UI based on the cart state
function initializeCartUI(cart) {
  document.querySelectorAll(".cart-btn").forEach((button) => {
    const mangaId = parseInt(button.dataset.mangaId);
    const volumeId = parseInt(button.dataset.volumeId);

    // Check if the item is in the cart
    const isInCart = cart.some(
      (item) => item.id_manga === mangaId && item.id_volume === volumeId
    );

    // Update the button state
    updateButtonState(button, isInCart);

    // Add a "Delete from Cart" button if the item is in the cart
    if (isInCart) {
      addDeleteButton(button, mangaId, volumeId);
    }
  });
}

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
            updateButtonState(addButton, false); // Re-enable the add button
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

// Fetch cart state on page load and initialize the UI
fetchCartState().then((data) => {
  if (data.success) {
    initializeCartUI(data.cart);
  } else {
    console.error("Failed to fetch cart state:", data.error);
  }
});

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
          updateButtonState(this, false); // Re-enable button if there's an error
        }
      })
      .catch((error) => {
        console.error("There was a problem with the fetch operation:", error);
        alert("Failed to add to cart. Please try again.");
        updateButtonState(this, false); // Re-enable button if there's a network error
      });
  });
});
