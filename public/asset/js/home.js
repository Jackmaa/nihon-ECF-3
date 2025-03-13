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


// *********************************
// ***********WAVE***********
// ********************************* 

window.addEventListener("scroll", () => {
    const wrap = document.querySelector(".wrap");
    const scrollPosition = window.innerHeight + window.scrollY;
    const documentHeight = document.documentElement.scrollHeight;
  
    if (scrollPosition >= documentHeight) {
      wrap.style.display = "none";
    } else {
      wrap.style.display = "block";
    }
  });
  

const audio = new Audio('public/asset/img/anime-wow-sound-effect.mp3');

// Sélectionne le bouton avec la bonne classe
const button = document.getElementById('myButton');

// Vérifie si le bouton existe
if (button) {
  button.addEventListener('mouseenter', () => {
    audio.play();
  });
}


// *********************************
// ***********CART******************
// ********************************* 

  window.addEventListener('scroll', function() {
    const cart = document.querySelector('.cart');
    const scrollPosition = window.scrollY + window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;

    // Vérifiez si l'utilisateur a atteint le bas de la page
    if (scrollPosition >= documentHeight) {
      cart.style.display = 'none';
    } else {
      cart.style.display = 'block'; // Réaffiche si l'utilisateur n'est pas en bas
    }
  });