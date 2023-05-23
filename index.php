<!--AJOUT DU COOKIES + HEAD-->
<?php include 'cookies.php'; ?>
<?php include 'header.php'; ?>

  <!-- Bannière principale -->
  <section id="accueil">
    <div class="banner">
        <img class="banner-img" src="assets/img/banniere.jpeg" alt="Garage Image" loading="lazy">
        <div class="banner-content">
            <h1 class="banner-title">Garage V. Parrot</h1>
            <p class="banner-subtitle">Expertise en réparation automobile</p>
            <a href="contact.php">Nous contacter</a>
        </div>
    </div>
</section>


  <!-- Section des services -->
  <?php
// Récupérer les services depuis la base de données
include 'dns.php';
$stmt = $conn->query("SELECT * FROM services");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Section des services -->
<section id="services">
  <h2>Nos Services</h2>
  <div class="services">
    <?php foreach ($services as $service) : ?>
      <div class="service">
        <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
        <h3><?php echo htmlspecialchars($service['title']); ?></h3>
        <p><?php echo htmlspecialchars($service['description']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>



<!-- Section des véhicules d'occasion -->
<?php
include 'dns.php';
// Exécution de la requête SQL
try {
    // Sélectionnez toutes les voitures
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
}
?>

<section id="vehicules">
  <h2>Véhicules d'occasion</h2>
  <div class="vehicles">
    <?php foreach (array_slice($vehicles, 0, 3) as $vehicle): ?>
      <div class="vehicle">
        <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>">
        <div class="text-content">
        <h3><?php echo $vehicle['title']; ?></h3>
        <p>Prix: <?php echo $vehicle['price']; ?> €<br>
        Année: <?php echo $vehicle['year']; ?><br>
        Kilométrage: <?php echo $vehicle['mileage']; ?> km</p>
        <a href="details.php?id=<?php echo $vehicle['id']; ?>" class="detail-link">+ Détails</a><br>
        <a href="contactId.php?id=<?php echo $vehicle['id']; ?>" class="detail-link">+ Contact</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="all-cars">
  <a href="vehicles.php">Tout voir</a>
  </div>
</section>



<?php
include 'dns.php';

// Récupérer les reviews approuvées depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews WHERE approved = 1");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Section d'affichage des avis -->
<section class="existing-reviews">
  <h2>Avis clients</h2>
  <div class="reviews-carousel">
    <?php if (!empty($reviews)) : ?>
      <div class="slick-carousel">
        <?php foreach ($reviews as $review) : ?>
          <div class="review">
            <p><strong>Note :</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
            <p><strong>Commentaire :</strong> <?php echo htmlspecialchars($review['comment']); ?></p>
            <p><strong>Nom de l'auteur :</strong> <?php echo htmlspecialchars($review['reviewer_name']); ?></p>
            <hr>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <p>Aucun avis existant.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Section d'ajout d'un avis -->
<section class="add-review">
  <h2>Ajouter un commentaire</h2>
  <form method="POST" action="add_review.php">
    <div class="form-group">
      <label for="rating">Note :</label>
      <select name="rating" required>
        <option value="">Sélectionnez une note</option>
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="reviewer_name">Nom :</label>
      <input type="text" name="reviewer_name" required>
    </div>

    <div class="form-group">
      <label for="comment">Commentaire :</label>
      <textarea name="comment" required></textarea>
    </div>

    <div class="form-group">
      <input type="submit" value="Ajouter mon commentaire">
    </div>
  </form>
</section>


<!--AJOUT DU FOOTER-->
  <?php include 'footer.php'; ?>
