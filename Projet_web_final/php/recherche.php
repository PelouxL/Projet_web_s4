<?php
    session_start();

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
    <div class="sidebar">
        <div class="top">      
            <img src="../images/logo.png" alt="logo site" class="logo">   
        </div>
        <ul>
            <li><img src="<?php echo image_pp($_SESSION['email'],'pp',$pdo); ?>" alt="Image de profile side barre"> <p><?php echo image_pp($_SESSION['email'],'nom',$pdo); ?></p></li>
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="./profile.php">Profil</a></li>
            <li><a href="./deconnexion.php">Se déconnecter</a></li>
        </ul>
   </div>
    <?php
    ?> <h1>Résultat de la recherche :</h1> <?php
    if(isset($_GET['pseudo'])){
        $pseudo = $_GET['pseudo'];
        recherche_compte($pseudo,$pdo);
    }elseif(isset($_GET['genre'])){
        $genre = $_GET['genre'];
        affiche_pub_genre($genre,$pdo);
    }
    ?>
    <div class="side_gauche">
      <div class="titre">
        <a href="demande.php">Demandes</a>
        <p><?php echo "Nombre d'ami(e)s actuel : " . nbAmi($pdo) . ".";?></p>
      </div>
        <?php affiche_ami($pdo,'profile_user.php','discussion.php'); ?>
   </div>
</body>
</html>