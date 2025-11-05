<?php require 'header.php';

?>

<form action="traitement.php" method="POST">
    <div class="champ-formulaire">
        <label for="titre">Titre de l'œuvre</label>
        <input type="text" name="title" id="titre">
    </div>

    <div class="champ-formulaire">
        <label for="artiste">Auteur de l'œuvre</label>
        <input type="text" name="artist" id="artiste">
    </div>

    <div class="champ-formulaire">
        <label for="image">URL de l'image</label>
        <input type="url" name="photo_url" id="image">
    </div>

    <div class="champ-formulaire">
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
    </div>

    <input type="submit" value="Valider" name="submit">
</form>


<?php require 'footer.php'; ?>