document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-theme'); // Plusieurs boutons
    const body = document.body;
    
    // Appliquer le mode enregistré
    const savedMode = localStorage.getItem('theme');
    if (savedMode === 'dark-mode') {
        body.classList.add('dark-mode');
    }

    // Itérer sur chaque bouton et ajouter un écouteur d'événements
    toggleButtons.forEach(function(toggleButton) {
        toggleButton.addEventListener('click', function (event) {
            event.preventDefault();

            const isDarkMode = body.classList.toggle('dark-mode');

            // Sauvegarde dans localStorage
            localStorage.setItem('theme', isDarkMode ? 'dark-mode' : 'light-mode');
        });
    });
});
