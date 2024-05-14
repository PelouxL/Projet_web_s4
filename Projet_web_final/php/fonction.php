<?php
    session_start();

    function trouveId($email, $pdo) {
        $stmt = $pdo->prepare("SELECT id FROM Utilisateurs WHERE email = :email");
        
        $stmt->execute([':email' => $email]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id'];
        } else {
            return null; 
        }
    }

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
  
    function image_pp($email, $choix, $pdo){
      $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
      $stmt->bindparam(':email', $email);
      $stmt->execute();
      $photo = $stmt->fetch();
      $stmt->closeCursor();
      if ($photo) {
          return $photo[$choix];
      } else {
          return "";
      }
    }


    function affiche_flu($pdo){
        $stmt = $pdo->prepare('SELECT * FROM Publications ORDER BY id DESC');
        $stmt->execute();
        $publications = $stmt->fetchAll();
        echo"<div class='publications'>";
        foreach ($publications as $publication) {
        echo "<section class='publication'>";
        if($publication['utilisateur_id'] == $_SESSION['id']){
            echo"<p><a href='php/profile.php'>" . htmlspecialchars($_SESSION['username']) . "</a></p>";
        }else{
            $nom = retNom($publication['utilisateur_id'],$pdo);
            echo "<form action='php/profile_user.php' method='post'>";
              echo "<input type='hidden' name='id' value='" . htmlspecialchars($publication['utilisateur_id']) . "'>";
              echo "<button type='submit' name='nom' value='" . htmlspecialchars($nom) . "'>" . htmlspecialchars($nom) . "</button><br>";
            echo "</form>";
        }
        echo "<p> " . htmlspecialchars($publication['contenu']) . "</p>";
        echo "<p><strong>Genre:</strong> " . htmlspecialchars($publication['genre']) . "</p>";
        echo "<p>" . htmlspecialchars($publication['date_publication']) . "</p>";
        echo "</section>";
        }
        $stmt->closeCursor();
        echo"</div>";
    }



    function affiche_ami($pdo,$link_user,$link_talk){
        $stmt = $pdo->prepare('SELECT * FROM Amis WHERE utilisateur_id = :id');
        $stmt->bindParam(':id',$_SESSION['id']);
        $stmt->execute();
        $amis = $stmt->fetchALL(); 
        echo"<div class='amis'>";
        echo "<p class='nbamis'> Amis </p> ";
        if($amis){
          foreach($amis as $ami){
            $nom = retNom($ami['ami_id'],$pdo);
            echo "<section class='ami'>";
            echo "<form action='" . htmlspecialchars($link_user) . "' method='post'>";
              echo "<input type='hidden' name='id' value='" . htmlspecialchars($ami['ami_id']) . "'>";
              echo "<button type='submit' name='nom' value='" . htmlspecialchars($nom) . "'>" . htmlspecialchars($nom) . "</button><br>";
            echo "</form>";
            echo "<form action='" . htmlspecialchars($link_talk) . "' method='post'>";
              echo "<button type='submit' name='id' value='" . htmlspecialchars($ami['ami_id']) . "'> Discussion </button><br> ";
            echo "</form>";
            echo "</section>";
          }

        }else{
          echo"<p>fait toi donc des amis</p>";
        }
      echo"</div>";
      $stmt->closeCursor();
    }

    function bouton_ami($id_amis, $pdo) {
      $id = $_SESSION['id'];
      $stmt = $pdo->prepare("SELECT * FROM DemandesAmis WHERE (id_demandeur = :id AND id_receveur = :id_amis) OR id_demandeur = :id_amis AND id_receveur = :id");
      $stmt->bindParam(':id',$id);
      $stmt->bindParam(':id_amis',$id_amis);
      $stmt->execute();
      $result = $stmt->fetch();
      if ($result) {
          switch ($result['statut']) {
              case 'en_attente':
                  echo "Demande en attente";
                  break;
              case 'acceptee':
                echo "<form action='profile_user.php' method='post'>";
                  echo "<input type='hidden' name='id' value='" . htmlspecialchars($id_amis) . "'>";
                  echo "<input type='hidden' name='demande' value='2'>";
                  echo "<button type='submit' name='faire_demande'>Retirer amis</button>";
                echo "</form>";
                  break;
              case 'rejetee':
                  echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($id_amis) . "'>";
                    echo "<input type='hidden' name='demande' value='1'>";
                    echo "<button type='submit' name='faire_demande'>Faire une demande d'amis</button>";
                  echo "</form>";
                  break;
          }
      } else {
        echo"$id_amis";
          echo "<form action='profile_user.php' method='post'>";
              echo "<input type='hidden' name='id' value='" . htmlspecialchars($id_amis) . "'>";
              echo "<input type='hidden' name='demande' value='1'>";
              echo "<button type='submit' name='faire_demande'>Faire une demande d'amis</button>";
          echo "</form>";
                }
      }
  
    function demande_amis($id_ami, $pdo) {
      $id =$_SESSION['id'];
      $stmt = $pdo->prepare("SELECT * FROM DemandesAmis WHERE (id_demandeur = :id_demandeur AND id_receveur = :id_ami) OR (id_demandeur = :id_ami AND id_receveur = :id_demandeur)");
      $stmt->bindParam(':id_demandeur',$id);
      $stmt->bindParam(':id_ami',$id_ami);
      $stmt->execute();
      $demandeExistante = $stmt->fetch();

      if (!$demandeExistante) {
          $stmt = $pdo->prepare("INSERT INTO DemandesAmis (id_demandeur, id_receveur, statut, date_demande) VALUES (:id_demandeur, :id_ami, 'en_attente', CURRENT_TIMESTAMP)");
          $stmt->execute(['id_demandeur' => $_SESSION['id'], 'id_ami' => $id_ami]);
          echo "Votre demande d'amis a été envoyée avec succès.";
      } else {
          echo "Une demande d'amis existe déjà.";
      }
    }

    function affiche_demande($pdo){
      $id = $_SESSION['id'];
      $stmt = $pdo->prepare('SELECT * FROM DemandesAmis WHERE id_receveur = :id_rec AND statut = "en_attente"');
      $stmt->bindParam(':id_rec',$id);
      $stmt->execute();
      $demandes = $stmt->fetchAll();
      foreach ($demandes as $demande){
        $nom = retNom($demande['id_demandeur'],$pdo);
        echo "<div class='demande'>";
          echo "<form action='profile_user.php' method='post'>";
          echo "<input type='hidden' name='id' value='" . htmlspecialchars($demande['id_demandeur']) . "'>";
          echo "<button type='submit' name='nom' value='" . htmlspecialchars($nom) . "'>" . htmlspecialchars($nom) . "</button><br>";
        echo "</form>";
        echo "<form action='' method='post'>";
          echo "<input type='hidden' name='id' value='" . htmlspecialchars($demande['id_demandeur']) . "'>";
          echo "<button type='submit' name='choix' value='accepter'>Accepter</button>";
          echo "<button type='submit' name='choix' value='refuser'>Refuser</button>";
        echo "</div>";
      }
      $stmt->closeCursor();
    }

    function ajoute_amis($id_ami, $pdo) {
      $pdo->beginTransaction();
      $id = $_SESSION['id'];
      try {
          echo"$id    $id_ami";
          $stmt = $pdo->prepare("INSERT INTO Amis (utilisateur_id, ami_id) VALUES (:utilisateur_id, :ami_id)");
          $stmt->bindParam(':utilisateur_id',$id);
          $stmt->bindParam(':ami_id',$id_ami);
          $stmt->execute();
  
          $stmt = $pdo->prepare("INSERT INTO Amis (utilisateur_id, ami_id) VALUES (:utilisateur_id, :ami_id)");
          $stmt->bindParam(':utilisateur_id',$id_ami);
          $stmt->bindParam(':ami_id',$id);
          $stmt->execute();
  
          $pdo->commit();
          echo "Les amis ont été ajoutés avec succès.";
      } catch (Exception $e) {
          $pdo->rollBack();
          echo "Erreur lors de l'ajout des amis : " . $e->getMessage();
      }
  }
  
  function est_accepte($id_ami, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM DemandesAmis WHERE id_demandeur = :id_ami AND id_receveur = :id_session AND statut = 'en_attente'");
    $stmt->bindParam(':id_ami', $id_ami);
    $stmt->bindParam(':id_session', $_SESSION['id']);
    $stmt->execute();
    $demande = $stmt->fetch();

    if ($demande) {
        $updateStmt = $pdo->prepare("UPDATE DemandesAmis SET statut = 'acceptee' WHERE id_demande = :id_demande");
        $updateStmt->bindParam(':id_demande', $demande['id_demande'], PDO::PARAM_INT);
        $updateStmt->execute();
        echo "La demande d'amis a été acceptée.";
    } else {
        echo "Aucune demande d'amis en attente trouvée ou la demande n'existe pas.";
    }
}

