document.querySelectorAll(".status-borrow").forEach((select) => {
  select.addEventListener("change", function () {
    const borrowId = this.getAttribute("data-id");
    const newStatus = this.value;

    fetch("/adminBorrowStatus", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_borrow: borrowId, status: newStatus }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          console.log("Status updated successfully!");
        } else {
          console.error("Failed to update status.");
        }
      });
  });
});
