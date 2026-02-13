<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un objet</title>
</head>
<body>
    <h1>Ajouter un objet</h1>
    <form action="/objet/store" method="post" enctype="multipart/form-data">
        <div>
            <label>Nom</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Catégorie</label>
            <input type="number" name="categorie_id" value="1">
        </div>
        <div>
            <label>Prix</label>
            <input type="text" name="prix" value="0">
        </div>
        <div>
            <label>Images</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>
        <div>
            <button type="submit">Créer</button>
        </div>
    </form>
</body>
</html>
