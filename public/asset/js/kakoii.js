document.addEventListener("DOMContentLoaded", function () {
  // Animation d'apparition de la section kakkoiiflex
  gsap.to(".kakkoiiflex .center", {
    duration: 1,
    opacity: 1,
    y: 0,
    ease: "power2.out",
    stagger: 0.2, // Délai entre chaque élément
    delay: 0.5, // Délai avant de commencer l'animation
  });

  // Animation des popups
  document.querySelectorAll(".open-popup").forEach((button) => {
    button.addEventListener("click", () => {
      const popupId = button.getAttribute("data-popup");
      const popup = document.getElementById(popupId);
      popup.style.display = "block";
      gsap.to(popup, {
        zIndex: 1,
        duration: 0.5,
        opacity: 1,
        scale: 1,
        ease: "power2.out",
      });
    });
  });

  // Animation de fermeture des popups
  document.querySelectorAll(".close-popup").forEach((button) => {
    button.addEventListener("click", () => {
      const popup = button.closest(".popup");
      gsap.to(popup, {
        zIndex: 0,
        duration: 0.5,
        opacity: 0,
        scale: 0.8,
        ease: "power2.out",
      });
    });
  });
});
