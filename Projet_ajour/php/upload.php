<?php
session_start();
if(empty($_SESSION['email'])){
    header('location: ./connexion.php');
}
    try{
        include('../connex.inc.php');
        $pdo = connexion('../bdd/database.sqlite');    
    }catch(PDOException $e){
        echo '<p>Problème PDO </p>';
        echo $e->getMessage();
    }
    // pour la pp
    if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_img']) ){

        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $image = $_FILES["image"];

            $target_dir = "./uploads/";
            $target_file = $target_dir . basename($image["name"]);

            if(move_uploaded_file($image["tmp_name"], $target_file)){
                try{
                    $stmt = $pdo->prepare("UPDATE Utilisateurs SET pp = :pp WHERE email = :email");
                    $stmt->bindparam(':email', $_SESSION['email']);
                    $stmt->bindparam(':pp',$target_file);
                    $stmt->execute();
                    echo "Photo mise à jour";
                } catch(PDOException $e){
                    echo "Erreur lors de l'ajout de la photo : ". $e->getMessage();
                }
            }else{
                echo "Erreur lors du teléchargement de l'image.";
            }
        }else{
            echo "Format inccorecte";
        }
        header('location: ./profile.php');
        // Pour la bannière 


    }elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_ban']) ){
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $image = $_FILES["image"];

            $target_dir = "./uploads/";
            $target_file = $target_dir . basename($image["name"]);

            if(move_uploaded_file($image["tmp_name"], $target_file)){
                try{
                    $stmt = $pdo->prepare("UPDATE Utilisateurs SET bannier = :ban WHERE email = :email");
                    $stmt->bindparam(':email', $_SESSION['email']);
                    $stmt->bindparam(':ban',$target_file);
                    $stmt->execute();
                    echo "Photo mise à jour";
                } catch(PDOException $e){
                    echo "Erreur lors de l'ajout de la photo : ". $e->getMessage();
                }
            }else{
                echo "Erreur lors du teléchargement de l'image.";
            }
        }else{
            echo "Format inccorecte";
        }
        header('location: ./profile.php');
    }
    $stmt->closeCursor();
    $pdo = null; 
?>