function retirer_ami($id_ami, $pdo) {
  $id_utilisateur = $_SESSION['id'];

  $stmt = $pdo->prepare("DELETE FROM Amis WHERE (utilisateur_id = :id_utilisateur AND ami_id = :id_ami) OR (utilisateur_id = :id_ami AND ami_id = :id_utilisateur)");
  $stmt->bindParam(':id_utilisateur', $id_utilisateur);
  $stmt->bindParam(':id_ami', $id_ami);

  $stmt->execute();

}

function retirer_demande($id_ami, $pdo) {
  $id_utilisateur = $_SESSION['id'];

  $stmt = $pdo->prepare("DELETE FROM DemandesAmis WHERE (id_demandeur = :id_utilisateur AND id_receveur = :id_ami) OR (id_demandeur = :id_ami AND id_receveur = :id_utilisateur)");

  $stmt->bindParam(':id_utilisateur', $id_utilisateur);
  $stmt->bindParam(':id_ami', $id_ami);

  $stmt->execute();

}

function nbAmi($pdo){
  $sql = "SELECT COUNT(*) FROM Amis WHERE utilisateur_id = :id";
  $res = $pdo->prepare($sql);
  $res->bindparam(':id',$_SESSION['id']);
  $res->execute();
  $count = $res->fetchColumn();

  return $count;
}




