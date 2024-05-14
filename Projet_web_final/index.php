<?php
session_start();


if( (empty($_SESSION['email']) &&  (empty($_SESSION['username'])) )){
 header('location: ./php/connexion.php');
}

include('php/fonction.php');
include('connex.inc.php');
$pdo = connexion('bdd/database.sqlite');  

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['contenu'])) {
  try{
    $id = $_SESSION['id'];
    $contenu = $_POST['contenu'];
    $genre = $_POST['genre'];


    $stmt = $pdo->prepare('INSERT INTO Publications (utilisateur_id, contenu, genre, date_publication) VALUES (:utilisateur_id, :contenu, :genre, CURRENT_TIMESTAMP)');
    $stmt->bindparam(':utilisateur_id',$id);
    $stmt->bindparam(':contenu',$contenu);
    $stmt->bindparam(':genre',$genre);

    $stmt->execute();
  } catch(PDOException $e) {
    echo '<p>Problème PDO</p>';
    echo $e->getMessage();
  }
    $stmt->closeCursor();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $utilisateur_id2);
    exit();
}

?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"> 
    <title>Projet</title>
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
    <header>
        <form class="recherche_compte" action="php/recherche.php" method="get">
            <input type="text" id="pseudo" name="pseudo" placeholder="Recherche un nom de compte">
        </form>
        <form class="recherche_genre" action="php/recherche.php" method="get">
            <input type="text" id="type" name="genre" placeholder="Recherche un genre">
        </form>
    </header>
    <div class="sidebar">
        <div class="top">
            <img src="../images/logo.png" alt="logo site" class="logo">
        </div>
        <ul>
            <li><img src="<?php echo image_pp($_SESSION['email'],'pp',$pdo); ?>" alt="Image de profile side barre"> <p class="title"><?php echo image_pp($_SESSION['email'],'nom',$pdo); ?></p></li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="php/profile.php">Profil</a></li>
            <li><a href="php/deconnexion.php">Se déconnecter</a></li>
        </ul>
   </div>

    <div class="side_gauche">
        <a href="php/demande.php">Demandes</a>
        <?php
        affiche_ami($pdo,'php/profile_user.php','php/discussion.php');
        ?>
    </div>

    <div class="content">
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="contenu">Votre publication :</label>
            <textarea id="contenu" name="contenu" required></textarea>
            <label for="genre">Genre :</label>
            <input type="text" id="genre" name="genre">
            <input type="submit" value="Publier">
        </form>
    </div>
    <?php
      affiche_flu($pdo);
      $pdo = null;
    ?>
    <footer>
    <a href="mention_legale.html">
    </footer>
</body> 

</html>
