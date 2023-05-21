<?php
// Génération d'un identifiant unique sécurisé
$sessionId = bin2hex(random_bytes(16));

// Paramètres du cookie
$cookieName = "session_id";
$cookieValue = $sessionId;
$cookieExpiration = time() + (86400 * 30); //Durée de 30 jours
$cookiePath = "/";
$cookieDomain = "localhost";
$cookieSecure = false; // false pour le développement local
$cookieHttpOnly = true;

// Paramétrage du cookie
setcookie($cookieName, $cookieValue, $cookieExpiration, $cookiePath, $cookieDomain, $cookieSecure, $cookieHttpOnly);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Parrot</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
      <header>
    <div class="logo">
      <img src="logo.png" alt="Garage V. Parrot Logo">
    </div>
    <nav>
      <ul>
        <li><a href="#accueil">Accueil</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#vehicules">Véhicules d'occasion</a></li>
        <li><a href="#temoignages">Témoignages</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
    <div class="login">
      <a href="login_form.php">Se connecter</a>
    </div>
  </header>