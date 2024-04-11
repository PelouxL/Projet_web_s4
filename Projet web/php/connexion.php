<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="overlay">
        <div class="connexion">
            <form action="connexion.php" method="post">
                <h2>Connexion</h2>
                <label for="username">Nom d'utilisateur:</label><br>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Mot de passe:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Se connecter">
            </form>
        </div>
        <a href="./inscription.php">Inscription</a>
    </div>
</body>
</html>