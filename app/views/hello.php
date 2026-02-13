<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container center">
        <h1 id="welcomeMessage">Bienvenue</h1>
    <title>Accueil</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .admin { color: #2196F3; }
        .visiteur { color: #4CAF50; }
        .logout-btn { 
            background: #f44336; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            cursor: pointer;
            border-radius: 4px;
        }
        .logout-btn:hover { background: #d32f2f; }
        .info-box { 
            background: #f5f5f5; 
            padding: 20px; 
            margin-top: 20px; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 id="welcomeMessage">Bienvenue</h1>
        <button class="logout-btn" onclick="logout()">Déconnexion</button>
    </div>
    
    <div class="info-box" id="infoBox">
        <p>Chargement des informations...</p>
    </div>

    <script>
        const params = new URLSearchParams(window.location.search);
        const type = params.get('type');
        
        const welcomeEl = document.getElementById('welcomeMessage');
        const infoBox = document.getElementById('infoBox');
        
        if (type === 'admin' || type === '1') {
            welcomeEl.className = 'admin';
            welcomeEl.textContent = '👨‍💼 Bienvenue Administrateur';
            infoBox.innerHTML = `
                <h3>Accès Administrateur</h3>
                <p>Vous avez accès à toutes les fonctionnalités du système :</p>
                <ul>
                    <li>Gestion des utilisateurs</li>
                    <li>Configuration du système</li>
                    <li>Visualisation des statistiques</li>
                    <li>Gestion du contenu</li>
                </ul>
            `;
        } else if (type === 'visiteur' || type === '2') {
            welcomeEl.className = 'visiteur';
            welcomeEl.textContent = '👤 Bienvenue Visiteur';
            infoBox.innerHTML = `
                <h3>Accès Visiteur</h3>
                <p>Vous pouvez consulter les ressources disponibles :</p>
                <ul>
                    <li>Consultation des documents</li>
                    <li>Visualisation du contenu public</li>
                    <li>Participation aux discussions</li>
                </ul>
            `;
        } else {
            welcomeEl.textContent = 'Bienvenue';
            infoBox.innerHTML = '<p>Veuillez vous connecter pour accéder au système.</p>';
        }
        
        function logout() {
            fetch('/users/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Déconnexion réussie');
                    window.location.href = '/login';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = '/login';
            });
        }
    </script>
</body>
</html>
