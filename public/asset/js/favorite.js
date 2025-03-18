document.getElementById("sort-options").addEventListener("change", function() {
    let sortBy = this.value;
    let container = document.getElementById("fav-container");
    let cards = Array.from(container.getElementsByClassName("card-current"));

    cards.sort((a, b) => {
        let nameA = a.dataset.name;
        let nameB = b.dataset.name;
        let dateA = new Date(a.dataset.date);
        let dateB = new Date(b.dataset.date);

        switch (sortBy) {
            case "name-asc":
                return nameA.localeCompare(nameB);
            case "name-desc":
                return nameB.localeCompare(nameA);
            case "date-recent":
                return dateB - dateA; // Trier du plus récent au plus ancien
            case "date-old":
                return dateA - dateB; // Trier du plus ancien au plus récent
            default:
                return 0;
        }
    });

    // Réorganise les cartes triées dans le container
    container.innerHTML = "";
    cards.forEach(card => container.appendChild(card));
});
