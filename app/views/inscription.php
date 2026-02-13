<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"], select { 
            width: 100%; padding: 8px; box-sizing: border-box; 
        }
        input[type="submit"] { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #45a049; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Inscription</h2>
    <form id="registerForm">
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" required>
        </div>

        <div class="form-group">
            <label for="pwd">Mot de passe:</label>
            <input type="password" id="pwd" name="pwd" required minlength="6">
        </div>

        <div class="form-group">
            <label for="idtype">Type d'utilisateur:</label>
            <select id="idtype" name="idtype" required>
                <option value="">-- Choisir --</option>
                <option value="1">Admin</option>
                <option value="2">Visiteur</option>
            </select>
        </div>

        <input type="submit" value="S'inscrire">
    </form>

    <p>Déjà un compte? <a href="/login">Se connecter</a></p>
    
    <div id="message"></div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const messageDiv = document.getElementById('message');
            messageDiv.textContent = '';

            const nom = document.getElementById('nom').value;
            const mail = document.getElementById('mail').value;
            const pwd = document.getElementById('pwd').value;
            const idtype = Number(document.getElementById('idtype').value);

            if (!idtype || ![1, 2].includes(idtype)) {
                messageDiv.className = 'error';
                messageDiv.textContent = 'Veuillez sélectionner un type d\'utilisateur valide';
                return;
            }

            fetch('/users/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nom, mail, pwd, idtype })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.className = 'success';
                    messageDiv.textContent = 'Inscription réussie! Redirection...';
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                } else {
                    messageDiv.className = 'error';
                    messageDiv.textContent = data.message || 'Erreur lors de l\'inscription';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.className = 'error';
                messageDiv.textContent = 'Erreur de connexion au serveur';
            });
        });
    </script>
</body>
</html>