<?php
// Effectuer la connexion à la base de données (vous devrez configurer les informations de connexion appropriées)
$servername = "localhost";
$dbname = "garage_parrot";
$username = "root";
$password_db = "Harvey";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier de log
    $errorLog = 'Erreur lors de la connexion à la base de données : ' . $e->getMessage() . PHP_EOL;
    error_log($errorLog, 3, 'erreurs.log');

    // Redirection vers une page d'erreur personnalisée ou affichage d'un message d'erreur convivial
    header('Location: server_error.html');
    exit;
}

// Création du compte administrateur
$adminFirstName = "Vincent";
$adminLastName = "Parrot";
$adminEmail = "vincent.parrot@example.com";
$adminPassword = password_hash("admin", PASSWORD_DEFAULT);

// Vérifier si le compte administrateur existe déjà
$stmt = $conn->prepare("SELECT * FROM Admin WHERE email = :email");
$stmt->bindParam(':email', $adminEmail);
$stmt->execute();
if ($stmt->rowCount() === 0) {
    // Le compte administrateur n'existe pas, l'insérer dans la base de données
    $stmt = $conn->prepare("INSERT INTO Admin (first_name, last_name, email, password) VALUES (:firstName, :lastName, :email, :password)");
    $stmt->bindParam(':firstName', $adminFirstName);
    $stmt->bindParam(':lastName', $adminLastName);
    $stmt->bindParam(':email', $adminEmail);
    $stmt->bindParam(':password', $adminPassword);
    $stmt->execute();
    echo "Le compte administrateur a été créé avec succès." . PHP_EOL;
} else {
    echo "Le compte administrateur existe déjà." . PHP_EOL;
}

// Création des comptes des employés
$employeeData = array(
    array("John", "Doe", "john.doe@example.com", "employe_1"),
    array("Jane", "Smith", "jane.smith@example.com", "employe_2"),
    array("Michael", "Johnson", "michael.johnson@example.com", "employe_3")
);

foreach ($employeeData as $data) {
    $firstName = $data[0];
    $lastName = $data[1];
    $email = $data[2];
    $password = password_hash($data[3], PASSWORD_DEFAULT);

    // Vérifier si le compte employé existe déjà
    $stmt = $conn->prepare("SELECT * FROM Employees WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() === 0) {
        // Vérifier les privilèges de l'utilisateur connecté
        $stmt = $conn->prepare("SELECT id FROM Admin WHERE email = :adminEmail");
        $stmt->bindParam(':adminEmail', $adminEmail);
        $stmt->execute();
        $adminId = $stmt->fetchColumn();

        if ($adminId === '1') {
            // L'utilisateur connecté est un administrateur, insérer le compte employé dans la base de données
            $stmt = $conn->prepare("INSERT INTO Employees (first_name, last_name, email, password, admin_id) VALUES (:firstName, :lastName, :email, :password, :adminId)");
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindValue(':adminId', 1);
            $stmt->execute();
            echo "Le compte employé pour $firstName $lastName a été créé avec succès." . PHP_EOL;
        } else {
            echo "Seul l'administrateur peut créer des comptes employés." . PHP_EOL;
        }
    } else {
        echo "Le compte employé pour $firstName $lastName existe déjà." . PHP_EOL;
    }
}

echo "Les comptes des employés ont été créés avec succès.";



?>

