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
         <textarea rows="4" cols="50" maxlength="500" name="bioT"><?php echo $p; ?></textarea><br>
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
   <div class="sidebar" >
      <div class="top">
         <div class="logo"> 
            <img src="../images/logo.png" alt="image du Logo">
            <span>PurplWave</span>
         </div>
      </div>
      <div class="user"> 
         <img src="<?php echo image_pp($_SESSION['email'],'pp',$pdo); ?>" alt="Image de profile side barre">
         <span class="pseudo"><?php echo image_pp($_SESSION['email'],'nom',$pdo); ?></span>
     </div>
      <ul>
         <li><a href="../index.php">Acceuille </a></li>
         <li><a href="./profile.php">Profile</a></li>
         <li><a href="./profile.php">Message</a></li>
         <li><a href="./profile.php">notification</a></li>
         <li><a href="./profile.php">Se déconnecter</a></li>
      </ul>
   </div>

   <div class="container" style="background-image: url('<?php echo image_pp($_SESSION['email'], 'bannier', $pdo); ?>');">
      <div class="profile">
         <img src="<?php echo image_pp($_SESSION['email'], 'pp',$pdo); ?>" alt="Image de profile">
      </div>
      <div class="info">
         <p><?php echo image_pp($_SESSION['email'], 'nom',$pdo); ?></p>
         <p class="bio"><em><?php  echo image_pp($_SESSION['email'], 'bio',$pdo); ?></em></p>
         <p> Membres depuis le : <?php echo image_pp($_SESSION['email'], 'date_inscription',$pdo); ?> </p>
      </div>
      <div class="bar" >
         <ul>
            <li onclick="aff_edition('post')" class="active" name="post">Vos post</li>
            <li onclick="aff_edition('pro')" name="pro">Edition de profile </li>
            <li onclick="aff_edition('bio')" name="bio">Bio</li>
         </ul>   
      </div>
   </div>

   <div class="ListeAmis">
      <div class="titre"> 
         <h2>Liste d'ami(e)s</h2>
         <p><?php echo "Nombre d'ami(e)s actuel : " . nbAmi($pdo) . ".";?></p>
      </div>
         <?php affiche_ami($pdo); ?>
      
   </div>


   
   <div class="presentation">
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
      <div class="panel" id="post">
         <h2> Vos posts </h2>
      </div>
   </div>



 <script src="../js/profile_li.js"></script>
 <script>
        document.addEventListener("DOMContentLoaded", function() {
            saut_ligne('.info p.bio');
        });
    </script>
 </body>
 
</html>
 <?php $pdo=null ; ?>