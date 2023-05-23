<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'employé est connecté, sinon rediriger vers la page de connexion
if (!isset($_SESSION['employee_token'])) {
    header("Location: login.php");
    exit;
}

include 'dns.php';
?>

<?php include 'header.php' ?>


    <h1>Tableau de bord</h1>


    <!--FORMULAIRE Véhicules d'occasions-->
    <div>
        <h3>Véhicules d'occasions</h3>
        <a href="add_vehicles_employee.php">Ajouter une voiture</a>
    </div>


    <!--FORMULAIRE avis clients-->
    <div>
        <h3>Gestion des avis clients</h3>
        <a href="gestion_reviews.php">Gérer les avis</a>
    </div>



    <!--FOOTER-->
    <?php include 'footer.php' ?>