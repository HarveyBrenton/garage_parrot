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


// Début du code HTML
?>
<?php include 'header.php' ?>


    <h1>Tableau de bord administrateur</h1>


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


    <!--FORMULAIRE HORAIRES-->
    <div class="update_hours-container">
        <h3>Modifier les horaires d'ouverture</h3>
        <a href="update_hours.php">Modifier les horaires</a>
    </div>


    <!--FOOTER-->
    <?php include 'footer.php' ?>