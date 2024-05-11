<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="overlay">
        <div class="connexion">
            <?php 
            // connexion a la base de donnée
            try{
                include('../connex.inc.php');
                $pdo = connexion('../bdd/database.sqlite');    
            }catch(PDOException $e){
                echo '<p>Problème PDO </p>';
                echo $e->getMessage();
            }



            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $email = $_POST['email'];
                $password = $_POST['password']; 
                if($email != "" && $password != ""){
                    $token = bin2hex(random_bytes(32));

                    $req = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
                    $req->bindparam(':email', $email);
                    $req->execute();
                    $exists = $req->fetch();

                    if($exists && (password_verify($password, $exists['mdp']))){
                        $nom = $exists['nom'];
                        // compte existant
                        $tok = $pdo->prepare("UPDATE Utilisateurs SET token = :token WHERE email = :email AND mdp = :mdp");
                        $tok->bindparam(':token', $token);
                        $tok->bindparam(':email', $email);
                        $tok->bindparam(':mdp', $password);
                        $tok->execute();
                        setcookie('token', $token, time() + 3600);
                        setcookie('email', $email, time() + 3600);

                        
                        $_SESSION['statut'] = 0;
                        $_SESSION['email'] = $email;
                        $_SESSION['username'] = $nom;
                        header('location: ../index.php');
                        exit;    
                        
                    }else{
                        $error_msg= "Email ou mdp inccorecte";
                    }
                    $req->closeCursor();
                }
            }


            ?>
            <form action="connexion.php" method="post">
                <h2>Connexion</h2>
                <label for="email">Adresse mail:</label><br>
                <input type="email" id="email" name="email" required><br>
                <label for="password">Mot de passe:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Se connecter" name="sub_co">
            </form>

            <?php
                if($error_msg){
                    ?>
                       <p><?php echo $error_msg; ?></p>
                    <?php
                }
            ?>
        </div>
        <a href="./inscription.php">Inscription</a>
    </div>
</body>
</html>