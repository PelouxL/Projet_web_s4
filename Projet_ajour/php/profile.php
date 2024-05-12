<?php 
session_start();
if( empty($_SESSION['email'])){
   header('location: ./connexion.php');
}

include('./fonction.php');
try{  
   include('../connex.inc.php');
   $pdo = connexion('../bdd/database.sqlite');

}catch(PDOException $e){
   echo '<p>Problème PDO </p>';
   echo $e->getMessage();
}

function afficheBio($p){ 
   ?>
   <form action="" method="post">
         <label>Ecrivez votre bio : </label><br>
         <textarea rows="4" cols="50" maxlength="250" name="bioT"><?php echo $p; ?></textarea><br>
         <input type="submit" name="submit_bio" value="enregistrer">
      </form>
<?php 
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_bio']) ){
   $stmt = $pdo->prepare("UPDATE Utilisateurs SET bio = :bio WHERE email = :email");
   $stmt->bindparam(':email',$_SESSION['email']);
   $stmt->bindparam('bio',$_POST['bioT']);
   $stmt->execute();

   $stmt->closeCursor();
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
   <div class="container" style="background-image: url('<?php echo image_pp($_SESSION['email'], 'bannier', $pdo); ?>');">

      <div class="bar"  >
         <ul>
            <li onclick="aff_edition('post')" class="active" name="post">Vos post</li>
            <li onclick="aff_edition('pro')" name="pro">Edition de profile </li>
            <li onclick="aff_edition('bio')" name="bio">Bio</li>
         </ul>
         <div class="profile">
            <img src="<?php echo image_pp($_SESSION['email'], 'pp',$pdo); ?>" alt="Image de profile">
            <p class="name"><?php echo image_pp($_SESSION['email'], 'nom',$pdo); ?></p>
         </div>
      </div>
   </div>

   <div class="panel" id="pro">
   <h2>Ajouter une photo de profil (maximum 2Mo).</h2>
   <p>seuls les format "jpeg", "png" et "webp" sont acceptés.</p>
      <form action="upload.php" method="post" enctype="multipart/form-data">
         <input type="file" name="image" accept="image/jpeg,image/png,image/webp" size="2097152">
         <input type="submit" name="submit_img" value="Ajouter">
      </form>
      <h2>Ajout d'une bannière (maximum 2Mo).</h2>
      <p>seuls les format "jpeg", "png" et "webp" sont acceptés.</p>
      <form action="upload.php" method="post" enctype="multipart/form-data">
         <input type="file" name="image" accept="image/jpeg,image/png,image/webp" size="2097152">
         <input type="submit" name="submit_ban" value="Ajouter">
      </form>
   </div>

   <div class="panel" id="bio">
      <h2>Bio</h2>
      <?php $bio =image_pp($_SESSION['email'], 'bio', $pdo);?></p>
      <?php afficheBio($bio); ?>
   </div>

   <div class="panel.visible" id="post">
   <h2> Vos posts </h2>
   </div>

   <div class="sidebar" >
       <ul>
           <li><a href="../index.php">Acceuille </a></li>
           <li>profile</li>
           <li>notification</li>
           <li>parametre</li>
           <li>Se déconnecter</li>
       </ul>
   </div>


 </body>
 <script src="../js/profile_li.js"></script>
</html>
 <?php $pdo=null ; ?>