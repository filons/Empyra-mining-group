<?php
require_once 'config.php';
$message = '';

// Traitement de la suppression d'actualité
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM actualites WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "L'actualité a été supprimée avec succès.";
        } else {
            $message = "Erreur lors de la suppression de l'actualité: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// Traitement de l'ajout d'actualité
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_actu'])) {
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $contenu = mysqli_real_escape_string($conn, $_POST['contenu']);
    $categorie = mysqli_real_escape_string($conn, $_POST['categorie']);
    $auteur = isset($_POST['auteur']) ? mysqli_real_escape_string($conn, $_POST['auteur']) : 'Administrateur';
    $statut = 'publie';
    
    // Gestion de l'upload de l'image
    $image_url = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/actualites/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Vérifier le type de fichier
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                $message = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $message = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        }
    }
    
    if (empty($message)) {
        // Vérifier la connexion
        if (!$conn) {
            $message = "Erreur de connexion à la base de données: " . mysqli_connect_error();
        } else {
            $sql = "INSERT INTO actualites (titre, contenu, image_url, categorie, auteur, statut) 
                    VALUES (?, ?, ?, ?, ?, ?)";
                    
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $titre, $contenu, $image_url, $categorie, $auteur, $statut);
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = "L'actualité a été ajoutée avec succès.";
                    // Réinitialiser les champs du formulaire
                    $_POST = array();
                    // Recharger la page pour afficher la nouvelle actualité
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    $message = "Erreur lors de l'ajout de l'actualité: " . mysqli_error($conn);
                    // Afficher la requête pour le débogage
                    $message .= "<br>Requête: " . $sql;
                    $message .= "<br>Valeurs: " . print_r([$titre, $contenu, $image_url, $categorie, $auteur, $statut], true);
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $message = "Erreur de préparation de la requête: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Gestion des actualités | EMG</title>
    <meta name="description" content="Espace d'administration pour la gestion des actualités - Empyra Mining Group">
    <link rel="stylesheet" href="style_global.css">
    <link rel="stylesheet" href="telechargement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2C3E50;
            font-weight: 500;
        }
        
        .form-group input[type="text"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn {
            background: #C9A13A;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #b38f35;
        }
        
        .btn-danger {
            background: #e74c3c;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .actualite-item {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 4px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .actualite-item:hover {
            background-color: #f0f0f0;
        }
        
        .actualite-header {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .actualite-header h3 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 15px;
        }
        
        .actualite-meta {
            color: #666;
            font-size: 13px;
            margin: 0;
        }
        
        .actualite-date {
            color: #888;
            font-size: 12px;
            margin-right: 15px;
            white-space: nowrap;
        }
        
        .actualite-actions {
            display: flex;
            gap: 8px;
        }
        
        .actualite-image {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 3px;
            margin-right: 15px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #45a049;
        }
        
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        
        .btn i {
            font-size: 12px;
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }
        
        .back-link {
            color: #C9A13A;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
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
                <li class="item-menu"><a href="admin_upload.php">InsertionDocuments</a></li>
                <li class="item-menu"><a href="admin_upload_Actu.php" class="active">InsertionActualités</a></li>
            </ul>
        </nav>
    </header>
    <div class="admin-container">
        <h1>Gestion des Actualités</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <section class="form-section">
            <h2>Ajouter une nouvelle actualité</h2>
            <form action="" method="post" enctype="multipart/form-data" class="upload-form">
                <div class="form-group">
                    <label for="titre">Titre de l'actualité *</label>
                    <input type="text" id="titre" name="titre" required value="<?php echo isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="contenu">Contenu de l'actualité *</label>
                    <textarea id="contenu" name="contenu" rows="6" required><?php echo isset($_POST['contenu']) ? htmlspecialchars($_POST['contenu']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="categorie">Catégorie *</label>
                    <select id="categorie" name="categorie" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <option value="AACTUALITÉS ÉCONOMIQUES ET STRATÉGIQUES" <?php echo (isset($_POST['categorie']) && $_POST['categorie'] === 'AACTUALITÉS ÉCONOMIQUES ET STRATÉGIQUES') ? 'selected' : ''; ?>>ACTUALITÉS ÉCONOMIQUES ET STRATÉGIQUES</option>
                        <option value="ACTUALITÉS SOCIALES ET ENVIRONNEMENTALES" <?php echo (isset($_POST['categorie']) && $_POST['categorie'] === 'ACTUALITÉS SOCIALES ET ENVIRONNEMENTALES') ? 'selected' : ''; ?>>ACTUALITÉS SOCIALES ET ENVIRONNEMENTALES</option>
                        <option value="AUTRES ACTUALITÉS" <?php echo (isset($_POST['categorie']) && $_POST['categorie'] === 'AUTRES ACTUALITÉS') ? 'selected' : ''; ?>>Autres</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" value="<?php echo isset($_POST['auteur']) ? htmlspecialchars($_POST['auteur']) : 'Administrateur'; ?>">
                </div>
                
                <div class="form-group">
                    <label for="image">Image d'illustration</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small>Formats acceptés : JPG, JPEG, PNG, GIF (max 2MB)</small>
                </div>
                
                <div class="form-actions">
                    <a href="actualites.php" class="back-link">
                        <i class="fas fa-arrow-left"></i> Retour à Actualités
                    </a>
                    <button type="submit" name="ajouter_actu" class="btn">
                        <i class="fas fa-plus"></i> Ajouter l'actualité
                    </button>
                </div>
            </form>
        </section>

        <section class="list-section">
            <h2>Actualités existantes</h2>
            <?php
            // Récupérer la liste des actualités
            $sql = "SELECT * FROM actualites ORDER BY date_publication DESC";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
                    $date_publication = date('d/m/Y', strtotime($row['date_publication']));
            ?>
                <div class="actualite-item">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="" class="actualite-image">
                    <?php endif; ?>
                    
                    <div class="actualite-header">
                        <h3><?php echo htmlspecialchars($row['titre']); ?></h3>
                        <div class="actualite-meta">
                            <span class="actualite-date"><?php echo $date_publication; ?></span>
                            <span>• Catégorie: <?php echo htmlspecialchars($row['categorie']); ?></span>
                            <?php if (!empty($row['auteur'])): ?>
                                <span>• Auteur: <?php echo htmlspecialchars($row['auteur']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="actualite-actions">
                        <a href="#" class="btn btn-edit" onclick="editActualite(<?php echo $row['id']; ?>)" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-delete" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?')" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            <?php
                endwhile;
            else:
                echo '<p>Aucune actualité n\'a été trouvée.</p>';
            endif;
            ?>
        </section>
    </div>

    <script>
        // Menu burger pour mobile
        const burgerMenu = document.getElementById('burger-menu');
        const navLinks = document.getElementById('nav-links');
        
        burgerMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            burgerMenu.classList.toggle('active');
        });
        
        // Fonction pour éditer une actualité (à implémenter)
        function editActualite(id) {
            alert('Fonctionnalité de modification à implémenter pour l\'actualité ID: ' + id);
            // Redirection vers une page d'édition ou affichage d'un formulaire modal
            // window.location.href = 'edit_actualite.php?id=' + id;
        }
        
        // Gestion de l'affichage des messages
        const messageElement = document.querySelector('.message');
        if (messageElement) {
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>