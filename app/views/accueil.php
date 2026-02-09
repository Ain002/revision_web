<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <header>
        <h1>Bienvenue sur notre site de gestion d'objets</h1>
        <p>Utilisez le menu pour naviguer dans les différentes sections.</p>
        <nav>
            <ul>
                <li><a href="/mesObjets">Mes Objets</a></li>
                <li><a href="/ajouterObjet">Ajouter un Objet</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Les objets</h2>
            <div class="objets-list">
                <?php if (isset($objet) && !empty($objet)): ?>
                    <ul>
                        <?php foreach ($objet as $item): ?>
                            <li>
                                <a href="/objet/<?php echo htmlspecialchars($item['id']); ?>">
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