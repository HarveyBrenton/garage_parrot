<?php
// Vérifier si l'administrateur est authentifié
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_token'])) {
    // Rediriger vers la page de connexion si l'administrateur n'est pas authentifié
    header("Location: login.php");
    exit;
}

include 'dns.php';

// Récupérer les horaires depuis la base de données
$stmt = $conn->query("SELECT * FROM opening_hours LIMIT 1");
$openingHours = $stmt->fetch(PDO::FETCH_ASSOC);

// Définir les variables des horaires
$monHours = $openingHours['mon_hours'];
$tueHours = $openingHours['tue_hours'];
$wedHours = $openingHours['wed_hours'];
$thuHours = $openingHours['thu_hours'];
$friHours = $openingHours['fri_hours'];
$satHours = $openingHours['sat_hours'];
$sunHours = $openingHours['sun_hours'];

// Traitement du formulaire de modification des horaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monHours = htmlspecialchars($_POST['mon_hours']);
    $tueHours = htmlspecialchars($_POST['tue_hours']);
    $wedHours = htmlspecialchars($_POST['wed_hours']);
    $thuHours = htmlspecialchars($_POST['thu_hours']);
    $friHours = htmlspecialchars($_POST['fri_hours']);
    $satHours = htmlspecialchars($_POST['sat_hours']);
    $sunHours = htmlspecialchars($_POST['sun_hours']);

    // Effectuer les opérations de mise à jour des horaires dans la base de données
    $stmt = $conn->prepare("UPDATE opening_hours SET mon_hours = :mon, tue_hours = :tue, wed_hours = :wed, thu_hours = :thu, fri_hours = :fri, sat_hours = :sat, sun_hours = :sun WHERE id = 1");
    $stmt->bindParam(':mon', $monHours, PDO::PARAM_STR);
    $stmt->bindParam(':tue', $tueHours, PDO::PARAM_STR);
    $stmt->bindParam(':wed', $wedHours, PDO::PARAM_STR);
    $stmt->bindParam(':thu', $thuHours, PDO::PARAM_STR);
    $stmt->bindParam(':fri', $friHours, PDO::PARAM_STR);
    $stmt->bindParam(':sat', $satHours, PDO::PARAM_STR);
    $stmt->bindParam(':sun', $sunHours, PDO::PARAM_STR);
    $stmt->execute();

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: update_hours.php?success=1");
    exit;
}
?>
<!--DEBUT HTML-->
<?php include 'header.php'; ?>

<h1>Tableau de bord administrateur</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Les modifications ont été enregistrées avec succès.</p>
<?php endif; ?>



<!--FORMULAIRE SERVICES-->
<div>
    <h3>Services</h3>
    <a href="update_services.php">Modifier les services</a>
</div>


<!--FORMULAIRE COMPTE EMPLOYE-->
<div>
    <h3>Compte employé</h3>
    <a href="create_employee.php">Créer un compte</a>
</div>


<h3>Modifier les horaires d'ouverture</h3>

<div class="hour-container"></div>
<form method="POST" action="">
    <label for="mon_hours">Lun. :</label>
    <input type="text" name="mon_hours" value="<?php echo htmlspecialchars($monHours); ?>"><br>

    <label for="tue_hours">Mar. :</label>
    <input type="text" name="tue_hours" value="<?php echo htmlspecialchars($tueHours); ?>"><br>

    <label for="wed_hours">Mer. :</label>
    <input type="text" name="wed_hours" value="<?php echo htmlspecialchars($wedHours); ?>"><br>

    <label for="thu_hours">Jeu. :</label>
    <input type="text" name="thu_hours" value="<?php echo htmlspecialchars($thuHours); ?>"><br>

    <label for="fri_hours">Ven. :</label>
    <input type="text" name="fri_hours" value="<?php echo htmlspecialchars($friHours); ?>"><br>

    <label for="sat_hours">Sam. :</label>
    <input type="text" name="sat_hours" value="<?php echo htmlspecialchars($satHours); ?>"><br>

    <label for="sun_hours">Dim. :</label>
    <input type="text" name="sun_hours" value="<?php echo htmlspecialchars($sunHours); ?>"><br>

    <button type="submit">Enregistrer</button>
</form>
</div>


<!--FOOTER-->
<?php include 'footer.php' ?>

