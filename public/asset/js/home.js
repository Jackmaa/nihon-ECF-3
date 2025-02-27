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
