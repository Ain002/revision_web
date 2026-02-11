<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form id="registerForm">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="mail">Email:</label>
        <input type="email" id="mail" name="mail" required><br><br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" required><br><br>

        <label for="idtype">Type utilisateur:</label>
        <input type="number" id="idtype" name="idtype" min="1" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <script nonce="<?php echo Flight::get('csp_nonce'); ?>">
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const nom = document.getElementById('nom').value;
            const mail = document.getElementById('mail').value;
            const pwd = document.getElementById('pwd').value;
            const idtype = Number(document.getElementById('idtype').value);

            fetch('/users/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nom, mail, pwd, idtype })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message && data.message.toLowerCase().includes('success')) {
                    alert('Inscription réussie');
                    window.location.href = '/';
                } else {
                    alert(data.message || 'Erreur lors de l\'inscription');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>