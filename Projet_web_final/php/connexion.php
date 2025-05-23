<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link href="../css/style_co.css" rel="stylesheet" media="all" type="text/css"/>
</head>
<body>
<img src="../images/logo.png">
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

                        include('fonction.php');
                        $_SESSION['statut'] = 0;
                        $_SESSION['email'] = $email;
                        $_SESSION['username'] = $nom;
                        $_SESSION['id'] = trouveId($email, $pdo);
                        header('location: ../index.php');
                        exit;    
                        
                    }else{
                        $error_msg= "Email ou mot de passe inccorecte";
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
                       <p class="erreur"><?php echo $error_msg; ?></p>
                    <?php
                }
            ?>
            <a class="ins" href="./inscription.php">Inscription</a>
        </div>
        
    </div>
</body>
</html>