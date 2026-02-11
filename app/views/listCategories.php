<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste catégories</title>
</head>
<body>
<table>
            <tr>
                <th>Nom</th>
            </tr>

            <?php foreach($categories as $cat) { ?>
                <tr>
                    <td><?= $cat['nom'] ?></td>
                </tr>
            <?php } ?>
        </table>
</body>
</html>