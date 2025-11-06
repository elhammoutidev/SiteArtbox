<?php
// On inclut la connexion à la base dès le début du fichier
require_once 'bdd.php';

// Validation du formulaire d'ajout d'une œuvre (étape 5)

// 1) On vérifie que la page a bien été appelée en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Accès direct interdit : on renvoie vers le formulaire
    header('Location: ajouter.php');
    exit;
}

// 2) On récupère les données envoyées en POST
$postData = $_POST;

// On récupère chaque champ en gérant le cas où il n'existerait pas
$titleRaw       = isset($postData['title']) ? trim($postData['title']) : ''; // isset() signifie “est-ce que cette variable existe ?”
$artistRaw      = isset($postData['artist']) ? trim($postData['artist']) : '';
$descriptionRaw = isset($postData['description']) ? trim($postData['description']) : '';
$photoUrlRaw    = isset($postData['photo_url']) ? trim($postData['photo_url']) : '';

// 3) Tableau pour stocker les messages d'erreur
$errors = [];

// 4) Vérifications des champs (selon les consignes)

// 4.1 Titre obligatoire
if ($titleRaw === '') {
    $errors[] = "Le titre de l’œuvre est obligatoire.";
}

// 4.2 Artiste obligatoire
if ($artistRaw === '') {
    $errors[] = "Le nom de l’artiste est obligatoire.";
}

// 4.3 Description : au moins 3 caractères
if (mb_strlen($descriptionRaw) < 3) {
    $errors[] = "La description doit contenir au moins 3 caractères.";
}

// 4.4 URL de l'image : obligatoire + doit commencer par https://
if ($photoUrlRaw === '') {
    $errors[] = "L’URL de l’image est obligatoire.";
} elseif (strpos($photoUrlRaw, 'https://') !== 0) {
    $errors[] = "L’URL de l’image doit commencer par https://";
}

// 5) Versions sécurisées pour l'affichage (contre XSS)
$title       = htmlspecialchars($titleRaw, ENT_QUOTES, 'UTF-8');
$artist      = htmlspecialchars($artistRaw, ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($descriptionRaw, ENT_QUOTES, 'UTF-8');
$photoUrl    = htmlspecialchars($photoUrlRaw, ENT_QUOTES, 'UTF-8');

// 6) Si AUCUNE erreur : on insère en BDD puis on redirige
if (empty($errors)) {
    // Connexion à la base de données
    $pdo = connexion();

    // Requête d'insertion
    $sql = "INSERT INTO oeuvres (title, artist, description, photo_url)
            VALUES (:title, :artist, :description, :photo_url)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':title'       => $titleRaw,
        ':artist'      => $artistRaw,
        ':description' => $descriptionRaw,
        ':photo_url'   => $photoUrlRaw,
    ]);

    // Redirection vers la page d'accueil après succès
    header('Location: index.php');
    exit;
}
?>

<?php include 'header.php'; ?>

<main>
    <h1>Résultat du formulaire de création d’œuvre</h1>

    <?php if (!empty($errors)): ?>
        <!-- Il y a au moins une erreur -->
        <h2>Le formulaire contient des erreurs :</h2>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>

        <p>
            <a href="ajouter.php">⬅️ Retour au formulaire</a>
        </p>

    <?php else: ?>
        <!-- Aucune erreur : ce bloc ne s'affichera normalement jamais,
             car on redirige déjà vers index.php en cas de succès -->
        <h2>Les informations sont valides ✅</h2>
        <p>Les données ont été enregistrées avec succès.</p>

        <h3>Récapitulatif de l’œuvre :</h3>
        <ul>
            <li><strong>Titre :</strong> <?= $title ?></li>
            <li><strong>Artiste :</strong> <?= $artist ?></li>
            <li><strong>Description :</strong> <?= $description ?></li>
            <li><strong>URL de l’image :</strong> <?= $photoUrl ?></li>
        </ul>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>