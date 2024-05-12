<?php
    function trouveId($email, $pdo) {
        // Préparation de la requête pour obtenir l'ID basé sur l'email
        $stmt = $pdo->prepare("SELECT id FROM Utilisateurs WHERE email = :email");
        
        // Exécution de la requête avec le paramètre email
        $stmt->execute([':email' => $email]);
        
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérification si un résultat a été trouvé
        if ($result) {
            return $result['id'];
        } else {
            return null; // Aucun utilisateur trouvé avec cet email
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
  
  
    function affiche_flu($publications,$pdo){
        foreach ($publications as $publication) {
        echo "<section>";
        echo "<h2>Publication ID: " . htmlspecialchars($publication['id']) . "</h2>";
        if($publication['utilisateur_id'] == $_SESSION['id']){
            echo"<p><a href='php/profile.php'>" . htmlspecialchars($_SESSION['username']) . "</a></p>";
        }else{
            $nom = retNom($publication['utilisateur_id'],$pdo);
            echo "<form action='php/profile_user.php' method='post'>";
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
    
    }

    function affiche_ami($amis,$pdo,$link){
        echo"<div>";
        foreach ($amis as $ami){

        }
        echo"</div>";
    }
?>