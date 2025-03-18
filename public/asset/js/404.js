document.addEventListener("DOMContentLoaded", function () {
  gsap.from(".content", {
    duration: 0.5,
    opacity: 0,
    y: 80,
    delay: 0.1,
    ease: "power2.out",
  });

  gsap.to(".shuriken", {
    rotation: 360,
    duration: 2,
    repeat: -1,
    ease: "linear",
  });

  function getRandomPosition() {
    return {
      left: Math.random() * (window.innerWidth - 100) + "px", // Position aléatoire sur tout l'écran
      top: Math.random() * (window.innerHeight - 100) + "px",
    };
  }

  function animateShuriken(shuriken) {
    let position = getRandomPosition();
    gsap.to(shuriken, {
      left: position.left,
      top: position.top,
      scale: Math.random() * 1.5 + 0.5,
      duration: 3 + Math.random() * 2, // Durée aléatoire
      ease: "power1.inOut",
      yoyo: true,
      onComplete: () => animateShuriken(shuriken),
    });
  }

  document.querySelectorAll(".shuriken").forEach((shuriken) => {
    let initialPosition = getRandomPosition();
    gsap.set(shuriken, {
      left: initialPosition.left,
      top: initialPosition.top,
      position: "absolute",
    });
    animateShuriken(shuriken);
  });
});
