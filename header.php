<?php
// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empyra Mining Group</title>
    <link rel="stylesheet" href="style_global.css">
    <link rel="stylesheet" href="telechargement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src="images/Logo EMG.png" width="100px" height="100px" alt="Logo">
            </a>
        </div>
        <nav class="navbar">
            <div class="burger" id="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links" id="nav-links">
                <li class="item-menu"><a href="acceuil.html">Accueil</a></li>
                <li class="item-menu"><a href="services.html">Services</a></li>
                <li class="item-menu"><a href="#">Nos projets</a></li>
                <li class="item-menu"><a href="#">À propos</a></li>
                <li class="item-menu"><a href="telechargement.php" class="active">Téléchargements</a></li>
                <li class="item-menu"><a href="Contact.html">Contact</a></li>
                <li class="item-menu"><a href="#">Actualités</a></li>
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                    <li class="item-menu"><a href="admin_upload.php">Admin</a></li>
                    <li class="item-menu"><a href="logout.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>
