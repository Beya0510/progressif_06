class MenuHamburger {
    constructor(buttonId, menuId) {
        this.button = document.getElementById(buttonId);
        this.menu = document.getElementById(menuId);
        this.isOpen = false;

        if (this.button && this.menu) {
            this.button.addEventListener("click", () => this.toggleMenu());
        } else {
            console.error("Menu ou bouton introuvable !");
        }
    }

    toggleMenu() {
        this.isOpen = !this.isOpen;
        this.menu.classList.toggle("open", this.isOpen);
        this.button.addEventListener("click", function () {
            this.menu.classList.toggle("open");
            this.button.setAttribute(
                "aria-expanded",
                this.button.getAttribute("aria-expanded") === "true" ? "false" : "true"
            );
        });
        this.button.setAttribute("aria-label", this.isOpen ? "Masquer le menu" : "Afficher le menu");
    }
}

// Initialisation du menu hamburger sur toutes les pages
document.addEventListener("DOMContentLoaded", () => {
    new MenuHamburger("hamburger-button", "hamburger-menu");
});
