<?php
    include("../connex.inc.php");
    $pdo = connexion('../bdd/database.sqlite');

    $pseudo = $_GET['pseudo'];

    $stmt = $pdo->prepare("SELECT id,nom,token FROM Utilisateurs WHERE nom = :pseudo");
    $stmt->bindparam(':pseudo',$pseudo);
    $stmt->execute();
    $existe = $stmt->fetchALL();

    if ($existe) {
        foreach ($existe as $utilisateur) {
            echo "<form action='profile_user.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . htmlspecialchars($utilisateur['id']) . "'>";
            echo "<button type='submit' name='nom' value='" . htmlspecialchars($utilisateur['nom']) . "'>" . htmlspecialchars($utilisateur['nom']) . "</button><br>";
            echo "</form>";
        }
    } else {
        echo "Ce compte n'existe pas.";
    }
?>

