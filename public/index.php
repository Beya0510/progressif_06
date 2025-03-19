<?php
require_once '../src/gestionAuthentification.php';
require_once 'header.php';

$pageTitle = "Accueil";
?>

    <main class="accueil">
        <h1><?php echo $pageTitle; ?></h1>
        <br>
        <h3>Bienvenue sur notre site web</h3>
        <br><br><br><br><br>
        <p>Voici la page d'accueil.</p>

        <!-- Carrousel Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <img src="../assets/images/image1.png" alt="Description de l'image 1">
                </div>
                <div class="swiper-slide">
                    <img src="../assets/images/image2.png" alt="Description de l'image 2">
                </div>
                <div class="swiper-slide">
                    <img src="../assets/images/image3.png" alt="Description de l'image 3">
                </div>
            </div>
            <!-- Ajout des boutons de navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Importation de votre script menu.js -->
    <script src="../assets/Js/menu.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Initialisation de Swiper -->
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

<?php require_once 'footer.php'; ?>