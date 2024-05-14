<?php
session_start();

if (!isset($_SESSION['id'])) {
    die('ID de session non défini');
}

include("../connex.inc.php");
$pdo = connexion('../bdd/database.sqlite');

$utilisateur_id1 = $_SESSION['id'];

$utilisateur_id2 = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '');



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contenu'])) {
    $contenu = $_POST['contenu'];
    $date_publication = date('Y-m-d H:i:s');

   
    $stmt = $pdo->prepare("INSERT INTO Messages (utilisateur_id1, utilisateur_id2, contenu, date_publication) VALUES (:utilisateur_id1, :utilisateur_id2, :contenu, :date_publication)");
    $stmt->bindParam(':utilisateur_id1',$utilisateur_id1);
    $stmt->bindParam(':utilisateur_id2',$utilisateur_id2);
    $stmt->bindParam(':contenu',$contenu);
    $stmt->bindParam(':date_publication',$date_publication);
    $stmt->execute();
    $stmt->closeCursor();


    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $utilisateur_id2);
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM Messages WHERE (utilisateur_id1 = :utilisateur_id1 AND utilisateur_id2 = :utilisateur_id2) OR (utilisateur_id2 = :utilisateur_id1 AND utilisateur_id1 = :utilisateur_id2) ORDER BY id ASC');
$stmt->bindParam(':utilisateur_id1',$utilisateur_id1);
$stmt->bindParam(':utilisateur_id2',$utilisateur_id2);
$stmt->execute();

$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    echo "<div>";
    echo "<p>" . htmlspecialchars($message['contenu']) . "</p>";
    echo "<p>Envoyé le: " . $message['date_publication'] . "</p>";
    echo "</div>";
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Discussion</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <textarea name="contenu" placeholder="Écrivez votre message ici..."></textarea>
        <input type="hidden" name="id" value="<?php echo $utilisateur_id2; ?>">
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>

