<?php
session_start();

function afficheFormulaire($p){ 
    ?>
    <form method="post">
        <label>Pseudo : <input type="text" name="username" value="<?php echo $p; ?>" required="required" maxlength="20"></label><br>
        <label>Adresse email: <input type="email" name="email" required="required" ></label><br>
        <label>Age : <input type="number" name='age' required="required" min="15" max="130"></label><br>
        <label>Mot de passe :<input type="password" name="mdp" required="required" maxlength="70"></label><br>
        <a href="./connexion.php">Connexion</a>
        <button type="submit" name="submit_ins">Inscription</button>
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
            $ppbase = '../images/cursed_cat.jpg';
            $banbase = '../images/cursed_cat.jpg';
            $password_crp =password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Utilisateurs (id, nom, email, mdp, age, token, pp, bannier, bio, date_inscription ) VALUES (NULL, :nom, :email, :mdp , :age, '', :pp, :ban, '', :date_ins)";
            $stmt= $pdo->prepare($sql);
            $stmt->bindparam(':nom',$nom);
            $stmt->bindparam(':email',$email);
            $stmt->bindparam(':mdp',$password_crp);
            $stmt->bindparam(':age',$age);
            $stmt->bindparam(':date_ins', $dateActuelle);
            $stmt->bindparam(':ban', $banbase);
            $stmt->bindparam(':pp', $ppbase);
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
        <link href="../css/style_ins.css" rel="stylesheet" media="all" type="text/css"/>
    </head>
    <body>
        <div class="container">
            <
            <img src="../images/logo.png">
            <div class="formu">
                <h1>PurplWave</h1>
                <?php
                afficheFormulaire($p);
                ?>
            </div>
        </div>
    </body>
</html>