<?php include 'cookies.php'; ?>
<?php include 'header.php'; ?>

<h1>Nos véhicules d'occasion</h1>

<form action="vehicles.php" method="GET" class="filter-form">
    <label for="filter" class="filter-label">Filtrer par :</label>
    <select name="filter" id="filter" class="filter-select">
        <option value="year">Année</option>
        <option value="price">Prix</option>
        <option value="mileage">Kilométrage</option>
    </select>

    <label for="min_value" class="filter-label">Valeur min :</label>
    <input type="text" name="min_value" id="min_value" placeholder="Entrez une valeur minimale" class="filter-input">

    <label for="max_value" class="filter-label">Valeur max :</label>
    <input type="text" name="max_value" id="max_value" placeholder="Entrez une valeur maximale" class="filter-input">

    <button type="submit" class="filter-button">Filtrer</button>
</form>


<?php
// Inclure le fichier de connexion à la base de données
include 'dns.php';

// Définir les critères de filtrage par défaut
$filters = array(
    'year' => null,
    'price' => null,
    'mileage' => null
);

// Vérifier si des paramètres de filtrage sont présents dans l'URL
if (isset($_GET['filter']) && isset($_GET['min_value']) && isset($_GET['max_value'])) {
    $filter = $_GET['filter'];
    $minValue = $_GET['min_value'];
    $maxValue = $_GET['max_value'];

    // Vérifier si le paramètre de filtrage est valide
    if (array_key_exists($filter, $filters)) {
        // Mettre à jour les critères de filtrage
        $filters[$filter] = array('min' => $minValue, 'max' => $maxValue);
    }
}

// Construire la requête SQL en fonction des critères de filtrage
$query = "SELECT * FROM vehicles WHERE 1=1";

// Filtrer par année
if (!empty($filters['year'])) {
    $minYear = $filters['year']['min'];
    $maxYear = $filters['year']['max'];
    $query .= " AND year >= :min_year AND year <= :max_year";
}

// Filtrer par prix
if (!empty($filters['price'])) {
    $minPrice = $filters['price']['min'];
    $maxPrice = $filters['price']['max'];
    $query .= " AND price >= :min_price AND price <= :max_price";
}

// Filtrer par kilométrage
if (!empty($filters['mileage'])) {
    $minMileage = $filters['mileage']['min'];
    $maxMileage = $filters['mileage']['max'];
    $query .= " AND mileage >= :min_mileage AND mileage <= :max_mileage";
}

// Préparer et exécuter la requête
$stmt = $conn->prepare($query);

// Binder les valeurs des paramètres de filtrage
if (!empty($filters['year'])) {
    $stmt->bindParam(':min_year', $minYear, PDO::PARAM_INT);
    $stmt->bindParam(':max_year', $maxYear, PDO::PARAM_INT);
}

if (!empty($filters['price'])) {
    $stmt->bindParam(':min_price', $minPrice, PDO::PARAM_STR);
    $stmt->bindParam(':max_price', $maxPrice, PDO::PARAM_STR);
}

if (!empty($filters['mileage'])) {
    $stmt->bindParam(':min_mileage', $minMileage, PDO::PARAM_INT);
    $stmt->bindParam(':max_mileage', $maxMileage, PDO::PARAM_INT);
}

$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Affichage des véhicules filtrés -->
<div class="vehicle-list">
    <?php foreach ($vehicles as $vehicle) : ?>
        <div class="vehicle-card">
            <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>" class="vehicle-image">
            <div class="cars_info">
            <h3 class="vehicle-title"><?php echo $vehicle['title']; ?></h3>
            <p class="vehicle-info">Prix: <?php echo $vehicle['price']; ?> €<br>
                Année: <?php echo $vehicle['year']; ?><br>
                Kilométrage: <?php echo $vehicle['mileage']; ?> km</p>
            <a href="details.php?id=<?php echo $vehicle['id']; ?>" class="vehicle-details">Détails</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php include 'footer.php'; ?>
