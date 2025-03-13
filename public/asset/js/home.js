// *********************************
// ***********SLIDER HERO***********
// ********************************* 

const wrapper = document.querySelector('.carousel-wrapper');
const items = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = 0;
let autoSlideInterval;

function updateCarousel() {
    gsap.to(wrapper, {
        x: -currentIndex * 100 + '%',
        duration: 0.5,
        ease: 'power2.inOut'
    });
}

function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel();
    }, 3000); // Change slide every 3 seconds
}

function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % items.length;
    updateCarousel();
    stopAutoSlide();
    startAutoSlide();
});

prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    updateCarousel();
    stopAutoSlide();
    startAutoSlide();
});

wrapper.addEventListener('mouseenter', stopAutoSlide);
wrapper.addEventListener('mouseleave', startAutoSlide);

startAutoSlide();



// *********************************
// ***********slider***********
// ********************************* 

document.querySelectorAll('.category-slider').forEach(slider => {
    let currentIndex = 0;
    const sliderWrapper = slider.querySelector('.slider-wrapper');
    const slides = Array.from(slider.querySelectorAll('.manga'));
    const totalSlides = slides.length;

    const nextButton = slider.querySelector('.next');
    const prevButton = slider.querySelector('.prev');

    const firstClone = slides[0].cloneNode(true);
    const lastClone = slides[totalSlides - 1].cloneNode(true);
    
    sliderWrapper.appendChild(firstClone);
    sliderWrapper.insertBefore(lastClone, slides[0]);

    const allSlides = sliderWrapper.querySelectorAll('.manga'); 
    const slideWidth = slides[0].clientWidth; 
    let isTransitioning = false;

    function updateSlider() {
        if (isTransitioning) return;
        isTransitioning = true;
        
        const offset = -currentIndex * slideWidth; 
        sliderWrapper.style.transition = 'transform 0.3s ease-in-out';
        sliderWrapper.style.transform = `translateX(${offset}px)`;

        setTimeout(() => {
            if (currentIndex === totalSlides) { 
                sliderWrapper.style.transition = 'none';
                currentIndex = 0;
            } else if (currentIndex === -1) { 
                sliderWrapper.style.transition = 'none';
                currentIndex = totalSlides - 1;
            }
            isTransitioning = false;
        }, 300);
    }

    nextButton.addEventListener('click', () => {
        if (isTransitioning) return;
        currentIndex++;
        updateSlider();
    });

    prevButton.addEventListener('click', () => {
        if (isTransitioning) return;
        currentIndex--;
        updateSlider();
    });

    window.addEventListener('resize', () => {
        sliderWrapper.style.transition = 'none';
        currentIndex = 0;
        updateSlider();
    });
});







    // function createBubble() {
    //     const bubble = document.createElement("div");
    //     bubble.classList.add("bubble");
    //     const size = Math.random() * 60 + 20; // Taille aléatoire entre 20px et 80px
    //     bubble.style.width = size + "px";
    //     bubble.style.height = size + "px";

    //     // Position aléatoire sur l'écran
    //     bubble.style.left = Math.random() * window.innerWidth + "px";
    //     bubble.style.animationDuration = Math.random() * 3 + 2 + "s"; // Durée d'animation aléatoire entre 2s et 5s

    //     document.body.appendChild(bubble);

    //     // Supprimer la bulle après l'animation
    //     bubble.addEventListener("animationend", () => {
    //         bubble.remove();
    //     });
    // }

    // // Créer des bulles à intervalle régulier
    // setInterval(createBubble, 500); // Crée une bulle toutes les secondes

    // // Styles pour les bulles
    // const style = document.createElement("style");
    // style.innerHTML = `
    //     .bubble {
    //         position: fixed;
    //         bottom: -100px;
    //         background-color: rgba(0, 144, 255, 0.6); /* Couleur bleue */
    //         border-radius: 50%;
    //         opacity: 0; /* Commence invisible */
    //         animation: rise 5s forwards; /* Animation qui fait monter la bulle */
    //     }

    //     @keyframes rise {
    //         0% {
    //             transform: translateY(0);
    //             opacity: 1; /* Rendre visible */
    //         }
    //         100% {
    //             transform: translateY(-1000px);
    //             opacity: 0; /* Rendre invisible */
    //         }
    //     }
    // `;
    // document.head.appendChild(style);