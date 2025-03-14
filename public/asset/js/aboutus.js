document.addEventListener('DOMContentLoaded', function() {
    // Animation d'apparition des titres, paragraphes et flexcenter
    gsap.to(".aboutus h1, .aboutus h2, .aboutus p, .aboutus .flexcenter", {
        duration: 1,
        opacity: 1,
        y: 0,
        ease: "power2.out",
        stagger: 0.2,
        delay: 0.5
    });

    // Animation de fond
    gsap.to(".aboutus", {
        duration: 20,
        backgroundPosition: "200% 200%",
        repeat: -1,
        yoyo: true,
        ease: "linear"
    });

    // Animation des nuages
    const clouds = document.querySelectorAll('.cloud');
    clouds.forEach((cloud, index) => {
        const randomY = Math.random() * 100 - 50; // À quelle hauteur ces nuages commencent
        const duration = 10 + Math.random() * 10; // Durée aléatoire pour un mouvement fluide

        gsap.fromTo(cloud, {
            x: -200, // Commencer en dehors de l'écran à gauche
            y: randomY, // Position verticale aléatoire
            opacity: 0,
        }, {
            x: window.innerWidth + 200, // Se déplace complètement à droite de l'écran
            duration: duration,
            opacity: 1,
            repeat: -1, // Répète l'animation
            ease: "none", // Mouvement constant
            delay: index * 0.5, // Échelon entre les nuages
            yoyo: false // Pas de retour
        });
    });
});