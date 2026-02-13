<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container center">
        <h1 id="welcomeMessage">Bienvenue</h1>
    </div>

    <script>
        const params = new URLSearchParams(window.location.search);
        const type = params.get('type');
        const message = type === '1' ? 'Bienvenue admin' : (type === '2' ? 'Bienvenue visiteur' : 'Bienvenue');
        document.getElementById('welcomeMessage').textContent = message;
    </script>
</body>
</html>
