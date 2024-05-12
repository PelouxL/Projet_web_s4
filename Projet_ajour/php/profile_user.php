<?php
    include("../connex.inc.php");
    $pdo = connexion('../bdd/database.sqlite');


    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    
        // Préparez et exécutez la requête pour obtenir les informations de l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $utilisateur = $stmt->fetch();
    
        // Vérifiez si un utilisateur a été trouvé
        if ($utilisateur) {
            echo "<h1>Profil de l'utilisateur</h1>";
            echo "Nom: " . htmlspecialchars($utilisateur['nom']) . "<br>";
            echo "Email: " . htmlspecialchars($utilisateur['email']) . "<br>";
            echo "Date d'inscription: " . htmlspecialchars($utilisateur['date_inscription']) . "<br>";
            // Ajoutez d'autres informations que vous souhaitez afficher
        } else {
            echo "Aucun utilisateur trouvé avec cet ID.";
        }
    } else {
        echo "Aucun ID fourni.";
    }
?>