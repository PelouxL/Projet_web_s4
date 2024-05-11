<?php

try{
    include('../connex.inc.php');
    $pdo = connexion('../bdd/database.sqlite');    
}catch(PDOException $e){
    echo '<p>Problème PDO </p>';
    echo $e->getMessage();
}

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_img']) ){

    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $image = $_FILES["image"];

        $target_dir = "./uploads/";
        $target_file = $target_dir . basename($image["name"]);

        if(move_uploaded_file($image["tmp_name"], $target_file)){

            try{
                $stmt = $pdo->prepare("INSERT INTO Utilisateurs (pp) VALUES (:photo)");
                $stmt = $bindparam(':photo', $target_file);
                $stmt->execute();
                echo "Photo de profile mise à jour";
            } catch(PDOException $e){
                echo "Erreur lors de l'ajout de la photo de profile : ". $e->getMessage();
            }
        }else{
            echo "Erreur lors du teléchargement de l'image.";
        }
    }else{
        echo "Format inccorecte";
    }
}
$pdo = null; 

?>

