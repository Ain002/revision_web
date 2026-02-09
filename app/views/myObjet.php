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

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Date d'ajout</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mesObjets as $objet): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($objet['nom']); ?></td>
                            <td><?php echo htmlspecialchars($objet['description']); ?></td>
                            <td><?php echo htmlspecialchars($objet['categorie_id']); ?></td>
                            <td><?php echo htmlspecialchars($objet['prix']); ?></td>
                            <td><?php echo htmlspecialchars($objet['date_ajout']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>