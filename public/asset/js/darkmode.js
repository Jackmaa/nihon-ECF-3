document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.querySelector('.toggle-theme'); 
    const body = document.body;
    const modeIcon = document.querySelector('.mode-icon');

    // Appliquer le mode enregistré
    const savedMode = localStorage.getItem('theme');
    if (savedMode === 'dark-mode') {
        body.classList.add('dark-mode');
    }

    // Toggle mode sombre et rotation du SVG
    toggleButton.addEventListener('click', function (event) {
        event.preventDefault();

        const isDarkMode = body.classList.toggle('dark-mode');

        // Sauvegarde dans localStorage
        localStorage.setItem('theme', isDarkMode ? 'dark-mode' : 'light-mode');
    });
});
