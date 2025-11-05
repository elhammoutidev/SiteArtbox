<?php
// -----------------------------
// Fonction de connexion à la base de données ArtBox
// -----------------------------

function connexion()
{
    // Nom du serveur : ici "localhost" car on travaille en local avec XAMPP
    $host = 'localhost';

    // Nom de la base de données créée dans phpMyAdmin
    $dbname = 'artbox';

    // Identifiant de connexion MySQL (par défaut : "root" sous XAMPP)
    $user = 'root';

    // Mot de passe MySQL (vide par défaut dans XAMPP)
    $password = '';

    try {
        // Création de la connexion avec PDO
        // "mysql:host" précise le type de base et l’adresse du serveur
        // "dbname" indique le nom de la base de données
        // "charset=utf8mb4" permet de bien gérer les accents et caractères spéciaux
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);

        // On active le mode d'affichage des erreurs (important pour le développement)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Si tout est correct, la fonction renvoie l'objet PDO
        return $pdo;
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, le message détaillé s'affiche
        // Cela aide à comprendre le problème (mauvais mot de passe, mauvaise base, etc.)
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }
}
