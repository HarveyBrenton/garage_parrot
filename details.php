<?php
session_start();

include 'dns.php';

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


try {
    // Préparer et exécuter la requête SQL pour récupérer les détails du véhicule
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        // Rediriger l'utilisateur
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des détails du véhicule : ' . $e->getMessage());
    header('Location: vehicles.php');
}


try {
    // Préparer et exécuter la requête SQL pour récupérer les équipements du véhicule
    $stmt = $conn->prepare("SELECT equipment_name FROM vehicle_equipment WHERE vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $equipment = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des équipements du véhicule : ' . $e->getMessage());
    // Gérer l'erreur d'une manière appropriée (par exemple, afficher un message d'erreur)
}

try {
    // Préparer et exécuter la requête SQL pour récupérer les caractéristiques du véhicule
    $stmt = $conn->prepare("SELECT feature_name, feature_value FROM vehicle_features WHERE vehicle_id = :vehicleId");
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log ou affichage d'un message d'erreur approprié
    error_log('Erreur lors de la récupération des caractéristiques du véhicule : ' . $e->getMessage());
    // Gérer l'erreur d'une manière appropriée (par exemple, afficher un message d'erreur)
}






// Fermer la connexion à la base de données
$conn = null;
?>
<?php include 'header.php'; ?>


    <h1>Détails du véhicule - <?php echo $vehicle['title']; ?></h1>
    <div class="img-container-details">
    <div class="img-details"><img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['title']; ?>"></div>
    <div class="img-details"><img src="<?php echo $vehicle['image1']; ?>" alt="<?php echo $vehicle['title']; ?>"></div>
    </div>
    <div class="car-details-info">
    <p>Prix: <?php echo $vehicle['price']; ?> €</p>
    <p>Année: <?php echo $vehicle['year']; ?></p>
    <p>Kilométrage: <?php echo $vehicle['mileage']; ?> km</p>
    <a href="contactId.php?id=<?php echo $vehicleId; ?>" class="btn-formulaire">Formulaire de contact</a>
    </div>

    <h2>Équipements</h2>
    <div class="ul-container">
<ul>
    <?php foreach ($equipment as $item) : ?>
        <li><?php echo $item; ?></li>
    <?php endforeach; ?>
</ul>
</div>

<h2>Caractéristiques</h2>
<div class="table-container">
<table>
    <tr>
        <th>Nom</th>
        <th>Valeur</th>
    </tr>
    <?php foreach ($features as $feature) : ?>
        <tr>
            <td><?php echo $feature['feature_name']; ?></td>
            <td><?php echo $feature['feature_value']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>

           


    <?php include 'form.php'; ?>

    <?php include 'footer.php'; ?>