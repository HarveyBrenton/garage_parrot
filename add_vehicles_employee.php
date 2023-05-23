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

// Traitement de l'ajout d'une voiture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire d'ajout de voiture a été soumis
    if (isset($_POST['title'], $_POST['price'], $_POST['year'], $_POST['mileage'])) {
        // Récupérer les données du formulaire
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
        $mileage = filter_var($_POST['mileage'], FILTER_SANITIZE_NUMBER_INT);

        // Vérifier si des fichiers ont été téléchargés
        $uploadedImages = [];
        for ($i = 0; $i < 3; $i++) {
            if (isset($_FILES['image'.$i]) && $_FILES['image'.$i]['error'] === UPLOAD_ERR_OK) {
                $image_tmp = $_FILES['image'.$i]['tmp_name'];
                $image_name = $_FILES['image'.$i]['name'];
                $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                
                // Générer un nom de fichier unique
                $unique_image_name = uniqid() . '.' . $image_extension;

                // Valider l'extension du fichier
                $allowed_extensions = ['jpg', 'jpeg'];
                if (!in_array($image_extension, $allowed_extensions)) {
                    echo "L'extension du fichier image ".$i." n'est pas autorisée. Veuillez télécharger un fichier JPEG valide.";
                    exit;
                }

                // Déplacer le fichier téléchargé vers le répertoire de destination
                $destination = 'assets/img/' . $unique_image_name;
                if (!move_uploaded_file($image_tmp, $destination)) {
                    echo "Une erreur s'est produite lors du téléchargement de l'image ".$i.". Veuillez réessayer.";
                    exit;
                }

                $uploadedImages[] = $unique_image_name;
            }
        }

        // Insérer la nouvelle voiture dans la table vehicles
        $stmt = $conn->prepare("INSERT INTO vehicles (title, price, year, mileage, image, image1, image2) VALUES (:title, :price, :year, :mileage, :image, :image1, :image2)");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
        $stmt->bindValue(':mileage', $mileage, PDO::PARAM_INT);
        $stmt->bindValue(':image', $uploadedImages[0] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':image1', $uploadedImages[1] ?? '', PDO::PARAM_STR);
        $stmt->bindValue(':image2', $uploadedImages[2] ?? '', PDO::PARAM_STR);
        $stmt->execute();

        // Rediriger vers le tableau de bord add_vehicles_employee.php avec un message de succès
        header("Location: add_vehicles_employee.php?success=1");
        exit;
    } else {
        echo "Les données du formulaire sont incomplètes.";
    }
}

include 'header.php';
?>

<h1>Tableau de bord</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Ajout effectué avec succès !</p>
<?php endif; ?>

<!-- FORMULAIRE Véhicules d'occasions -->
<div>
    <h3>Véhicules d'occasions</h3>
    <a href="add_vehicles_employee.php">Ajouter une voiture</a>

    <form method="POST" action="" enctype="multipart/form-data">
        <label for="title">Titre :</label>
        <input type="text" name="title" required><br>

        <label for="price">Prix :</label>
        <input type="text" name="price" required><br>

        <label for="year">Année :</label>
        <input type="text" name="year" required><br>

        <label for="mileage">Kilométrage :</label>
        <input type="text" name="mileage" required><br>

        <label for="image">Image 1 :</label>
        <input type="file" name="image" required><br>

        <label for="image1">Image 2 :</label>
        <input type="file" name="image1"><br>

        <label for="image2">Image 3 :</label>
        <input type="file" name="image2"><br>

        <input type="submit" value="Ajouter la voiture">
    </form>
</div>

<!-- FORMULAIRE avis clients -->
<div>
    <h3>Gestion des avis clients</h3>
    <a href="gestion_reviews.php">Gérer les avis</a>
</div>

<?php include 'footer.php'; ?>