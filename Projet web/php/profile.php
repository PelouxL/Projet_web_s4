<?php 
session_start();
if( empty($_SESSION['email'])){
   header('location: ./connexion.php');
}

function image_pp($email){
   try{  
      include('../connex.inc.php');
      $pdo = connexion('../bdd/database.sqlite');

   }catch(PDOException $e){
      echo '<p>Problème PDO </p>';
      echo $e->getMessage();
   }
   $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
   $stmt->bindparam(':email', $_SESSION['email']);
   $stmt->execute();
   $photo = $stmt->fetch();

   $pdo = null;
   return $photo['pp'];
}


?>

<html>
   <html lang="fr">
 <head>
    <meta charset="utf-8">
    <title> Profile</title>
    <link href="../css/style_profile.css" rel="stylesheet" media="all" type="text/css"/>
 </head>
 <body>
   <div class="container">


      <h2>Ajouter une photo de profil</h2>
      <form action="upload.php" method="post" enctype="multipart/form-data">
         <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
         <input type="submit" name="submit_img" value="Ajouter">
      </form>


      <h2>Ajout d'une bannière</h2>
      <form action="upload.php" method="post" enctype="multipart/form-data">
         <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
         <input type="submit" name="submit_ban" value="Ajouter">
      </form>


      <div class="bar"  >
         <ul>
            <li class="active">Vos post</li>
            <li>Bio</li>
            <li>Grade</li>
            <li>Bio</li>
            <li><a class="nonunderline" href="./edition_pro.php"> Edition de profile </a></li>
         </ul>
         <div class="profile">
            <img src="<?php echo image_pp($_SESSION['email']); ?>" alt="Image de profile">
            <p class="name">Profil</p>
         </div>
      </div>
   </div>

   <div class="sidebar" >
       <ul>
           <li>Acceuille</li>
           <li>profile</li>
           <li>notification</li>
           <li>parametre</li>
           <li>Se déconnecter</li>
       </ul>
           
 
 </body>