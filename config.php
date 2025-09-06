<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Remplacez par votre nom d'utilisateur MySQL
define('DB_PASSWORD', ''); // Remplacez par votre mot de passe MySQL
define('DB_NAME', 'empyra_files');

// Connexion à la base de données
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if($conn === false){
    die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}

// Créer la table fichiers si elle n'existe pas
$sql = "CREATE TABLE IF NOT EXISTS fichiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_fichier VARCHAR(255) NOT NULL,
    type_fichier VARCHAR(100) NOT NULL,
    taille_fichier INT NOT NULL,
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT,
    chemin_fichier VARCHAR(255) NOT NULL
)";

if (!mysqli_query($conn, $sql)) {
    echo "Erreur lors de la création de la table fichiers: " . mysqli_error($conn);
}

// Créer la table actualites si elle n'existe pas
$sql = "CREATE TABLE IF NOT EXISTS actualites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image_url VARCHAR(255) DEFAULT '',
    categorie VARCHAR(100) NOT NULL,
    auteur VARCHAR(100) NOT NULL DEFAULT 'Administrateur',
    statut ENUM('brouillon', 'publie') DEFAULT 'publie',
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($conn, $sql)) {
    echo "Erreur lors de la création de la table actualites: " . mysqli_error($conn);
}
?>
