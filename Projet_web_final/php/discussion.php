<?php
session_start();

if (!isset($_SESSION['id'])) {
    die('ID de session non défini');
}

include("../connex.inc.php");
$pdo = connexion('../bdd/database.sqlite');

$utilisateur_id1 = $_SESSION['id'];

$utilisateur_id2 = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '');



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contenu'])) {
    $contenu = $_POST['contenu'];
    $date_publication = date('Y-m-d H:i:s');

   
    $stmt = $pdo->prepare("INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (:utilisateur_id1, :utilisateur_id2, :contenu, :date_publication)");
    $stmt->bindParam(':utilisateur_id1',$utilisateur_id1);
    $stmt->bindParam(':utilisateur_id2',$utilisateur_id2);
    $stmt->bindParam(':contenu',$contenu);
    $stmt->bindParam(':date_publication',$date_publication);
    $stmt->execute();
    $stmt->closeCursor();


    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $utilisateur_id2);
    exit();
}

include('fonction.php');
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Discussion</title>
    <link href="../css/style_discussion.css" rel="stylesheet">
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
            <li><a href="deconnexion.php">Se déconnecter</a></li>
        </ul>
    </div>
    <div class="side_gauche">
        <a href="php/demande.php">Demandes</a>
        <?php
        affiche_ami($pdo,'profile_user.php','discussion.php');
        ?>
    </div>
        <div class="messages">
            <div class="mess">
                <?php
                    affiche_message($utilisateur_id1,$utilisateur_id2,$pdo);
                ?>
            </div>
        
        <form class="envoie_message" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <textarea name="contenu" placeholder="Écrivez votre message ici..."></textarea>
            <input type="hidden" name="id" value="<?php echo $utilisateur_id2; ?>">
            <button type="submit">Envoyer</button>
        </form>
        </div>

        <script>
        window.onload = function() {
            var container = document.querySelector('.mess');
            container.scrollTop = container.scrollHeight;
        };
        
    </script>
</body>
</html>

