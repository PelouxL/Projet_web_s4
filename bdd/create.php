<?php
include('connex.inc.php');

$pdo = connexion('database.sqlite');

$sql = file_get_contents('membres.sql');
try {
$pdo->exec($sql);
} catch(PDOException $e) {
echo $e->getMessage();
}
?>