function affiche_message($utilisateur_id1,$utilisateur_id2,$pdo){
  $stmt = $pdo->prepare('SELECT * FROM Messages WHERE (utilisateur_id1 = :utilisateur_id1 AND utilisateur_id2 = :utilisateur_id2) OR (utilisateur_id2 = :utilisateur_id1 AND utilisateur_id1 = :utilisateur_id2) ORDER BY id ASC');
  $stmt->bindParam(':utilisateur_id1',$utilisateur_id1);
  $stmt->bindParam(':utilisateur_id2',$utilisateur_id2);
  $stmt->execute();

  $messages = $stmt->fetchAll();

  foreach ($messages as $message) {
      if($message['utilisateur_id1'] == $utilisateur_id1){
          echo "<div class='user1'>";
              echo "<p>" . htmlspecialchars($message['contenu']) . "</p>";
              echo "<p>Envoyé le: " . $message['date_publication'] . "</p>";
          echo "</div>";
      }else{
          echo "<div class='user2'>";
              echo "<p>" . htmlspecialchars($message['contenu']) . "</p>";
              echo "<p>Envoyé le: " . $message['date_publication'] . "</p>";
          echo "</div>"; 
      }
  }
}

function affiche_publi($pdo){
  $stmt = $pdo->prepare('SELECT * FROM Publications WHERE utilisateur_id = :id ORDER BY id DESC');
  $stmt->bindparam(':id', $_SESSION['id']);
  $stmt->execute();
  $publications = $stmt->fetchAll();
  echo"<div class='publications'>";
  foreach ($publications as $publication) {
  echo "<section class='publication'>";
  if($publication['utilisateur_id'] == $_SESSION['id']){
      echo"<p><a href='php/profile.php'>" . htmlspecialchars($_SESSION['username']) . "</a></p>";
  }else{
      $nom = retNom($publication['utilisateur_id'],$pdo);
      echo "<form action='php/profile_user.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($publication['utilisateur_id']) . "'>"; ?>
        <div class='posteur'>
          <img src="<?php echo image_pp($_SESSION['email'], 'pp', $pdo); ?>" alt="image pp sur post">
          <?php echo "<button type='submit' name='nom' value='" . htmlspecialchars($nom) . "'>" . htmlspecialchars($nom) . "</button><br>";
        echo "</div>";
      echo "</form>";
  }
  echo "<div class='champ'>";
  echo "<p> " . htmlspecialchars($publication['contenu']) . "</p>";
  echo "<p><strong>Genre:</strong> " . htmlspecialchars($publication['genre']) . "</p>";
  echo "</div>";
  echo "<p>" . "publier le : " . htmlspecialchars($publication['date_publication']) . "</p>";
  echo "</section>";
  }
  $stmt->closeCursor();
  echo"</div>";
}


?>