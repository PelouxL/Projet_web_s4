<?php
    include("../connex.inc.php");
    $pdo = connexion('../bdd/database.sqlite');
    include("fonction.php");
    


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/style_recherche.css" rel="stylesheet">
</head>
<body>
    <?php
    if(isset($_GET['pseudo'])){
        $pseudo = $_GET['pseudo'];
        recherche_compte($pseudo,$pdo);
    }elseif(isset($_GET['genre'])){
        $genre = $_GET['genre'];
        affiche_pub_genre($genre,$pdo);
    }
    ?>
</body>
</html>