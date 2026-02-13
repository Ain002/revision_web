<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche objet - <?php echo htmlspecialchars($objet['nom'] ?? 'Objet'); ?></title>
    <style>
        .thumb { max-width:180px; max-height:140px; object-fit:cover; margin:6px; border:1px solid #ccc; padding:4px; background:#fff; }
        .images { display:flex; flex-wrap:wrap; align-items:center; }
        .meta { margin:12px 0; }
    </style>
</head>
<body>
    <a href="javascript:history.back()">← Retour</a>
    <h1><?php echo htmlspecialchars($objet['nom'] ?? 'Objet'); ?></h1>

    <div class="meta">
        <strong>Prix :</strong> <?php echo htmlspecialchars($objet['prix'] ?? ''); ?>
        &nbsp;|&nbsp;
        <strong>Catégorie :</strong> <?php echo htmlspecialchars($objet['categorie_id'] ?? $objet['categorie'] ?? ''); ?>
        &nbsp;|&nbsp;
        <strong>Ajouté le :</strong> <?php echo htmlspecialchars($objet['date_ajout'] ?? $objet['created_at'] ?? ''); ?>
        &nbsp;|&nbsp;
        <strong>Propriétaire :</strong> <?php echo htmlspecialchars($objet['proprietaire_id'] ?? ''); ?>
    </div>

    <section>
        <h2>Description</h2>
        <p><?php echo nl2br(htmlspecialchars($objet['description'] ?? '')); ?></p>
    </section>

    <section>
        <h2>Images</h2>
        <?php if (!empty($images) && is_array($images)): ?>
            <div class="images">
                <?php foreach ($images as $img):
                    $name = $img['nom'] ?? $img['url'] ?? $img['filename'] ?? null;
                    if (!$name) continue;
                    $src = (strpos($name, 'http') === 0 || strpos($name, '/') === 0) ? $name : '/uploads/' . ltrim($name, '/');
                ?>
                    <div>
                        <img class="thumb" src="<?php echo htmlspecialchars($src); ?>" alt="<?php echo htmlspecialchars($objet['nom'] ?? 'image'); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucune image pour cet objet.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Actions</h2>
        <?php $id = $objet['id'] ?? $objet['objet_id'] ?? $objet['id_objet'] ?? null; ?>
        <?php if ($id): ?>
            <a href="/objet/<?php echo urlencode($id); ?>/edit" style="margin-right:8px;">Modifier</a>
            <form action="/objet/<?php echo urlencode($id); ?>/delete" method="post" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression ?');">
                <button type="submit">Supprimer</button>
            </form>
        <?php endif; ?>
    </section>

</body>
</html>
