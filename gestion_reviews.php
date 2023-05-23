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

// Traitement de l'approbation ou du rejet d'un review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    $reviewId = $_POST['review_id'];
    
    if (isset($_POST['approve'])) {
        // Approuver le review en mettant à jour le champ 'approved' à 1 dans la table Reviews
        $stmt = $conn->prepare("UPDATE Reviews SET approved = 1 WHERE id = :reviewId");
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Rediriger vers le tableau de bord gestion_reviews.php avec un message de succès
        header("Location: gestion_reviews.php?success=1");
        exit;
    }
    
    if (isset($_POST['reject'])) {
        // Supprimer le review de la table Reviews
        $stmt = $conn->prepare("DELETE FROM Reviews WHERE id = :reviewId");
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Rediriger vers le tableau de bord gestion_reviews.php avec un message de succès
        header("Location: gestion_reviews.php?success=1");
        exit;
    }
}

// Récupérer toutes les reviews existantes depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews");
$stmt->execute();
$existingReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les nouveaux reviews non approuvés depuis la table Reviews
$stmt = $conn->prepare("SELECT * FROM Reviews WHERE approved = 0");
$stmt->execute();
$newReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<h1>Tableau de bord</h1>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Action effectuée avec succès !</p>
<?php endif; ?>

<!-- FORMULAIRE Véhicules d'occasions -->
<div>
    <h3>Véhicules d'occasions</h3>
    <a href="add_vehicles_employee.php">Ajouter une voiture</a>
</div>

<section class="existing-reviews">
    <h2>Avis existants</h2>
    <?php
    if (!empty($existingReviews)) {
        foreach ($existingReviews as $review) {
            echo "<p><strong>Rating:</strong> " . htmlspecialchars($review['rating']) . "</p>";
            echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($review['comment']) . "</p>";
            echo "<p><strong>Nom de l'auteur:</strong> " . htmlspecialchars($review['reviewer_name']) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "Aucun avis existant.";
    }
    ?>
</section>

<section class="new-reviews">
    <h2>Nouveaux Avis</h2>
    <?php
    if (!empty($newReviews)) {
        foreach ($newReviews as $review) {
            echo "<p><strong>Rating:</strong> " . htmlspecialchars($review['rating']) . "</p>";
            echo "<p><strong>Commentaire:</strong> " . htmlspecialchars($review['comment']) . "</p>";
            echo "<p><strong>Nom de l'auteur:</strong> " . htmlspecialchars($review['reviewer_name']) . "</p>";
            echo '<form method="POST" action="gestion_reviews.php">';
            echo '<input type="hidden" name="review_id" value="' . htmlspecialchars($review['id']) . '">';
            echo '<input type="submit" name="approve" value="Approuver">';
            echo '<input type="submit" name="reject" value="Rejeter">';
            echo '</form>';
        }
    } else {
        echo "Aucun nouvel avis à examiner.";
    }
    ?>
</section>

<?php include 'footer.php'; ?>
