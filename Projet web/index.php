<?php
session_start();
echo $_SESSION['username'];

function retNom($id, $pdo) {

  $stmt = $pdo->prepare("SELECT nom FROM Utilisateurs WHERE id = :id");
  
 
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  

  $stmt->execute();
  
 
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  
  if ($result) {
      return $result['nom'];
  } else {
      return null; 
  }
}



?>
<html lang="fr">
 <head>
    <meta charset="utf-8"> 
    <Title> Projet</Title>
    <link href="../css/main.css" rel="stylesheet">
 </head>
 <body>
     <?php
     if( (empty($_SESSION['email']) &&  (empty($_SESSION['username'])) )){
      header('location: ./php/connexion.php');
     }
     ?>


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
  <form action="index.php" method="post">
    <label for="contenu">Votre publication:</label>
    <textarea id="contenu" name="contenu" required></textarea>
    <label for="genre">Genre:</label>
     <input type="text" name="genre">
    <input type="submit" value="Publier">
  </form>

  <?php
      include('connex.inc.php');
      $pdo = connexion('bdd/database.sqlite');  

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['contenu'])) {

      try{
        $id = $_SESSION['id'];
        $contenu = $_POST['contenu'];
        $genre = $_POST['genre'];
        
        
        echo "<section>";  
        echo "<h2>Publication</h2>";
        echo "<p><a href='php/profile.php'>" . htmlspecialchars($_SESSION['username']) . "</a></p>";
        echo "<p><strong>Contenu:</strong> " . htmlspecialchars($_POST['contenu']) . "</p>";
        echo "<p><strong>Genre:</strong> " . htmlspecialchars($_POST['genre']) . "</p>";     
        echo "</section>";

        $stmt = $pdo->prepare('SELECT * FROM Publications ORDER BY id DESC');

        $stmt->execute();
    
        $publications = $stmt->fetchAll();
    
        foreach ($publications as $publication) {
            echo "<section>";
            echo "<h2>Publication ID: " . htmlspecialchars($publication['id']) . "</h2>";
            if($publication['utilisateur_id'] == $_SESSION['id']){
              echo"<p><a href='php/profile.php'>" . htmlspecialchars($_SESSION['username']) . "</a></p>";
            }else{
              $nom = retNom($publication['utilisateur_id'],$pdo);
              echo "<form action='profile_user.php' method='post'>";
              echo "<input type='hidden' name='id' value='" . htmlspecialchars($publication['utilisateur_id']) . "'>";
              echo "<button type='submit' name='nom' value='" . htmlspecialchars($nom) . "'>" . htmlspecialchars($nom) . "</button><br>";
              echo "</form>";
            }
            echo "<p><strong>Utilisateur ID:</strong> " . htmlspecialchars($publication['utilisateur_id']) . "</p>";
            echo "<p><strong>Contenu:</strong> " . htmlspecialchars($publication['contenu']) . "</p>";
            echo "<p><strong>Genre:</strong> " . htmlspecialchars($publication['genre']) . "</p>";
            echo "<p><strong>Date de publication:</strong> " . htmlspecialchars($publication['date_publication']) . "</p>";
            echo "</section>";
        }
        $stmt->closeCursor();

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
      $pdo = null;

    }

   
?>




  </body> 
</html>