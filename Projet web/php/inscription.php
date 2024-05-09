<?php
function afficheFormulaire($p){ ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Pseudo <input type="text" name="username" value="<?php echo $p; ?>" required="required"></label><br>
        <label>Adresse email <input type="text" name="email" required="required" value="<?php echo $p ?>"</label><br>
        <label>Mot de passe :<input type="password" name="mdp" required="required"></label><br>
        <button type="submit" name="submit_ins">Submit</button>
    </form>
<?php 
}

if(isset($_POST['submit_ins'])){
    $nom = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['mdp'];

    
    include('../connex.inc.php');
    $pdo = connexion('../database.sqlite');
    try{
        $sql = "INSERT INTO Utilisateurs (id, nom, mdp, email, date_inscription ) VALUES (NULL, :name, :mdp , :email, NULL)";
        $stmt= $pdo->prepare($sql);
        $stmt->bindparam(':nom',$nom);
        $stmt->bindparam(':email',$email);
        $stmt->bindparam(':password',$password);
        
        $stmt->execute($data);
    } catch(PDOException $e){
        echo '<p>Problème PDO </p>';
        echo $e->getMessage();
    }
    $stmt->closeCursor();
    $pdo = null;
}

session_start();
$_SESSION['pseudo'] = "***";
$_SESSION['statut'] = -1;
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Document</title>
    </head>
    <body>
        <?php  
        if($_SESSION['statut'] === 1 || $_SESSION['statut'] === 0){
            header('location: http://localhost:8000');       
        }else{
            if(empty($_POST)){
                $p = NULL;
            }else{
                $p = $_POST['username'];
            }
            afficheFormulaire($p);
        }
        ?>
    </body>
</html>