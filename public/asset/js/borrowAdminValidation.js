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
function sortTable(colIndex) {
  let table = document.querySelector("table tbody");
  let rows = Array.from(table.rows);

  rows.sort((a, b) => {
    let valA = a.cells[colIndex].textContent.trim();
    let valB = b.cells[colIndex].textContent.trim();
    return valA.localeCompare(valB);
  });

  rows.forEach((row) => table.appendChild(row));
}
