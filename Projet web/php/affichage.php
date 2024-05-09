
<?php
function aff(){
    include('../connex.inc.php');
    $pdo = connexion('../bdd/database.sqlite');

    $req = $pdo->prepare("SELECT * FROM Utilisateurs ");

    $req->execute();
    $users = $req->fetchAll(PDO::FETCH_ASSOC);
    echo '<p>'.count($users).' étudiant⋅es correspondent à votre requête :</p>';
    echo '<ul>';
    foreach($users as $user) {
        echo '<li>'.$user['id'].' '.$user['nom'].' '.$user['email'].'</li>';
    }     
    echo '</ul>';
    $req->closeCursor();
    $pdo = null;
}  

?>