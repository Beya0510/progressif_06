class menuHamburger {
    constructor(menuId, buttonId) {
        this.menu = document.getElementById(menuId);
        this.button = document.getElementById(buttonId);
        this.isOpen = true;

        // Ajout de l'écouteur d'événements
        this.button.addEventListener('click', () => this.toggleMenu());
    }

    toggleMenu() {
        this.isOpen = !this.isOpen;
        this.menu.classList.toggle('open', this.isOpen);
        this.button.setAttribute('aria-expanded', this.isOpen);
        this.button.setAttribute('aria-label', this.isOpen ? 'Masquer le menu' : 'Afficher le menu');
    }
}

// Initialisation du menu hamburger
document.addEventListener('DOMContentLoaded', () => {
   const menu = new menuHamburger('main-menu', 'hamburger-menu');
});
