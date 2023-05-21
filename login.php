<?php
// Effectuer la connexion à la base de données (vous devrez configurer les informations de connexion appropriées)
$servername = "localhost";
$username = "root";
$password_db = "Harvey";
$dbname = "garage_parrot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée ou affichage d'un message d'erreur convivial
    header('Location: server_error.html');
    exit;
}

    // Récupérer les informations soumises par le formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier l'administrateur
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if (password_verify($password, $result['password'])) {
            // Authentification réussie en tant qu'administrateur
            // Générer et stocker le jeton d'authentification
            session_start();
            $_SESSION['admin_token'] = bin2hex(random_bytes(32));

            // Effectuer les actions appropriées
            // par exemple : header("Location: admin_dashboard.php");
        } else {
// Mot de passe incorrect
// Gérer l'échec de l'authentification
// par exemple : header("Location: login.php?error=1");
}
} else {
    // Vérifier la table "Employees" pour les correspondances
    $stmt = $conn->prepare("SELECT * FROM Employees WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if (password_verify($password, $result['password'])) {
            // Authentification réussie en tant qu'employé
            // Générer et stocker le jeton d'authentification
            session_start();
            $_SESSION['employee_token'] = bin2hex(random_bytes(32));

            // Effectuer les actions appropriées
            // par exemple : header("Location: employee_dashboard.php");
        } else {
            // Mot de passe incorrect
            // Gérer l'échec de l'authentification
            // par exemple : header("Location: login.php?error=1");
        }
    } else {
        // Aucune correspondance trouvée dans les tables "Admin" et "Employees"
        // Gérer l'échec de l'authentification
        // par exemple : header("Location: login.php?error=1");
    }
}

// Insertion d'un enregistrement d'administrateur
try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("INSERT INTO Admin (email, password) VALUES (:email, :password)");
    $email_admin = "admin@example.com";
    $password_admin = password_hash("admin123", PASSWORD_DEFAULT);
    $stmt->bindParam(':email', $email_admin);
    $stmt->bindParam(':password', $password_admin);
    $stmt->execute();

    $conn->commit();
} catch (PDOException $e) {
    $conn->rollBack();
    $errorLog = 'Erreur lors de la connexion à la base de données' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');
}

// Fermer la connexion à la base de données
$stmt = null;
$conn = null;

?>


?>
