<?php
    session_start();

    include('../connex.inc.php');
    include('fonction.php');
    $pdo = connexion('../bdd/database.sqlite');
    
    if(isset($_POST['choix'])){
        $id_ami = $_POST['id'];
        ajoute_amis($id_ami, $pdo);
        est_accepte($id_ami, $pdo);
    }
    

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande</title>
    <link href="../css/style_demande.css" rel="stylesheet">

</head>
<body>
<header>
        <form class="recherche_compte" action="php/recherche.php" method="get">
            <input type="text" id="pseudo" name="pseudo" placeholder="Recherche un nom de compte">
        </form>
    </header>
    <div class="sidebar">
        <div class="top">      
            <img src="../images/logo.png" alt="logo site" class="logo">   
        </div>
        <ul>
            <li><img src="<?php echo image_pp($_SESSION['email'],'pp',$pdo); ?>" alt="Image de profile side barre"> <p><?php echo image_pp($_SESSION['email'],'nom',$pdo); ?></p></li>
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="profile.php">Profil</a></li>
            <li><a href="notifications.php">Notifications</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        </ul>
    </div>
    <div class="side_gauche">
        <?php
        affiche_ami($pdo,'profile_user.php','discussion.php');
        ?>
    </div>
    <div class="content">
        <?php
        affiche_demande($pdo);
        $pdo = null;
        ?>
    </div>

</body>
</html>