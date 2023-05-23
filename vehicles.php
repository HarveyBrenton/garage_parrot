<?php
include 'cookies.php';
include 'header.php';

// Connexion à la base de données
include 'dns.php';

// Récupération des véhicules non filtrés
try {
  $stmt = $conn->prepare("SELECT * FROM vehicles");
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
  error_log($errorLog, 3, 'erreurs.log');
}

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



<!-- Affichage des véhicules filtrés -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    let filterForm = document.getElementById('filter-form');
    let filteredVehicles = document.getElementById('filtered-vehicles');

    filterForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        let filterData = {
            min_value: document.getElementById('min_value').value,
            max_value: document.getElementById('max_value').value
        };

        // Envoyer la requête AJAX avec les données filtrées
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'filter.php?' + new URLSearchParams(filterData));
        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if (response.length > 0) {
                    let html = '';

                    response.forEach(function(vehicle) {
                        html += `
                            <div class="vehicle">
                                <img src="${vehicle.image}" alt="${vehicle.title}">
                                <div class="text-content">
                                    <h3>${vehicle.title}</h3>
                                    <p>Prix: ${vehicle.price} €<br>
                                    Année: ${vehicle.year}<br>
                                    Kilométrage: ${vehicle.mileage} km</p>
                                    <a href="details.php?id=${vehicle.id}" class="detail-link">+ Détails</a><br>
                                    <a href="contactId.php?id=${vehicle.id}" class="detail-link">+ Contact</a>
                                </div>
                            </div>
                        `;
                    });

                    filteredVehicles.innerHTML = html;
                } else {
                    filteredVehicles.innerHTML = '<p>Aucun véhicule ne correspond aux critères de filtrage.</p>';
                }
            }
        };
        xhr.send();
    });
});

</script>

<!-- FOOTER -->
<?php include 'footer.php'; ?>