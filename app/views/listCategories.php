<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste catégories</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        table {
            border-collapse: collapse;
            width: 70%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            padding: 5px 8px;
            margin: 2px;
            cursor: pointer;
        }

        .form-modif,
        #form-ajout {
            display: none;
        }
    </style>
</head>

<body>

    <div class="top-bar">
        <h2>Liste des catégories</h2>
        <button id="btn-ajouter">+ Ajouter catégorie</button>
    </div>

    <table>

        <!-- ===== FORMULAIRE AJOUT ===== -->
        <tr id="form-ajout">
            <td colspan="2">
                <form method="POST" action="/categories/insert">
                    <input type="text" name="nom" placeholder="Nom catégorie" required>
                    <button type="submit">Enregistrer</button>
                    <button type="button" id="btn-annuler-ajout">Annuler</button>
                </form>
            </td>
        </tr>

        <!-- ===== ENTETE ===== -->
        <tr>
            <th>Nom</th>
            <th>Actions</th>
        </tr>

        <!-- ===== LISTE ===== -->
        <?php foreach ($categories as $cat) { ?>
            <tr>
                <td><?= htmlspecialchars($cat['nom']) ?></td>
                <td>

                    <!-- Modifier -->
                    <button 
                        class="btn-modifier"
                        data-id="<?= $cat['id_categorie'] ?>"
                        data-nom="<?= htmlspecialchars($cat['nom'], ENT_QUOTES) ?>">
                        Modifier
                    </button>

                    <!-- Supprimer -->
                    <a href="/categories/delete/<?= $cat['id_categorie'] ?>" 
                       class="btn-supprimer">
                        <button type="button">Supprimer</button>
                    </a>

                </td>
            </tr>

            <!-- ===== FORMULAIRE MODIFICATION ===== -->
            <tr id="form-row-<?= $cat['id_categorie'] ?>" class="form-modif">
                <td colspan="2">
                    <form method="POST" action="/categories/update">
                        <input type="hidden" name="id" value="<?= $cat['id_categorie'] ?>">
                        <input type="text" name="nom" 
                               id="input-<?= $cat['id_categorie'] ?>" required>

                        <button type="submit">Valider</button>

                        <button type="button"
                                class="btn-annuler"
                                data-id="<?= $cat['id_categorie'] ?>">
                            Annuler
                        </button>
                    </form>
                </td>
            </tr>

        <?php } ?>

    </table>

    <!-- JS externe -->
    <script src="/js/modifier.js"></script>

</body>
</html>
