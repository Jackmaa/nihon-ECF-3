document.addEventListener('DOMContentLoaded', function() {
    const openPopupButtons = document.querySelectorAll('.open-popup');
    const closePopupButtons = document.querySelectorAll('.close-popup');
    const overlay = document.getElementById('overlay');

    openPopupButtons.forEach(button => {
        button.addEventListener('click', () => {
            const popupId = button.getAttribute('data-popup');
            const popup = document.getElementById(popupId);
            popup.classList.add('active');
            overlay.classList.add('active');
        });
    });

    closePopupButtons.forEach(button => {
        button.addEventListener('click', () => {
            const popup = button.closest('.popup');
            popup.classList.remove('active');
            overlay.classList.remove('active');
        });
    });

    overlay.addEventListener('click', () => {
        document.querySelectorAll('.popup.active').forEach(popup => {
            popup.classList.remove('active');
        });
        overlay.classList.remove('active');
    });
});