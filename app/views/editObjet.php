<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un objet</title>
</head>
<body>
    <h1>Modifier un objet</h1>
    <form action="/objet/<?php echo htmlspecialchars($objet['id']); ?>/update" method="post" enctype="multipart/form-data">
        <div>
            <label>Nom</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($objet['nom']); ?>" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($objet['description']); ?></textarea>
        </div>
        <div>
            <label>Catégorie</label>
            <input type="number" name="categorie_id" value="<?php echo htmlspecialchars($objet['categorie_id'] ?? 1); ?>">
        </div>
        <div>
            <label>Prix</label>
            <input type="text" name="prix" value="<?php echo htmlspecialchars($objet['prix']); ?>">
        </div>
        <div>
            <label>Ajouter des images</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>
        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>

    <h2>Images existantes</h2>
    <?php if (!empty($images)): ?>
        <ul>
            <?php foreach ($images as $img): ?>
                <li><?php echo htmlspecialchars($img['nom'] ?? $img['filename'] ?? ''); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>

<script>
    (function(){
        const form = document.querySelector('form');
        if(!form) return;
        const MAX_SIZE = 2 * 1024 * 1024; // 2MB
        form.addEventListener('submit', function(e){
            const nom = form.querySelector('[name=nom]').value.trim();
            const prix = form.querySelector('[name=prix]').value.trim();
            const cat = form.querySelector('[name=categorie_id]').value.trim();
            if(!nom){ alert('Le nom est requis'); e.preventDefault(); return false; }
            if(!/^[0-9]+(\.[0-9]{1,2})?$/.test(prix)){ alert('Prix invalide (ex: 10 ou 10.50)'); e.preventDefault(); return false; }
            if(!/^[0-9]+$/.test(cat) || parseInt(cat,10) <= 0){ alert('Catégorie invalide'); e.preventDefault(); return false; }
            const input = form.querySelector('[name="images[]"]');
            if(input && input.files){
                for(let i=0;i<input.files.length;i++){
                    const f = input.files[i];
                    if(!f.type.startsWith('image/')){ alert('Seuls les fichiers image sont autorisés'); e.preventDefault(); return false; }
                    if(f.size > MAX_SIZE){ alert('Chaque image doit être inférieure ou égale à 2MB'); e.preventDefault(); return false; }
                }
            }
        });
    })();
</script>
