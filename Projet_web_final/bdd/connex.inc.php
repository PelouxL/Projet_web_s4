<?php                                                                                                   
function connexion($file){
  try {
      $pdo = new PDO('sqlite:'.$file);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
      echo $e->getMessage();
      echo 'Problème à la connexion'."\n";
      die();
  }
  return $pdo;
}
?>
