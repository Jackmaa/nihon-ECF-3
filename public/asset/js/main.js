// *********************************
// ***********SLIDER HERO***********
// ********************************* 

const wrapper = document.querySelector('.carousel-wrapper');
const items = document.querySelectorAll('.carousel-item');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = 0;

function updateCarousel() {
    gsap.to(wrapper, {
        x: -currentIndex * 100 + '%',
        duration: 0.5,
        ease: 'power2.inOut'
    });
}

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % items.length;
    updateCarousel();
});

prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    updateCarousel();
});


// *********************************
// ***********MENU BURGER***********
// ********************************* 

const menuToggle = document.querySelector('.menuToggle');
const burgerMenu = document.querySelector('.menuBurger');
const closeMenu = document.querySelector('.close-menu');

// Open menu
const openMenu = () => {
    burgerMenu.classList.add('active');
    gsap.fromTo(burgerMenu, 
        { x: '-100%', opacity: 0 }, 
        { x: '0%', opacity: 1, duration: 0.5, ease: 'power2.out' }
    );
};

// Close menu
const closeMenuAnimation = () => {
    gsap.to(burgerMenu, 
        { x: '-100%', opacity: 0, duration: 0.5, ease: 'power2.in', onComplete: () => {
            burgerMenu.classList.remove('active'); // Ferme le menu après l'animation
        }}
    );
};

menuToggle.addEventListener('click', openMenu);
closeMenu.addEventListener('click', closeMenuAnimation);

const menuIcon = document.querySelector('.menu-burger img');

menuIcon.addEventListener('mouseenter', () => {
    gsap.to(menuIcon, { scale: 1.1, rotation: 10, duration: 0.3 });
});

menuIcon.addEventListener('mouseleave', () => {
    gsap.to(menuIcon, { scale: 1, rotation: 0, duration: 0.3 });
});



// *********************************
// ***********slider***********
// ********************************* 

document.querySelectorAll('.category-slider').forEach(slider => {
    let currentMangaIndex = 0;
    const sliderWrapper = slider.querySelector('.slider-wrapper');
    const mangas = slider.querySelectorAll('.manga');
    const totalMangas = mangas.length;
    const mangasPerView = 3;

    const nextButton = slider.querySelector('.next');
    const prevButton = slider.querySelector('.prev');

    const maxIndex = totalMangas - mangasPerView;

    function updateSlider() {
        const offset = -currentMangaIndex * (200 / mangasPerView);
        sliderWrapper.style.transform = `translateX(${offset}%)`;
        updateButtonState();
    }

    function updateButtonState() {
        prevButton.disabled = currentMangaIndex === 0;
        nextButton.disabled = currentMangaIndex >= maxIndex;
    }

    nextButton.addEventListener('click', () => {
        if (currentMangaIndex < maxIndex) {
            currentMangaIndex++;
            updateSlider();
        }
    });

    prevButton.addEventListener('click', () => {
        if (currentMangaIndex > 0) {
            currentMangaIndex--;
            updateSlider();
        }
    });

    // Initialisation
    updateButtonState();
});
