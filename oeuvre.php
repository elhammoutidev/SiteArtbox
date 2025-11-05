<?php
include 'header.php';

// On vérifie qu'un id est bien présent dans l'URL
if (!isset($_GET['id'])) {
    // Si pas d'id, on redirige vers la page d'accueil
    header('Location: index.php');
    exit;
}

// On récupère l'id dans l'URL et on le convertit en entier
$id = (int) $_GET['id'];

// On inclut le fichier de connexion
require_once 'bdd.php';

// On se connecte à la base de données
$pdo = connexion();

// Requête préparée : on récupère l'oeuvre correspondant à cet id
$sql = "SELECT id, title, artist, description, photo_url 
        FROM oeuvres 
        WHERE id = :id";

// Préparation de la requête
$stmt = $pdo->prepare($sql);

// Exécution avec la valeur de l'id
$stmt->execute(['id' => $id]);

// On récupère une seule oeuvre (ou false si aucune trouvée)
$oeuvre = $stmt->fetch(PDO::FETCH_ASSOC);

// Si aucune oeuvre trouvée, on redirige vers l'accueil
if (!$oeuvre) {
    header('Location: index.php');
    exit;
}
?>

<article class="oeuvre-detail">
    <img src="<?= htmlspecialchars($oeuvre['photo_url']) ?>"
        alt="<?= htmlspecialchars($oeuvre['title']) ?>">
    <h1><?= htmlspecialchars($oeuvre['title']) ?></h1>
    <p class="artist"><?= htmlspecialchars($oeuvre['artist']) ?></p>
    <p class="description"><?= htmlspecialchars($oeuvre['description']) ?></p>
</article>

<?php include 'footer.php'; ?>