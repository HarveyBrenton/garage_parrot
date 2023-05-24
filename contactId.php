<?php
include 'cookies.php';
include 'dns.php';
// Récupérer l'ID de la voiture depuis l'URL
if (isset($_GET['id'])) {
    $carId = $_GET['id'];

    // Récupération du titre correspondant à l'ID
    try {
        $stmt = $conn->prepare("SELECT title FROM vehicles WHERE id = :carId");
        $stmt->bindParam(':carId', $carId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $carTitle = $result['title'];
            // Utiliser $carTitle
        } else {
            
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        $errorLog = 'Erreur lors de la récupération du titre du véhicule : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');

        header("Location: index.php");
        exit();
    }
} else {
    
    header("Location: index.php");
    exit();
}

// Récupération des véhicules non filtrés
try {
    $stmt = $conn->prepare("SELECT * FROM vehicles");
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorLog = 'Erreur lors de la récupération des voitures d\'occasion : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
    // Rediriger vers une page d'erreur en cas d'erreur de requête
    header("Location: error.php");
    exit();
}



//Récupérer le nom du modèle de voiture
$carModel = $carTitle;


?>

<?php include 'header.php'; ?>

    <main>
        <section>
            <div class="contact-details-title">
            <h1><?php echo $carModel; ?></h1>
            <p>Vous pouvez nous contacter pour toute question ou demande d'informations concernant cette voiture.</p>
            </div>

            <div class="contact-details">
                <h2>Coordonnées du garage :</h2>
                <p>17 rue des Parrots, France<br>
                    Tel : 0123456789<br>
                    Email : parrot@mail.com</p>
            </div>


    <!-- Formulaire de contact -->
    
    <h2>Formulaire de contact</h2>
    <div class="contact-form">
    <form action="submit_contact.php" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $carId; ?>">
        
        <div class="form-group">
            <label for="first_name">Nom :</label>
            <input type="text" name="first_name" id="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Prénom :</label>
            <input type="text" name="last_name" id="last_name" required>
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

        </section>
    </main>


<!--AJOUT DU FOOTER-->
<?php include 'footer.php'; ?>
