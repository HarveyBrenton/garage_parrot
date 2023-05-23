<?php
include 'dns.php';

try {
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les valeurs de filtrage
    $min_price = $_GET['min_price'] ?? 0; // Valeur minimale par défaut
    $max_price = $_GET['max_price'] ?? 100000; // Valeur maximale par défaut

    // Ajouter les conditions WHERE pour la recherche de prix
    $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
    $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
    $stmt->execute();
    
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
}
?>

<section class="vehicle-list">
<div class="vehicles">
    <?php foreach ($vehicles as $vehicle) : ?>
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
</div>
</section>
