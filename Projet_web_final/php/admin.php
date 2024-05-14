<?php
session_start();

$id = $_SESSION['id'];


if( $id != 1){
    header('location: ../index.php');
    exit;   
}

include("../connex.inc.php");
$pdo = connexion('../bdd/database.sqlite');
include("fonction.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        suppr_user($_POST['id'], $pdo);
    } else {
        echo "L'ID n'est pas défini dans le formulaire soumis.";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      table, td, th {
        border: 1px solid black;
      }
    </style>
</head>
<body>
    
<?php
    afficher_user($pdo);
?>


</body>
</html>