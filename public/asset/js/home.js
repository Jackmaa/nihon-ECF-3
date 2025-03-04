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
                sliderWrapper.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
            } else if (currentIndex === -1) { 
                sliderWrapper.style.transition = 'none';
                currentIndex = totalSlides - 1;
                sliderWrapper.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
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

    sliderWrapper.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
});
