<?php
include 'header.php';
// On inclut le fichier de connexion
require_once 'bdd.php';

// On appelle la fonction pour obtenir l'objet PDO
$pdo = connexion();

// On écrit la requête SQL pour récupérer les oeuvres publiées
$sql = "SELECT id, title, artist, description, photo_url FROM oeuvres WHERE is_published = 1 ORDER BY created_at DESC";

// On exécute la requête
$stmt = $pdo->query($sql);

// On récupère toutes les oeuvres sous forme de tableau associatif
$oeuvres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Affichage des œuvres -->
<div id="liste-oeuvres">

    <!-- Boucle PHP : on parcourt chaque œuvre récupérée depuis la base de données -->
    <?php foreach ($oeuvres as $oeuvre): ?>

        <!-- Chaque œuvre est affichée sous forme d’un article -->
        <article class="oeuvre">

            <!-- Le lien mène vers la page détail de l’œuvre, en envoyant son id dans l’URL -->
            <a href="oeuvre.php?id=<?= (int)$oeuvre['id'] ?>">

                <!-- Image de l’œuvre -->
                <img src="<?= htmlspecialchars($oeuvre['photo_url']) ?>"
                    alt="<?= htmlspecialchars($oeuvre['title']) ?>"> <!-- Texte alternatif pour l’accessibilité -->

                <!-- Titre de l’œuvre -->
                <h2><?= htmlspecialchars($oeuvre['title']) ?></h2>

                <!-- Nom de l’artiste -->
                <p class="description"><?= htmlspecialchars($oeuvre['artist']) ?></p>

            </a>
        </article>

        <!-- Fin de la boucle PHP -->
    <?php endforeach; ?>

</div>

<!-- Inclusion du pied de page -->
<?php include 'footer.php'; ?>