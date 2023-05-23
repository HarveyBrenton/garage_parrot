<?php
// Vérifier si l'identifiant du véhicule est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger l'utilisateur vers une page d'erreur ou une liste de véhicules
    header('Location: index.php');
    exit();
}

// Récupérer l'identifiant du véhicule depuis l'URL
$vehicleId = $_GET['id'];

// Effectuer les validations et filtrages nécessaires sur l'identifiant du véhicule
$vehicleId = filter_var($vehicleId, FILTER_VALIDATE_INT);
if ($vehicleId === false) {
    // Rediriger l'utilisateur vers une page d'erreur ou une liste de véhicules
    header('Location: index.php');
    exit();
}


// Effectuer la connexion à la base de données
$servername = "localhost";
$username = "root";
$password_db = "Harvey";
$dbname = "garage_parrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée ou affichage d'un message d'erreur convivial
    header('Location: server_error.php');
    exit;
}


try {
    // Préparer et exécuter la requête SQL pour récupérer les détails du véhicule
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        // Rediriger l'utilisateur vers une page d'erreur ou une liste de véhicules
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des détails du véhicule : ' . $e->getMessage());
    die('Une erreur est survenue. Veuillez réessayer ultérieurement.');
}

// Fermer la connexion à la base de données
$conn = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Détails du véhicule - <?php echo $vehicle['title']; ?></title>
<link rel="stylesheet" href="assets/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@200&display=swap" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <a href="profile.php">Profile</a>
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
</head>
    <h1>Détails du véhicule - <?php echo $vehicle['title']; ?></h1>
    <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>">
    <img src="<?php echo $vehicle['image1']; ?>" alt="<?php echo $vehicle['title']; ?>">
    <p>Prix: <?php echo $vehicle['price']; ?> €</p>
    <p>Année: <?php echo $vehicle['year']; ?></p>
    <p>Kilométrage: <?php echo $vehicle['mileage']; ?> km</p>

    <!-- Autres détails du véhicule -->

    <a href="index.php">Retour

    
