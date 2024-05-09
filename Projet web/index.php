<?php
session_start();
$_SESSION['username'] = "";
$_SESSION['statut'] = 1;

?>

<html>
  <html lang="fr">
 <head>
    <meta charset="utf-8"> 
    <Title> Projet</Title>
    <link href="../css/main.css" rel="stylesheet">
 </head>
 <body>
     <?php
     if(empty($_SESSION['username'])){
         header('location: http://localhost:8000/php/connexion.php');
     }
     

     ?>
    <div class="Sidebar"> 
      <header><img src="../images/oljl.png" alt="image du Logo">Logo</header>
      <ul>
        <li>Accueuille </li>
        <li>Abonnement </li>
        <li>Notification</li>
        <li>Profile </li>
        <li>Poste
        <li>Paramètres </li>
      </ul>
  </div>
  <div class="File_actualite">
    <button type="button">File d'actualuté</button>
  </div>
  <div class="File_video">
    <button type="button">File vidéo</button>
  </div>
  <div class="Pourtoi">
    

  </body> 