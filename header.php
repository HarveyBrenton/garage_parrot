<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Parrot</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@200&display=swap" rel="stylesheet">

</head>
<body>
  <header>
    <div class="logo">
      <img src="assets\img\logo-garage.png" alt="Garage V. Parrot Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="vehicles.php">Véhicules d'occasion</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
    <div class="login">
    <a href="profile.php">Mon compte</a>
      <?php

        if (isset($_SESSION['admin_token']) || isset($_SESSION['employee_token'])) {
          // Utilisateur connecté, afficher le bouton "Se déconnecter"
          echo '<a href="logout.php">Se déconnecter</a>';
        } else {
          // Utilisateur non connecté, afficher le bouton "Se connecter"
          echo '<a href="login_form.php">Se connecter</a>';
        }

      ?>
    </div>
  </header>