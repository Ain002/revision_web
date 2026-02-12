<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes objets</title>
</head>
<body>
    <div class="container">
        <h1>Mes objets</h1>

        <p>
            <a href="/objet/create" style="display:inline-block;padding:8px 12px;background:#2d89ef;color:#fff;border-radius:4px;text-decoration:none;">Ajouter un objet</a>
        </p>

        <div>
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f5f5f5;text-align:left;">
                        <th style="padding:8px;border:1px solid #ddd;">Image</th>
                        <th style="padding:8px;border:1px solid #ddd;">Nom</th>
                        <th style="padding:8px;border:1px solid #ddd;">Description</th>
                        <th style="padding:8px;border:1px solid #ddd;">Catégorie</th>
                        <th style="padding:8px;border:1px solid #ddd;">Prix</th>
                        <th style="padding:8px;border:1px solid #ddd;">Date d'ajout</th>
                        <th style="padding:8px;border:1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mesObjets as $objet):
                        $objId = $objet['id'] ?? $objet['objet_id'] ?? $objet['id_objet'] ?? null;
                        $imgUrl = null;

                        if (!empty($images) && is_array($images) && $objId) {
                            foreach ($images as $image) {
                                if ((string)($image['objet_id'] ?? '') === (string)$objId) {
                                    $name = $image['url'] ?? $image['nom'] ?? $image['path'] ?? null;
                                    if ($name) {
                                        $imgUrl = (strpos($name, 'http') === 0 || strpos($name, '/') === 0) ? $name : '/uploads/' . ltrim($name, '/');
                                        break;
                                    }
                                }
                            }
                        }

                        if (!$imgUrl) {
                            $imgUrl = 'data:image/svg+xml;utf8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="120" height="90"><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#aaa" font-family="Arial" font-size="12">Pas d\'image</text></svg>');
                        }
                    ?>
                        <tr>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;">
                                <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($objet['nom'] ?? 'objet'); ?>" style="max-width:120px;max-height:90px;object-fit:cover;border:1px solid #ccc;padding:2px;background:#fff;">
                            </td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;"><?php echo htmlspecialchars($objet['nom'] ?? ''); ?></td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;"><?php echo htmlspecialchars($objet['description'] ?? ''); ?></td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;"><?php echo htmlspecialchars($objet['categorie_id'] ?? $objet['categorie'] ?? ''); ?></td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;"><?php echo htmlspecialchars($objet['prix'] ?? ''); ?></td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;"><?php echo htmlspecialchars($objet['date_ajout'] ?? $objet['created_at'] ?? ''); ?></td>
                            <td style="padding:8px;border:1px solid #ddd;vertical-align:middle;">
                                <?php if ($objId): ?>
                                    <a href="/objet/<?php echo urlencode($objId); ?>" style="margin-right:6px;padding:6px 8px;background:#4caf50;color:#fff;border-radius:4px;text-decoration:none;">Fiche</a>
                                    <a href="/objet/<?php echo urlencode($objId); ?>/edit" style="margin-right:6px;padding:6px 8px;background:#ff9800;color:#fff;border-radius:4px;text-decoration:none;">Modifier</a>

                                    <form action="/objet/<?php echo urlencode($objId); ?>/delete" method="post" style="display:inline-block;margin:0;padding:0;" onsubmit="return confirm('Confirmer la suppression de cet objet ?');">
                                        <button type="submit" style="padding:6px 8px;background:#e53935;color:#fff;border:0;border-radius:4px;cursor:pointer;">Supprimer</button>
                                    </form>
                                <?php else: ?>
                                    <em>Id manquant</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>