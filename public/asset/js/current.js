document.querySelectorAll(".chevron-current").forEach((chevron) => {
    chevron.addEventListener("click", function () {
        const content = this.nextElementSibling; 
        const chevronIcon = this.querySelector("svg"); 

        content.classList.toggle("open");
        chevronIcon.classList.toggle("rotate");
    });
});
