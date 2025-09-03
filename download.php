<?php
require_once 'config.php';

// Vérifier si un ID de fichier est fourni
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $fileId = (int)$_GET['id'];
    
    // Récupérer les informations du fichier depuis la base de données
    $sql = "SELECT * FROM fichiers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $fileId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Construire le chemin complet du fichier
        $filepath = __DIR__ . DIRECTORY_SEPARATOR . $row['chemin_fichier'];
        $filename = $row['nom_fichier'];
        
        // Nettoyer le nom du fichier pour la sécurité
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Vérifier si le fichier existe
        if (file_exists($filepath)) {
            // Définir les en-têtes pour le téléchargement
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            
            // Lire le fichier et l'envoyer au navigateur
            readfile($filepath);
            exit;
        } else {
            die('Erreur: Le fichier n\'existe plus sur le serveur.');
        }
    } else {
        die('Erreur: Fichier non trouvé dans la base de données.');
    }
} else {
    die('Erreur: Aucun fichier spécifié pour le téléchargement.');
}
?>
