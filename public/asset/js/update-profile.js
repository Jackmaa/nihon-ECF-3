document.addEventListener("DOMContentLoaded", () => {
  const chevron = document.querySelector(".chevron-current");
  const content = document.querySelector(".chevron-content");
  const chevronIcon = document.getElementById("chevron-icon");

  let isOpen = false;

  gsap.set(content, { height: 0, opacity: 0 });

  chevron?.addEventListener("click", () => {
    if (isOpen) {
      // Close
      gsap.to(content, {
        height: 0,
        opacity: 0,
        duration: 0.5,
        ease: "power2.inOut",
      });
      gsap.to(chevronIcon, { rotate: 0, duration: 0.3, ease: "power2.out" });
    } else {
      // Open
      gsap.to(content, {
        height: "auto",
        opacity: 1,
        duration: 0.5,
        ease: "power2.inOut",
      });
      gsap.to(chevronIcon, { rotate: 180, duration: 0.3, ease: "power2.out" });
    }
    isOpen = !isOpen;
  });
  document
    .getElementById("changePictureBtn")
    .addEventListener("click", function () {
      document.getElementById("fileInput").setAttribute("style", "block");
    });
  document
    .getElementById("fileInput")
    .addEventListener("change", function (event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("profile-picture").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
});
