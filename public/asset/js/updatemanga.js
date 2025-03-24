document
  .getElementById("modifyMangaForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch(`/update/${id_manga}`, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        alert("Manga updated successfully!");
        closePopup("popupModified");
        location.reload(); // Rafraîchir la page après modification
      })
      .catch((error) => console.error("Error updating manga:", error));
  });
