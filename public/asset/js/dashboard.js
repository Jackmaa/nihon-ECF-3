function openPopup(popupId) {
  document.getElementById("overlay").style.display = "block";
  document.getElementById(popupId).style.display = "block";
}

function closePopup(popupId) {
  document.getElementById("overlay").style.display = "none";
  document.getElementById(popupId).style.display = "none";
}
// Function to automatically logout admin when the browser is closed
window.addEventListener("beforeunload", function () {
  fetch("/logout-admin.php", { method: "POST" });
});
