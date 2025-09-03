<?php
require_once 'config.php';

// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fonction pour formater la taille du fichier en Ko, Mo ou Go
function formatTailleFichier($taille) {
    if ($taille >= 1073741824) {
        return round($taille / 1073741824, 2) . ' Go';
    } elseif ($taille >= 1048576) {
        return round($taille / 1048576, 2) . ' Mo';
    } elseif ($taille >= 1024) {
        return round($taille / 1024, 2) . ' Ko';
    } else {
        return $taille . ' octets';
    }
}

// Fonction pour obtenir l'icône en fonction du type de fichier
function getFileIcon($fileType) {
    $icons = [
        'pdf' => 'file-pdf',
        'doc' => 'file-word',
        'docx' => 'file-word',
        'xls' => 'file-excel',
        'xlsx' => 'file-excel',
        'ppt' => 'file-powerpoint',
        'pptx' => 'file-powerpoint',
        'jpg' => 'file-image',
        'jpeg' => 'file-image',
        'png' => 'file-image',
        'gif' => 'file-image',
        'zip' => 'file-archive',
        'rar' => 'file-archive',
        'txt' => 'file-alt',
    ];
    
    $fileType = strtolower($fileType);
    return isset($icons[$fileType]) ? $icons[$fileType] : 'file';
}

// Récupérer la liste des fichiers depuis la base de données
$sql = "SELECT * FROM fichiers ORDER BY date_upload DESC";
$result = mysqli_query($conn, $sql);

// Stocker les résultats dans un tableau pour une utilisation ultérieure
$fichiers = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fichiers[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléchargements - EMG</title>
    <meta name="description" content="Téléchargez nos documents et rapports - Empyra Mining Group">
    <link rel="stylesheet" href="style_global.css">
    <link rel="stylesheet" href="telechargement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <li class="item-menu"><a href="acceuil.html">Accueil</a></li>
                <li class="item-menu"><a href="services.html">Services</a></li>
                <li class="item-menu"><a href="#">Nos projets</a></li>
                <li class="item-menu"><a href="#">À propos</a></li>
                <li class="item-menu"><a href="telechargement.php" class="active">Téléchargement</a></li>
                <li class="item-menu"><a href="Contact.html">Contact</a></li>
                <li class="item-menu"><a href="#">Actualités</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="contact-section">
        <div class="overlay">
            <h1>Téléchargement</h1>
        </div>   
    </section>

    <!-- Section des documents disponibles -->
    <section class="documents-section section">
        <div class="container">
            <div class="section-title">
                <h2>Documents disponibles</h2>
                <p>Consultez et téléchargez nos documents officiels</p>
            </div>
            
            <div class="documents-grid">
                <?php if (!empty($fichiers)): ?>
                    <?php foreach ($fichiers as $fichier): 
                        $extension = strtolower(pathinfo($fichier['nom_fichier'], PATHINFO_EXTENSION));
                        $icone = getFileIcon($extension);
                    ?>
                        <div class="document-card">
                            <div class="document-icon">
                                <i class="fas fa-<?php echo $icone; ?>"></i>
                                <span class="file-extension"><?php echo strtoupper($extension); ?></span>
                            </div>
                            <div class="document-info">
                                <h3><?php echo htmlspecialchars($fichier['nom_fichier']); ?></h3>
                                <div class="document-meta">
                                    <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($fichier['date_upload'] ?? 'now')); ?></span>
                                    <span><i class="fas fa-file-download"></i> <?php echo formatTailleFichier($fichier['taille_fichier'] ?? 0); ?></span>
                                </div>
                                <p class="document-description"><?php echo htmlspecialchars($fichier['description'] ?? 'Aucune description disponible'); ?></p>
                                <a href="download.php?id=<?php echo $fichier['id']; ?>" class="download-btn">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-documents">
                        <i class="far fa-folder-open"></i>
                        <p>Aucun document disponible pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section du formulaire de demande -->
    <section class="form-section">
        <div class="form-container">
            <div class="form-header">
                <h2>Demander un document</h2>
                <p class="form-intro">Remplissez ce formulaire pour demander l'accès aux documents de votre choix. Notre équipe vous contactera dans les plus brefs délais.</p>
            </div>
            
            <form id="document-request-form" class="document-form" action="mailto:mysterende@gmail.com" method="post" enctype="text/plain">
                <div class="form-grid">
                    <div class="form-field required">
                        <label for="name">Nom complet</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="name" name="name" required placeholder="Votre nom complet">
                        </div>
                    </div>
                    
                    <div class="form-field required">
                        <label for="email">Adresse email</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" required placeholder="votre@email.com">
                        </div>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-field required">
                        <label for="company">Société</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" id="company" name="company" required placeholder="Nom de votre société">
                        </div>
                    </div>
                    
                    <div class="form-field required">
                        <label for="phone">Téléphone</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="tel" id="phone" name="phone" required placeholder="Votre numéro de téléphone">
                        </div>
                    </div>
                </div>
                
                <div class="form-field required">
                    <label for="document">Document demandé</label>
                    <div class="document-selector">
                        <i class="fas fa-file-alt input-icon"></i>
                        <select id="document" name="document" required>
                            <option value="" disabled selected>Sélectionnez un document</option>
                            <option value="Rapport annuel">PDF</option>
                            <option value="Données financières">EXCEL</option>
                            <option value="Rapport RSE">Rapport RSE</option>
                            <option value="Brochure entreprise">Brochure entreprise</option>
                            <option value="Autre">Autre (précisez ci-dessous)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-field">
                    <label for="message">Message complémentaire</label>
                    <div class="input-with-icon">
                        <i class="fas fa-comment-alt"></i>
                        <textarea id="message" name="message" placeholder="Décrivez votre demande..."></textarea>
                    </div>
                </div>
                <div class="form-field checkbox-field required">
                    <div class="form-check">
                        <input type="checkbox" id="privacy-policy" name="privacy-policy" required class="form-check-input">
                        <label for="privacy-policy" class="form-check-label">
                            J'accepte la <a href="#" id="privacy-policy-link" class="privacy-policy-link">politique de confidentialité</a>.
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Envoyer la demande
                    </button>
                </div>
            </form>
        </div>
    </section>

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
                <a href="services.html"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>services</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>a propos</span></a>
                <a href="#"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>Nos projets</span></a>
                <a href="telechargement.php"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>telechargement</span></a>
                <a href="Contact.html"><i><svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align:middle;"><path d="M4 8h8M8 4l4 4-4 4" stroke="#333" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></i><span>contact</span></a>
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
                        <a href="mailto:contact@empyra.com" style="color: #C9A13A; margin:0 10px; font-size:24px;">
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
            <p>&copy; 2025 EMPYRA MINING GROUP. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
<?php
// Fermer la connexion
if (isset($conn)) {
    mysqli_close($conn);
}
?>
