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
    <script>
    (function(){
        const form = document.querySelector('form');
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
</body>
</html>
