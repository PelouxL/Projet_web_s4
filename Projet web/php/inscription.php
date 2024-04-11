<?php
function afficheFormulaire($p){ ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Pseudo <input type="text" name="username" value="<?php echo $p; ?>" required="required"></label><br>
        <label>Mot de passe :<input type="password" name="mdp" required="required"></label><br>
        <button type="submit">Submit</button>
    </form>
<?php 
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