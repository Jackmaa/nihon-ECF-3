document.addEventListener('DOMContentLoaded', function() {
    // Animation d'apparition du formulaire
    gsap.to(".form-container", {
        duration: 1,
        opacity: 1,
        y: 0,
        ease: "power2.out"
    });

    // Animation des champs de saisie et du bouton de soumission
    gsap.to(".form-container input, .form-container button", {
        duration: 1,
        opacity: 1,
        y: 0,
        ease: "power2.out",
        stagger: 0.2, // Délai entre chaque élément
        delay: 0.5 // Délai avant de commencer l'animation
    });

    // Animation de l'image
    gsap.to("#img-subscrire", {
        duration: 1,
        opacity: 1,
        y: 0,
        ease: "power2.out",
        delay: 1 // Délai avant de commencer l'animation
    });

    // Animation de survol pour le bouton de soumission
    const submitButton = document.querySelector(".login");
    submitButton.addEventListener("mouseenter", () => {
        gsap.to(submitButton, {
            duration: 0.3,
            scale: 1.1,
            ease: "power2.out"
        });
    });

    submitButton.addEventListener("mouseleave", () => {
        gsap.to(submitButton, {
            duration: 0.3,
            scale: 1,
            ease: "power2.out"
        });
    });
});