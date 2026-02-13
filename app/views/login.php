<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; }
        input[type="submit"] { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        input[type="submit"]:hover { background: #45a049; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Connexion</h2>
    <form id="loginForm">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <input type="submit" value="Se connecter">
    </form>

    <p>Pas de compte? <a href="/inscription">S'inscrire</a></p>
    
    <div id="message"></div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = '';
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            fetch('/users/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ mail: email, pwd: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.user) {
                    messageDiv.className = 'success';
                    messageDiv.textContent = 'Connexion réussie!';
                    
                    const userType = data.user.idtype;
                    const userName = data.user.nom;
                    
                    setTimeout(() => {
                        if (userType == 1) {
                            alert('Bienvenue Admin ' + userName);
                            window.location.href = '/hello?type=admin';
                        } else if (userType == 2) {
                            alert('Bienvenue Visiteur ' + userName);
                            window.location.href = '/hello?type=visiteur';
                        }
                    }, 500);
                } else {
                    messageDiv.className = 'error';
                    messageDiv.textContent = data.message || 'Erreur de connexion';
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