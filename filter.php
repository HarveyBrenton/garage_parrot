<?php
include 'dns.php';

$selectedKilometer = $_GET['kilometer'];
$selectedPrice = $_GET['price'];
$selectedYear = $_GET['year'];

try {
    $stmt = $conn->prepare("SELECT * FROM vehicles WHERE mileage <= :kilometer AND price <= :price AND year >= :year");
    $stmt->bindValue(':kilometer', $selectedKilometer, PDO::PARAM_INT);
    $stmt->bindValue(':price', $selectedPrice, PDO::PARAM_INT);
    $stmt->bindValue(':year', $selectedYear, PDO::PARAM_INT);
    $stmt->execute();
    $filteredResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($filteredResults);
} catch (PDOException $e) {
    echo "Une erreur s'est produite lors de la récupération des résultats filtrés : " . $e->getMessage();
}
?>
