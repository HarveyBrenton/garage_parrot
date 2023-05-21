<?php include 'header.php'; ?>

  <!-- Bannière principale -->
  <section id="accueil">
    <div class="banner">
      <img src="garage-image.jpg" alt="Garage Image">
      <h1>Garage V. Parrot</h1>
      <p>Expertise en réparation automobile</p>
    </div>
  </section>

  <!-- Section des services -->
  <section id="services">
    <h2>Nos Services</h2>
    <div class="services">
      <div class="service">
        <img src="service1.png" alt="Service 1">
        <h3>Réparation carosserie</h3>
        <p>Description du service 1</p>
      </div>
      <div class="service">
        <img src="service2.png" alt="Service 2">
        <h3>Réparation mécanique</h3>
        <p>Description du service 2</p>
      </div>
      <!-- Ajouter d'autres services ici -->
      <div class="service">
        <img src="service2.png" alt="Service 2">
        <h3>Entretien régulier</h3>
        <p>Garantir leur performance et leur sécurité</p>
      </div>
    </div>
  </section>

  <!-- Section des véhicules d'occasion -->
  <section id="vehicules">
    <h2>Véhicules d'occasion</h2>
    <div class="vehicles">
      <div class="vehicle">
        <img src="car1.jpg" alt="Véhicule 1">
        <h3>Véhicule 1</h3>
        <p>Prix: 10000 €</p>
        <p>Année: 2018</p>
        <p>Kilométrage: 50000 km</p>
        <a href="detail.php?id=1">Détail</a>
      </div>
      <div class="vehicle">
        <img src="car2.jpg" alt="Véhicule 2"> C:\Users\g_nic\garage_parrot
        <h3>Véhicule 2</h3>
        <p>Prix: 15000 €</p>
        <p>Année: 2019</p>
        <p>Kilométrage: 30000 km</p>
        <a href="detail.php?id=2">Détail</a>
      </div>
      <!-- Ajouter d'autres véhicules ici -->
    </div>
  </section>


  <?php
// Effectuer la connexion à la base de données (vous devrez configurer les informations de connexion appropriées)
$servername = "localhost";
$dbname = "garage_parrot";
$username = "root";
$password_db = "Harvey";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données.';
    error_log($errorLog, 3, 'erreurs.log');
    header('Location: server_error.html');

    exit;
}

// Création du compte administrateur
$adminFirstName = "Vincent";
$adminLastName = "Parrot";
$adminEmail = "vincent.parrot@example.com";
$adminPassword = password_hash("admin", PASSWORD_DEFAULT);

// Vérifier si le compte administrateur existe déjà
$stmt = $conn->prepare("SELECT * FROM Admin WHERE email = :email");
$stmt->bindParam(':email', $adminEmail);
$stmt->execute();
if ($stmt->rowCount() === 0) {
    // Le compte administrateur n'existe pas, l'insérer dans la base de données
    $stmt = $conn->prepare("INSERT INTO Admin (first_name, last_name, email, password) VALUES (:firstName, :lastName, :email, :password)");
    $stmt->bindParam(':firstName', $adminFirstName);
    $stmt->bindParam(':lastName', $adminLastName);
    $stmt->bindParam(':email', $adminEmail);
    $stmt->bindParam(':password', $adminPassword);
    $stmt->execute();
    echo "Le compte administrateur a été créé avec succès.";
} else {
    echo "Le compte administrateur existe déjà.";
}


?>

<footer>
  <?php include 'footer.php'; ?>
</footer>

  <script src="assets\script.js"></script>
</body>
</html>