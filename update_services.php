<?php
// Vérifier si l'administrateur est authentifié
session_start();

if (!isset($_SESSION['admin_token'])) {
    // Rediriger vers la page de connexion si l'administrateur n'est pas authentifié
    header("Location: login.php");
    exit;
}

include 'dns.php';

// Récupérer les services depuis la base de données
$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement des actions de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parcourir les services pour mettre à jour les informations
    foreach ($services as $service) {
        $serviceId = $service['id'];
        $newTitle = trim($_POST['title'][$serviceId]);
        $newDescription = trim($_POST['description'][$serviceId]);

        // Vérifier si un fichier a été téléchargé pour ce service
        if (isset($_FILES['image']['tmp_name'][$serviceId]) && !empty($_FILES['image']['tmp_name'][$serviceId])) {
            $file = $_FILES['image']['tmp_name'][$serviceId];
            $fileName = $_FILES['image']['name'][$serviceId];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $fileExtension;
            $filePath = 'assets/img/' . $newFileName;

            // Déplacer le fichier téléchargé vers le répertoire des téléchargements
            move_uploaded_file($file, $filePath);
            $newImage = $filePath;
        } else {
            // Conserver l'image existante si aucun fichier n'a été téléchargé
            $newImage = $service['image'];
        }

        // Effectuer les opérations de mise à jour des informations des services dans la base de données
        $updateStmt = $conn->prepare("UPDATE services SET title = :title, image = :image, description = :description WHERE id = :id");
        $updateStmt->bindParam(':title', $newTitle, PDO::PARAM_STR);
        $updateStmt->bindParam(':image', $newImage, PDO::PARAM_STR);
        $updateStmt->bindParam(':description', $newDescription, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $serviceId, PDO::PARAM_INT);
        $updateStmt->execute();
    }

    // Rediriger vers le tableau de bord avec un message de succès
    header("Location: update_services.php?success=1");
    exit;
}
?>
<!--DEBUT HTML-->
<?php include 'header.php'; ?>

<h1>Tableau de bord administrateur</h1>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <p style="color: green;">Les modifications ont été enregistrées avec succès.</p>
<?php endif; ?>

<!--FORMULAIRE SERVICES-->
<div>
    <h3>Services</h3>
    <a href="update_services.php">Modifier les services</a>
    <form method="POST" action="" enctype="multipart/form-data">
        <?php foreach ($services as $service) : ?>
            <div class="service">
                <input type="hidden" name="id[<?php echo $service['id']; ?>]" value="<?php echo $service['id']; ?>">
                <label for="title[<?php echo $service['id']; ?>]">Titre :</label>
                <input type="text" name="title[<?php echo $service['id']; ?>]" value="<?php echo htmlspecialchars($service['title']); ?>"><br>
                <label for="image[<?php echo $service['id']; ?>]">Image :</label>
                <input type="file" name="image[<?php echo $service['id']; ?>]"><br>
                <label for="description[<?php echo $service['id']; ?>]">Description :</label>
                <textarea name="description[<?php echo $service['id']; ?>]"><?php echo htmlspecialchars($service['description']); ?></textarea><br>
            </div>
        <?php endforeach; ?>
        <button type="submit">Enregistrer les modifications</button>
    </form>
</div>

    <!--FORMULAIRE COMPTE EMPLOYE-->
    <div>
        <h3>Compte employé</h3>
        <a href="create_employee.php">Créer un compte</a>
    </div>


    <!--FORMULAIRE HORAIRES-->
    <div>
        <h3>Modifier les horaires d'ouverture</h3>
        <a href="update_hours.php">Modifier les horaires</a>
    </div>


    <!--FOOTER-->
    <?php include 'footer.php' ?>
