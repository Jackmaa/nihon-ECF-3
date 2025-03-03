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
// ***********MENU DESKTOP***********
// ********************************* 


document.addEventListener("DOMContentLoaded", function () {
    // Select the profile element and its dropdown menu
    const profile = document.querySelector(".profile");
    const dropdown = profile.querySelector(".dropdown");
    const menuItems = dropdown.querySelectorAll("li");
  
    // Initially set the dropdown and menu items to be hidden
    gsap.set(dropdown, { opacity: 0, y: -10, scale: 0.95, display: "none" });
    gsap.set(menuItems, { opacity: 0, y: -5 });
  
    profile.addEventListener("click", function (event) {
        // Prevent the click event from propagating to other elements
        event.stopPropagation();
  
        if (profile.classList.contains("active")) {
            // If the profile is active, animate the closing of the dropdown and menu items
            gsap.to(menuItems, {
                opacity: 0,
                y: -5,
                duration: 0.2,
                stagger: 0.05,
            });
  
            gsap.to(dropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95,
                duration: 0.3,
                ease: "power2.out",
                onComplete: () => gsap.set(dropdown, { display: "none" }),
            });
  
            // Remove the active class from the profile
            profile.classList.remove("active");
        } else {
            // If the profile is not active, display the dropdown and animate its opening
            gsap.set(dropdown, { display: "block" });
  
            gsap.to(dropdown, {
                opacity: 1,
                y: 0,
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out",
            });
  
            gsap.to(menuItems, {
                opacity: 1,
                y: 0,
                duration: 0.3,
                stagger: 0.1,
                ease: "power2.out",
            });
  
            // Add the active class to the profile
            profile.classList.add("active");
        }
    });
  
    document.addEventListener("click", function (event) {
        // If the click is outside the profile, close the dropdown
        if (!profile.contains(event.target)) {
            gsap.to(menuItems, {
                opacity: 0,
                y: -5,
                duration: 0.2,
                stagger: 0.05,
            });
  
            gsap.to(dropdown, {
                opacity: 0,
                y: -10,
                scale: 0.95,
                duration: 0.3,
                ease: "power2.out",
                onComplete: () => gsap.set(dropdown, { display: "none" }),
            });
  
            // Remove the active class from the profile
            profile.classList.remove("active");
        }
    });
});
