<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur notre site de gestion d'objets</h1>
        <p>Utilisez le menu pour naviguer dans les différentes sections.</p>
        <nav>
            <ul>
                <li><a href="/objet/mesObjets">Mes Objets</a></li>
                <li><a href="/objet/ajouterObjet">Ajouter un Objet</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Les objets</h2>
            <div class="objets-list">
                <?php if (isset($objet) && !empty($objet)): ?>
                    <ul>
                        <?php foreach ($objet as $item):
                            $imgUrl = null;
                            if (!empty($images) && is_array($images)) {
                                foreach ($images as $img) {
                                    if ((string)($img['objet_id'] ?? '') === (string)($item['id'] ?? '')) {
                                        $name = $img['nom'] ?? $img['url'] ?? null;
                                        if ($name) {
                                            $imgUrl = (strpos($name, 'http') === 0 || strpos($name, '/') === 0) ? $name : '/uploads/' . ltrim($name, '/');
                                            break;
                                        }
                                    }
                                }
                            }
                        ?>
                            <li>
                                <a href="/objet/<?php echo htmlspecialchars($item['id']); ?>">
                                    <?php if ($imgUrl): ?>
                                        <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($item['nom']); ?>" style="max-width:120px;vertical-align:middle;margin-right:8px;">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($item['nom']); ?>
                                    - <?php echo htmlspecialchars($item['prix']); ?> Ariary    
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun objet trouvé.</p>
                <?php endif; ?>
                
            </div>
        </section>
    </main>
</body>
</html>