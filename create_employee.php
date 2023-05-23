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

// Traitement du formulaire de création d'un employé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];

    // Effectuer les opérations d'insertion dans la base de données pour créer un nouvel employé
    $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, email) VALUES (:first_name, :last_name, :email)");
    $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: create_employee.php?success=1");
    exit;
}
?>

<?php include 'header.php' ?>


    <h1>Tableau de bord administrateur</h1>

    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Les modifications ont été enregistrées avec succès.</p>
    <?php endif; ?>


    <!--FORMULAIRE SERVICES-->
<div>
    <h3>Services</h3>
    <a href="update_services.php">Modifier les services</a>
</div>


<h3>Création d'un compte employé</h3>

<form method="POST" action="">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name"><br>
    <label for="last_name">Nom :</label>
    <input type="text" name="last_name"><br>
    <label for="email">Email :</label>
    <input type="email" name="email"><br>
    <button type="submit">Créer</button>
</form>



<!--FORMULAIRE HORAIRES-->
<div>
    <h3>Modifier les horaires d'ouverture</h3>
    <a href="update_hours.php">Modifier les horaires</a>
</div>


    <!--FOOTER-->
    <?php include 'footer.php' ?>
