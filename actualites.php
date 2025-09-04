<?php
require_once 'config.php';

// Récupérer les actualités depuis la base de données
$sql = "SELECT * FROM actualites WHERE statut = 'publie' ORDER BY date_publication DESC";
$result = mysqli_query($conn, $sql);
$actualites = [];
$categories = [
    'AACTUALITÉS ÉCONOMIQUES ET STRATÉGIQUES' => 'ACTUALITÉS ÉCONOMIQUES ET STRATÉGIQUES',
    'ACTUALITÉS SOCIALES ET ENVIRONNEMENTALES' => 'ACTUALITÉS SOCIALES ET ENVIRONNEMENTALES',
    'AUTRES ACTUALITÉS' => 'AUTRES ACTUALITÉS'
];

// Organiser les actualités par catégorie en maintenant l'ordre de date décroissant
while ($row = mysqli_fetch_assoc($result)) {
    if (isset($actualites[$row['categorie']])) {
        array_push($actualites[$row['categorie']], $row);
    } else {
        $actualites[$row['categorie']] = [$row];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualités - Empyra Mining Group</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style_global.css">
  <link rel="stylesheet" href="actuStyle.css">
  <script src="script.js" defer></script>
  <script src="scriptActu.js" defer></script>
</head>
<body>
   <header>
        <div class="logo">
            <img src="images/Logo EMG.png" width="100px" height="100px" alt="Logo">
        </div>
        <nav class="navbar">
            <div class="burger" id="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links" id="nav-links">
                <li class="item-menu"><a href="index.html">acceuil</a></li>
                <li class="item-menu"><a href="services.html">services</a></li>
                <li class="item-menu"><a href="#">nos projets</a></li>
                <li class="item-menu"><a href="#">a propos</a></li>
                <li class="item-menu"><a href="telechargement.php">telechargement</a></li>
                <li class="item-menu"><a href="Contact.html">contact</a></li>
                <li class="item-menu"><a href="actualites.php" class="active">actualites</a></li>
            </ul>
        </nav>
    </header>
    <!-- Banner -->
    <section class ="contact-section">
        <div class="overlay">
            <h1>Actualités</h1>
        </div>   
    </section>
<section class="gallery">
  <div class="gallery-wrapper swiper">
    <div class="gallery-container swiper-wrapper">
      <div class="gallery-item swiper-slide">
        <img src="images/Asset 1@3x.png" alt="">
        <div class="text-content">
          <h2>Inauguration d’un nouveau site d’extraction à Bertoua</h2>
          <p>Nous sommes ravis d'annoncer l'inauguration de notre nouveau site 
            d'extraction à Bertoua, qui renforcera notre capacité à fournir des 
            ressources minérales de manière durable et .</p>
        </div>
      </div>
      <div class="gallery-item swiper-slide">
        <img src="images/mine2.jpeg" alt="">
        <div class="text-content">
          <h2>Empyra Mining s’engage pour l’environnement</h2>
          <p>Nous mettons en place des initiatives pour réduire 
            notre empreinte écologique et promouvoir la durabilité 
            dans nos opérations.</p>
        </div>
      </div>
      <div class="gallery-item swiper-slide">
        <img src="images/maroua.jpeg" alt="">
        <div class="text-content">
          <h2>Sécurité au travail : zéro accident en 2025</h2>
          <p>Nous nous engageons à garantir la sécurité de nos employés en mettant en œuvre des mesures strictes et des formations régulières.</p>
        </div>
      </div>
      <div class="gallery-item swiper-slide">
        <img src="images/mine1.jpeg" alt="">
        <div class="text-content">
          <h2>Partenariat stratégique avec la communauté locale</h2>
          <p>Nous croyons en l'importance de travailler en étroite collaboration avec les communautés locales pour assurer un développement durable et responsable.</p>
        </div>
      </div>
      <div class="gallery-item swiper-slide">
        <img src="images/mine2.jpeg" alt="">
        <div class="text-content">
          <h2>Innovation : introduction de nouvelles technologies d’extraction durable</h2>
          <p>Nous sommes fiers d'annoncer l'introduction de nouvelles technologies d'extraction qui minimisent l'impact environnemental tout en maximisant l'efficacité.</p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div> <!-- If we need navigation buttons -->
</section>

    <div class="container">
        <h1 class="main-title">NEWS</h1>
        
        <?php foreach ($categories as $categorie_id => $categorie_titre): ?>
            <?php if (!empty($actualites[$categorie_id])): ?>
                <div class="news-section">
                    <div class="section-header">
                        <button type="button" class="triangle-btn" aria-label="Afficher/cacher la section">
                            <span class="triangle">&#9654;</span>
                        </button>
                        <h2><?php echo $categorie_titre; ?></h2>
                    </div>
                    
                    <?php foreach ($actualites[$categorie_id] as $actualite): 
                        $date_publication = date('d/m/Y', strtotime($actualite['date_publication']));
                    ?>
                        <div class="news-item collapsible">
                            <?php if (!empty($actualite['image_url'])): ?>
                                <div class="image-container">
                                    <img src="<?php echo htmlspecialchars($actualite['image_url']); ?>" alt="<?php echo htmlspecialchars($actualite['titre']); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="text-container">
                                <h3><?php echo htmlspecialchars($actualite['titre']); ?></h3>
                                <div class="actualite-meta">
                                    <span>Publié le <?php echo $date_publication; ?></span>
                                    <?php if (!empty($actualite['auteur'])): ?>
                                        <span> | Auteur: <?php echo htmlspecialchars($actualite['auteur']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <p><?php echo nl2br(htmlspecialchars($actualite['contenu'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <footer>
        <div class="footer-content">
            <div class="footer-item">
                <div class="footer-item-logo">
                    <img src="images/Logo EMG.png" width="100px" height="100px" alt="logo">
                </div>
                <p>Découvrez comment Empyra Mining Group contribue à l'économie locale et à la préservation de l'environnement grâce à nos activités d'extraction minière responsable et durable</p>
            </div>
            <div class="footer-item">
                <h6>Réseaux sociaux</h6>
                <div class="social-content">
                    <div class="social-icons">
                            <a href="https://facebook.com" target="_blank" style="color:#C9A13A; margin:0 10px; font-size:24px;">
                            <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank" style="color:#C9A13A; margin:0 10px; font-size:24px;">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://x.com" target="_blank" style="color:#C9A13A; margin:0 10px; font-size:24px;">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                    </div>
                </div>
            </div>
            <div class="footer-links footer-item">
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>services</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>a propos</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>Nos projets</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>telechargement</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>contact</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>actualites</span></a>
            </div>
            <div class="footer-item">
                <h6>Contacter nous</h6>
                <div class="footer-contact">
                    <div class="contact-item">
                        <a href="tel:+237671135872" style="color:#C9A13A; margin:0 10px; font-size:24px;">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <span>+237 671135872</span>
                    </div>
                    <div class="contact-item">
                        <a href="mailto:contact@exemple.com" style="color: #C9A13A; margin:0 10px; font-size:24px;">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                        <span>contact@empyra.com</span>
                    </div>
                    <div class="contact-item">
                        <a href="https://www.google.com/maps/place/Douala,+Cameroun" target="_blank" style="color:#C9A13A; margin:0 10px; font-size:24px;">
                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                        <span>localisation</span>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align:center; margin-top:20px; color:#fff;">
            <p>&copy; 2023 EMPYRA MINING GROUP. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>