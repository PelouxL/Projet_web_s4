<?php
session_start();
echo"$_SESSION[username]";
if( (empty($_SESSION['email']) &&  (empty($_SESSION['username'])) )){
 header('location: ./php/connexion.php');
}


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
<html lang="fr">
 <head>
    <meta charset="utf-8"> 
    <Title> Projet</Title>
    <link href="../css/main.css" rel="stylesheet">
 </head>
 <body>
    <div class="Sidebar"> 
      <header><img src="../images/oljl.png" alt="image du Logo">Logo</header>
      <ul>
        <li>Accueuille </li>
        <li>Abonnement </li>
        <li>Notification</li>
        <li><a href="php/profile.php">Profile</a></li>
        <li>Poste
        <li>Paramètres </li>
      </ul>
  </div>
  <div class="File_actualite">
    <button type="button">File d'actualuté</button>
  </div>
  <div class="File_video">
    <button type="button">File vidéo</button>
  </div>
  <div class="Pourtoi">
  <form action="php/recherche.php" method="get">
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo">
  </form>

  <a href="php/demande.php"> demandes </a>

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="contenu">Votre publication:</label>
    <textarea id="contenu" name="contenu" required></textarea>
    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre">
    <input type="submit" value="Publier">
  </form>


  <?php
      include('php/fonction.php');
      affiche_flu($pdo);
      affiche_ami($pdo);
      $pdo = null;
?>

  </body> 
</html>