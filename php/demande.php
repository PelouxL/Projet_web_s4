<?php
    session_start();

    include('../connex.inc.php');
    include('fonction.php');
    $pdo = connexion('../bdd/database.sqlite');
    
    if(isset($_POST['choix'])){
        $id_ami = $_POST['id'];
        ajoute_amis($id_ami, $pdo);
        est_accepte($id_ami, $pdo);
    }
    
    affiche_demande($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>