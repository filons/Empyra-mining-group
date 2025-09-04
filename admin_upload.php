<?php
require_once 'config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["fichier"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        $message = "Désolé, ce fichier existe déjà.";
        $uploadOk = 0;
    }
    
    // Vérifier la taille du fichier (max 10MB)
    if ($_FILES["fichier"]["size"] > 10000000) {
        $message = "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }
    
    // Autoriser certains formats de fichiers
    $allowed_types = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png');
    if (!in_array($fileType, $allowed_types)) {
        $message = "Désolé, seuls les fichiers PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG sont autorisés.";
        $uploadOk = 0;
    }
    
    // Vérifier si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        $message = "Désolé, votre fichier n'a pas été téléchargé. " . $message;
    } else {
        if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $target_file)) {
            // Préparer et exécuter la requête d'insertion
            $nom_fichier = basename($_FILES["fichier"]["name"]);
            $description = $_POST['description'];
            $taille_fichier = $_FILES["fichier"]["size"];
            $chemin_fichier = $target_file;
            
            $sql = "INSERT INTO fichiers (nom_fichier, type_fichier, taille_fichier, description, chemin_fichier) 
                    VALUES (?, ?, ?, ?, ?)";
                    
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssiss", $nom_fichier, $fileType, $taille_fichier, $description, $chemin_fichier);
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Le fichier " . htmlspecialchars($nom_fichier) . " a été téléchargé avec succès.";
                } else {
                    $message = "Erreur lors de l'enregistrement en base de données: " . mysqli_error($conn);
                }
                
                mysqli_stmt_close($stmt);
            }
        } else {
            $message = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Upload de fichiers | EMG</title>
    <meta name="description" content="Espace d'administration pour le téléversement de fichiers - Empyra Mining Group">
    <link rel="stylesheet" href="style_global.css">
    <link rel="stylesheet" href="telechargement.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .upload-form {
            margin-top: 20px;
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
        
        .form-group input[type="file"], 
        .form-group textarea,
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input[type="file"] {
            padding: 8px;
        }
        
        .form-group input:focus, 
        .form-group textarea:focus {
            outline: none;
            border-color: #C9A13A;
            box-shadow: 0 0 0 2px rgba(201, 161, 58, 0.2);
        }
        
        .btn-upload {
            background: #C9A13A;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-upload:hover {
            background: #b38f35;
        }
        
        .message {
            padding: 15px;
            margin: 0 0 20px 0;
            border-radius: 5px;
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
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #C9A13A;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .file-list {
            margin-top: 30px;
        }
        .file-list h3 {
            color: #2C3E50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #C9A13A;
        }
        .action-buttons a {
            color: #C9A13A;
            margin-right: 10px;
            text-decoration: none;
        }
        .action-buttons a:hover {
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
                <li class="item-menu"><a href="admin_upload.php" class="active">InsertionDocucument</a></li>
                <li class="item-menu"><a href="admin_upload_Actu.php">InsertionActualités</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="contact-section">
        <div class="overlay">
            <h1>Administration</h1>
            <p>Gestion des fichiers téléchargeables</p>
        </div>   
    </section>
    
    <div class="admin-container">
        <h2><i class="fas fa-upload"></i> Téléverser un nouveau fichier</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'succès') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="upload-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="fichier">Sélectionner un fichier (max 10MB) :</label>
                    <input type="file" name="fichier" id="fichier" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.txt">
                    <small class="text-muted">Formats acceptés : PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, JPEG, PNG, TXT</small>
                </div>
                
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea name="description" id="description" rows="4" placeholder="Ajoutez une description détaillée du fichier..."></textarea>
                </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-upload">
                    <i class="fas fa-upload"></i> Téléverser le fichier
                </button>
                <a href="telechargement.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Retour aux téléchargements
                </a>
            </div>
            </form>
        </div>
        
        <div style="margin-top: 40px;">
            <h3><i class="fas fa-list"></i> Fichiers récemment ajoutés</h3>
            <?php
            $recent_files = mysqli_query($conn, "SELECT nom_fichier, date_upload FROM fichiers ORDER BY date_upload DESC LIMIT 5");
            if (mysqli_num_rows($recent_files) > 0): ?>
                <ul style="margin-top: 15px; padding-left: 20px;">
                <?php while ($file = mysqli_fetch_assoc($recent_files)): ?>
                    <li style="margin-bottom: 8px;">
                        <i class="fas fa-file-alt" style="color: #C9A13A;"></i> 
                        <?php echo htmlspecialchars($file['nom_fichier']); ?>
                        <small style="color: #888; margin-left: 10px;">
                            (<?php echo date('d/m/Y H:i', strtotime($file['date_upload'])); ?>)
                        </small>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p style="color: #666; font-style: italic;">Aucun fichier n'a encore été téléversé.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        // Script pour le menu burger
        const burgerMenu = document.getElementById('burger-menu');
        const navLinks = document.getElementById('nav-links');
        
        if (burgerMenu && navLinks) {
            burgerMenu.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                burgerMenu.classList.toggle('active');
            });
        }
        
        // Afficher le nom du fichier sélectionné
        document.getElementById('fichier').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Aucun fichier sélectionné';
            const fileSize = e.target.files[0] ? ' (' + formatFileSize(e.target.files[0].size) + ')' : '';
            this.nextElementSibling.textContent = 'Fichier sélectionné : ' + fileName + fileSize;
        });
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
</body>
</html>

<?php
// Fermer la connexion
mysqli_close($conn);
?>
