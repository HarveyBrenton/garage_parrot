<?php
include 'cookies.php';
include 'dns.php';
// Récupérer l'ID de la voiture depuis l'URL
if (isset($_GET['id'])) {
    $carId = $_GET['id'];
} else {
    // Rediriger vers une page d'erreur si l'ID n'est pas spécifié
    header("Location: error.php");
    exit();
}


// Exemple : récupérer le nom du modèle de voiture
$carModel = "Modèle de voiture";

// Exemple : récupérer les coordonnées du concessionnaire associé à la voiture
$dealerName = "Concessionnaire XYZ";
$dealerEmail = "contact@concessionnaire.com";
$dealerPhone = "0123456789";

// Autres opérations ou récupérations de données en fonction de l'ID de la voiture

?>

<?php include 'header.php'; ?>

    <main>
        <section>
            <h1>Contactez-nous à propos de la voiture <?php echo $carModel; ?></h1>
            <p>Vous pouvez nous contacter pour toute question ou demande d'informations concernant cette voiture.</p>

            <div class="contact-details">
                <h2>Coordonnées du concessionnaire :</h2>
                <p>Nom du concessionnaire : <?php echo $dealerName; ?></p>
                <p>Email : <?php echo $dealerEmail; ?></p>
                <p>Téléphone : <?php echo $dealerPhone; ?></p>
            </div>

            <div class="contact-form">
                <!-- Code HTML du formulaire de contact -->
                <div class="contact-form">
    <h2>Formulaire de contact</h2>
    <form action="submit_contact.php" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
        
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="phone">Numéro de téléphone :</label>
            <input type="tel" name="phone" id="phone" required>
        </div>

        <div class="form-group">
        <label for="message">Message :</label>
        <textarea name="message" required></textarea>
        </div>

        <button type="submit">Envoyer</button>
    </form>
</div>

            </div>
        </section>
    </main>



<!--AJOUT DU FOOTER-->
<?php include 'footer.php'; ?>
