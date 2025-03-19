// Importation des modules
import { greet } from './modules/module1.js';
import { farewell } from './modules/module2.js';

// Utilisation des fonctions importées
console.log(greet('Grace')); // Affiche "Hello, Alice!"
console.log(farewell('Jean-Marie')); // Affiche "Goodbye, Bob!"

// Initialisation de Swiper
const swiper = new Swiper('.swiper-container', {
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

// Vous pouvez ajouter d'autres initialisations ou fonctions globales ici
document.addEventListener('DOMContentLoaded', () => {
    console.log('Document prêt !');
});