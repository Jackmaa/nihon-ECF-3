document.querySelectorAll(".status-borrow").forEach((select) => {
  select.addEventListener("change", function () {
    const borrowId = this.getAttribute("data-id");
    const newStatus = this.value;
    let checkmark = this.nextElementSibling;

    if (!checkmark || !checkmark.classList.contains("status-checkmark")) {
      checkmark = document.createElement("span");
      checkmark.classList.add("status-checkmark");
      checkmark.innerHTML = "✔";
      this.parentNode.appendChild(checkmark);
    }

    fetch("/adminBorrowStatus", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id_borrow: borrowId, status: newStatus }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          checkmark.style.opacity = "1";
          setTimeout(() => (checkmark.style.opacity = "0"), 1500);
          console.log("Status updated successfully!");
        } else {
          console.error("Failed to update status.");
        }
      });
  });
});

// Track the sorting state for each column
let sortStates = {};

function sortTable(colIndex) {
  let table = document.querySelector("table tbody");
  let rows = Array.from(table.rows);

  // Determine the current sorting state for the column
  if (!sortStates[colIndex]) {
    sortStates[colIndex] = "asc"; // Default to ascending order
  } else if (sortStates[colIndex] === "asc") {
    sortStates[colIndex] = "desc"; // Switch to descending order
  } else {
    sortStates[colIndex] = "asc"; // Switch back to ascending order
  }

  // Sort the rows based on the column and sorting state
  rows.sort((a, b) => {
    let valA = a.cells[colIndex].textContent.trim();
    let valB = b.cells[colIndex].textContent.trim();

    if (sortStates[colIndex] === "asc") {
      return valA.localeCompare(valB);
    } else {
      return valB.localeCompare(valA);
    }
  });

  // Re-append the sorted rows to the table
  rows.forEach((row) => table.appendChild(row));
}
