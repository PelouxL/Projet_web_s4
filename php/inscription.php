<?php
session_start();



function afficheFormulaire($p){ 
    
    
    ?>
    <form method="post">
        <label>Pseudo <input type="text" name="username" value="<?php echo $p; ?>" required="required"></label><br>
        <label>Adresse email <input type="email" name="email" required="required" ></label><br>
        <label>Age : <input type="number" name='age' required="required" min="15" max="130"></label><br>
        <label>Mot de passe :<input type="password" name="mdp" required="required"></label><br>
        <button type="submit" name="submit_ins">Submit</button>
    </form>


<?php 
}

if(isset($_POST['submit_ins'])){
    $nom = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['mdp'];
    $age = $_POST['age'];
  
    include("../connex.inc.php");
    $pdo = connexion('../bdd/database.sqlite');
    try{
        $verif = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = :email");
        $verif->bindparam(':email',$email);
        $verif->execute();
       
        // Vérifier si l'email existe déjà
        $row = $verif->fetch();
        if ( $row ) {
            echo "L'email existe déjà.";
        } else {
            $verif->closeCursor();
            $dateActuelle = date("Y-m-d");

            $password_crp =password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Utilisateurs (id, nom, email, mdp, age, token, pp, date_inscription ) VALUES (NULL, :nom, :email, :mdp , :age, '', '', :date_ins)";
            $stmt= $pdo->prepare($sql);
            $stmt->bindparam(':nom',$nom);
            $stmt->bindparam(':email',$email);
            $stmt->bindparam(':mdp',$password_crp);
            $stmt->bindparam(':age',$age);
            $stmt->bindparam(':date_ins', $dateActuelle);
            $stmt->execute();

            include('fonction.php');
            $_SESSION['statut'] = 0;
            $_SESSION['username'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = trouveId($email, $pdo);
            header('location: ../index.php');
            exit;

        }
    }catch(PDOException $e){
        echo '<p>Problème PDO </p>';
        echo $e->getMessage();
    }
    $stmt->closeCursor();
    $pdo = null;
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>Document</title>
    </head>
    <body>
        <?php
        afficheFormulaire($p);
         ?>
    </body>
</html>