<?php
    session_start();
    include("../connex.inc.php");
    include("fonction.php");
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
    


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if ($id) {                        
            $stmt = $pdo->prepare("SELECT * FROM Utilisateurs WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $utilisateur = $stmt->fetch();
        
            if ($utilisateur) {
                echo "<h1>Profil de l'utilisateur</h1>";
                echo "Nom: " . htmlspecialchars($utilisateur['nom']) . "<br>";
                echo "Email: " . htmlspecialchars($utilisateur['email']) . "<br>";
                echo "Date d'inscription: " . htmlspecialchars($utilisateur['date_inscription']) . "<br>";
            } else {
                echo "Aucun utilisateur trouvé avec cet ID.";
            }
        } else {
            echo "Aucun ID fourni.";
        }
        $stmt->closeCursor();
        bouton_ami($utilisateur['id'],$pdo);

    ?>
</body>
</html>