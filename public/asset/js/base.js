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

