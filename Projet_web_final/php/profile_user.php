<?php
session_start();
include("./fonction.php");
    include("../connex.inc.php");
    $pdo = connexion('../bdd/database.sqlite');


    if(isset($_POST['demande'])){
      $demande = $_POST['demande'];
      if($demande == 1){
      demande_amis($_POST['id'],$pdo);       
      header('Location: ' . htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($_POST['id']));
      }
      else {
          retirer_ami($_POST['id'], $pdo);
          retirer_demande($_POST['id'], $pdo);

      }
      header('Location: ' . htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . urlencode($_POST['id']));
      exit;
  }

  $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);


    if (isset($id)) {
    
        // Préparez et exécutez la requête pour obtenir les informations de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $utilisateur = $stmt->fetch();
    
        // Vérifiez si un utilisateur a été trouvé
        if ($utilisateur) {
            
            ?>
            
            <html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <title> Profile</title>
                <link href="../css/style_user.css" rel="stylesheet" media="all" type="text/css"/>
            </head>
            <body>
               <div class="sidebar">
                     <div class="top">      
                           <img src="../images/logo.png" alt="logo site" class="logo">   
                     </div>
                     <ul>
                     <li><img src="<?php echo image_pp($_SESSION['email'],'pp',$pdo); ?>" alt="Image de profile side barre"><p class="title"><?php echo image_pp($_SESSION['email'],'nom',$pdo); ?></p></li>
                           <li><a href="../index.php">Accueil</a></li>
                           <li><a href="profile.php">Profil</a></li>
                           <li><a href="deconnexion.php">Se déconnecter</a></li>
                     </ul>
               </div>


               <div class="container" style="background-image: url('<?php echo image_pp($utilisateur['email'], 'bannier', $pdo); ?>');">
               
                  <div class="profile">
                     <img src="<?php echo image_pp($utilisateur['email'], 'pp',$pdo); ?>" alt="Image de profile">
                  </div>
                  <div class="info">
                     <p><?php echo image_pp($utilisateur['email'], 'nom',$pdo); ?></p>
                     <?php bouton_ami($utilisateur['id'],$pdo); ?>
                     <p class="bio"><em><?php  echo image_pp($utilisateur['email'], 'bio',$pdo); ?></em></p>
                     <p> Membres depuis le : <?php echo image_pp($utilisateur['email'], 'date_inscription',$pdo); ?> </p>
                  </div>
                  <div class="bar" >
                  </div>
               </div>

               <div class="side_gauche">
                  <div class="titre">
                     <a href="php/demande.php">Demandes</a>
                     <p><?php echo "Nombre d'ami(e)s actuel : " . nbAmi($pdo) . ".";?></p>
                  </div>
                     <?php affiche_ami($pdo,'profile_user.php','discussion.php'); 
                      ?>
               </div>
         
               <div class="presentation">
                  <div class="panel" id="post">
                     <h2>Posts </h2>
                     <?php affiche_publi($pdo, $utilisateur['id']); ?>
                  </div>
               </div>
               <script src="../js/profile_li.js"></script>
               <script>
                  document.addEventListener("DOMContentLoaded", function() {
                  saut_ligne('.info p.bio');
                });
               </script>
        </body>
        <?php
        } else {
            echo "Aucun utilisateur trouvé avec cet ID.";
        }
    } else {
        echo "Aucun ID fourni.";
    }
    
?>
</html>

