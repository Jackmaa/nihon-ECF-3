const editProfile = document.querySelector(".edit-profile");

editProfile.addEventListener("click", function () {
    const idUser = this.dataset.id;
  window.location.href = `/updateUser/${idUser}`;
});
