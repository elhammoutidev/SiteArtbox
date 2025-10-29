<?php
// 1️⃣ Connexion à la base de données via PDO
require_once(__DIR__ . '/config/databaseconnect.php');

// 2️⃣ Récupération des œuvres publiées
$sql = 'SELECT id, title, artist, description, photo_url
        FROM oeuvres
        WHERE is_published = 1
        ORDER BY created_at DESC';
$stmt = $mysqlClient->prepare($sql);
$stmt->execute();
$oeuvres = $stmt->fetchAll();

require 'header.php';
?>

<!-- 3️⃣ Affichage des œuvres -->
<div id="liste-oeuvres">
    <?php foreach ($oeuvres as $oeuvre): ?>
        <article class="oeuvre">
            <a href="oeuvre.php?id=<?= (int)$oeuvre['id'] ?>">
                <img src="<?= htmlspecialchars($oeuvre['photo_url']) ?>"
                    alt="<?= htmlspecialchars($oeuvre['title']) ?>">
                <h2><?= htmlspecialchars($oeuvre['title']) ?></h2>
                <p class="description"><?= htmlspecialchars($oeuvre['artist']) ?></p>
            </a>
        </article>
    <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>