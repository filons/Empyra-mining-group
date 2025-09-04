# Empyra Mining Group

## Description
Site web de présentation pour Empyra Mining Group, une entreprise spécialisée dans l'exploitation minière.

## Prérequis
- Serveur web (Apache, Nginx, etc.)
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur (pour la base de données du formulaire de contact)
- Composer (pour la gestion des dépendances PHP si nécessaire)

## Installation

1. **Téléchargement des fichiers**
   - Cloner le dépôt ou télécharger les fichiers sources
   ```bash
   git clone [URL_DU_DEPOT]
   ```

2. **Configuration du serveur**
   - Placer les fichiers dans le répertoire racine de votre serveur web (par exemple `htdocs/` pour XAMPP ou `/var/www/html/` pour Linux)
   - Assurez-vous que le module `mod_rewrite` d'Apache est activé

3. **Configuration de la base de données**
   - Créer une base de données MySQL
   - Importer le fichier SQL (s'il existe) ou exécuter les requêtes nécessaires
   - Configurer les accès dans le fichier `config.php`

4. **Configuration PHP**
   - Vérifier que les extensions PHP nécessaires sont activées (pdo_mysql, mysqli, etc.)
   - Configurer les permissions des dossiers (uploads/ doit être accessible en écriture)

## Utilisation

1. **Accès au site**
   - Ouvrir un navigateur et accéder à l'URL du site (par exemple : `http://localhost/Empyra-mining-group/`)

2. **Pages disponibles**
   - Page d'accueil (`index.html`)
   - Services (`services.html`)
   - Téléchargements (`telechargement.php`)
   - Contact (`Contact.html`)
   - Administration (`admin_upload.php` pour la gestion des téléchargements)

3. **Fonctionnalités**
   - Formulaire de contact avec envoi d'email
   - Téléchargement de documents
   - Interface d'administration pour gérer les fichiers à télécharger

## Développement

### Structure des dossiers
- `/` - Fichiers principaux du site
- `/uploads/` - Fichiers téléversés
- `/images/` - Images du site

### Personnalisation
- Modifier les fichiers CSS dans le dossier racine
- Les couleurs principales sont définies dans les variables CSS au début des fichiers
- Les polices peuvent être modifiées dans les fichiers CSS

## Sécurité
- Ne pas modifier les permissions des fichiers inutilement
- Toujours vérifier les fichiers téléversés
- Garder les identifiants de base de données sécurisés

## Support
Pour toute question ou problème, veuillez contacter l'administrateur du site.

---
*Dernière mise à jour : 03/09/2024*
