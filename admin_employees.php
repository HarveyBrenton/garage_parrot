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
    header('Location: server_error.php');
    exit;
}

// Création du compte administrateur
$adminFirstName = "Vincent";
$adminLastName = "Parrot";
$adminEmail = "vincent.parrot@example.com";
$adminPassword = password_hash("admin", PASSWORD_DEFAULT);


$adminFound = false;

// Vérifier si le compte administrateur existe déjà
$stmt = $conn->prepare("SELECT * FROM Admin");
$stmt->execute();
if ($stmt->rowCount() === 0) {
    // Le compte administrateur n'existe pas, l'insérer dans la base de données
    $stmt = $conn->prepare("INSERT INTO Admin (first_name, last_name, email, password) VALUES (:firstName, :lastName, :email, :password)");
    $stmt->bindParam(':firstName', $adminFirstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $adminLastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $adminEmail, PDO::PARAM_STR);
    $stmt->bindParam(':password', $adminPassword, PDO::PARAM_STR);
    $stmt->execute();
    echo "Le compte administrateur a été créé avec succès." . PHP_EOL;
    $adminFound = true;
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
            $stmt = $conn->prepare("INSERT INTO Employees (first_name, last_name, email, password, admin_id) VALUES (:firstName, :lastName, :email, :password, :adminId)");
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':adminId', 1, PDO::PARAM_INT);
            $stmt->execute();
            echo "Le compte employé pour $firstName $lastName a été créé avec succès." . PHP_EOL;
        } else {
            echo "Le compte employé pour $firstName $lastName existe déjà." . PHP_EOL;
        }
    }



        //VOITURES OCCASIONS
    try {
        // Sélectionnez toutes les voitures
        $stmt = $conn->prepare("SELECT * FROM vehicles");
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Vérifier si les voitures existent déjà
        $existingVehicles = array_column($vehicles, 'title');

        $vehicleData = array(
            array("Peugeot 308", "22500", "2020", "22800", "assets\img\1-peugeot-308.jpeg", "assets\img\1.2-peugeot-308.jpeg", ""),
            array("Citroen C3", "5990", "2012", "70000", "assets\img\2-citroen-c3.jpeg", "assets\img\2.2-citroen-c3.jpeg", ""),
            array("Mercedes AMG", "16200", "2014", "86500", "assets\img\3-mercedes-amg.jpeg", "assets\img\3.2-mercedes-amg.jpeg", ""),
            array("Clio 3", "3490", "2006", "143000", "assets\img\4-clio-3.jpeg", "assets\img\4.2-clio-3.jpeg", ""),
            array("Peugeot 5008", "22000", "2018", "126000", "assets\img\5 - peugeot 5008.jpeg", "assets\img\5.2 - peugeot 5008.jpeg", ""),
            array("Mini Cooper", "20990", "2019", "33703", "assets\img\6-mini-cooper.jpeg", "assets\img\6.2-mini-cooper.jpeg", "")
        );     
    
        foreach ($vehicleData as $data) {
            $carTitle = $data[0];
    
            if (in_array($carTitle, $existingVehicles)) {
                echo "Une voiture : $carTitle existe déjà avec les mêmes caractéristiques." . PHP_EOL;
            } else {
                $carPrice = $data[1];
                $carYear = $data[2];
                $carMileage = $data[3];
                $carImage = $data[4];
                $carImage1 = $data[5];
                $carImage2 = $data[6];
    
                $stmt = $conn->prepare("INSERT IGNORE INTO vehicles (title, price, year, mileage, image, image1, image2) VALUES (:carTitle, :carPrice, :carYear, :carMileage, :carImage, :carImage1, :carImage2)");
                $stmt->bindParam(':carTitle', $carTitle, PDO::PARAM_STR);
                $stmt->bindParam(':carPrice', $carPrice, PDO::PARAM_STR);
                $stmt->bindParam(':carYear', $carYear, PDO::PARAM_INT);
                $stmt->bindParam(':carMileage', $carMileage, PDO::PARAM_INT);
                $stmt->bindParam(':carImage', $carImage, PDO::PARAM_STR);
                $stmt->bindParam(':carImage1', $carImage1, PDO::PARAM_STR);
                $stmt->bindParam(':carImage2', $carImage2, PDO::PARAM_STR);
                $stmt->execute();
                echo "La voiture : $carTitle a été ajoutée avec succès." . PHP_EOL;
            }
        }
    
    } catch (PDOException $e) {
        // Enregistrement de l'erreur dans un fichier de log
        $errorLog = 'Erreur lors de l\'exécution de la requête ou de la récupération des voitures : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');
    }




    // HORAIRES

    try {
        // Vérifier si la table opening_hours est vide
        $stmt = $conn->query("SELECT COUNT(*) FROM opening_hours");
        if ($stmt->fetchColumn() == 0) {
            // Aucun enregistrement trouvé, définir les horaires par défaut
            $hourData = array(
                "8h45 - 12h00, 14h00 - 18h00",
                "8h45 - 12h00, 14h00 - 18h00",
                "8h45 - 12h00, 14h00 - 18h00",
                "8h45 - 12h00, 14h00 - 18h00",
                "8h45 - 12h00, 14h00 - 18h00",
                "8h45 - 12h00",
                "Fermé"
            );
    
            // Insérer les horaires par défaut dans la table opening_hours
            $stmt = $conn->prepare("INSERT INTO opening_hours (mon_hours, tue_hours, wed_hours, thu_hours, fri_hours, sat_hours, sun_hours) VALUES (:monHour, :tueHour, :wedHour, :thuHour, :friHour, :satHour, :sunHour)");
    
            $stmt->bindParam(':monHour', $hourData[0], PDO::PARAM_STR);
            $stmt->bindParam(':tueHour', $hourData[1], PDO::PARAM_STR);
            $stmt->bindParam(':wedHour', $hourData[2], PDO::PARAM_STR);
            $stmt->bindParam(':thuHour', $hourData[3], PDO::PARAM_STR);
            $stmt->bindParam(':friHour', $hourData[4], PDO::PARAM_STR);
            $stmt->bindParam(':satHour', $hourData[5], PDO::PARAM_STR);
            $stmt->bindParam(':sunHour', $hourData[6], PDO::PARAM_STR);
    
            $stmt->execute();
    
            echo "Les horaires par défaut ont été ajoutés avec succès." . PHP_EOL;
        }
    } catch (PDOException $e) {
        // Enregistrement de l'erreur dans un fichier de log
        $errorLog = 'Erreur lors de l\'exécution de la requête ou de la récupération des horaires : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');
    }




    // SERVICES

    try {
        // Vérifier si la table services est vide
        $stmt = $conn->query("SELECT COUNT(*) FROM services");
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Vérifier si les services existent déjà
        if ($count === 0) {
            $servicesData = array(
                array('Réparation carrosserie', 'assets/img/icone-repa-carrosserie1.png', 'Nous utilisons des techniques avancées et des équipements de pointe afin que votre véhicule retrouve son allure impeccable.'),
                array('Réparation mécanique', 'assets/img/icone-mecanique.png', 'Nous utilisons des pièces de qualité et suivons des normes strictes pour assurer des réparations durables et fiables, vous permettant de reprendre la route en toute confiance.'),
                array('Entretien régulier', 'assets/img/icone-entretien-regulier.png', 'Nous veillons à ce que votre véhicule soit maintenu dans un état optimal, ce qui contribue à prévenir les pannes coûteuses et à prolonger sa durée de vie.')
            );
    
            foreach ($servicesData as $data) {
                $serviceTitle = $data[0];
                $serviceImage = $data[1];
                $serviceDescription = $data[2];
    
                // Insérer les services par défaut dans la table services
                $stmt = $conn->prepare("INSERT INTO services (title, image, description) VALUES (:title, :image, :description)");
                $stmt->bindParam(':title', $serviceTitle, PDO::PARAM_STR);
                $stmt->bindParam(':image', $serviceImage, PDO::PARAM_STR);
                $stmt->bindParam(':description', $serviceDescription, PDO::PARAM_STR);
                $stmt->execute();
            }
    
            echo "Les services par défaut ont été ajoutés avec succès." . PHP_EOL;
        } else {
            echo "Les services existent déjà." . PHP_EOL;
        }
    } catch (PDOException $e) {
        // Enregistrement de l'erreur dans un fichier de log
        $errorLog = 'Erreur lors de l\'exécution de la requête ou de la récupération des services : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');
    }




    //REVIEWS
    try {
        // Vérifier si la table REVIEWS est vide
        $stmt = $conn->query("SELECT COUNT(*) FROM Reviews");
        $count = $stmt->fetchColumn();
    
        // Vérifier si les REVIEWS existent déjà
        if ($count === 0) {
            $reviewsData = [
                ['rating' => 5, 'comment' => 'Super accueil', 'reviewer_name' => 'Christophe', 'created_at' => '', 'approved' => 0],
                ['rating' => 4, 'comment' => 'Satisfait', 'reviewer_name' => 'Gerald', 'created_at' => '', 'approved' => 0],
                ['rating' => 5, 'comment' => 'Réparation rapide et employés très compétents', 'reviewer_name' => 'Claire', 'created_at' => '', 'approved' => 0]
            ];
    
            foreach ($reviewsData as $data) {
                $stmt = $conn->prepare("INSERT INTO Reviews (rating, comment, reviewer_name, created_at, approved) VALUES (:rating, :comment, :reviewer_name, :created_at, :approved)");
                $stmt->bindValue(':rating', $data['rating'], PDO::PARAM_INT);
                $stmt->bindValue(':comment', $data['comment'], PDO::PARAM_STR);
                $stmt->bindValue(':reviewer_name', $data['reviewer_name'], PDO::PARAM_STR);
                $stmt->bindValue(':created_at', $data['created_at'], PDO::PARAM_STR);
                $stmt->bindValue(':approved', $data['approved'], PDO::PARAM_BOOL);
                $stmt->execute();
            }
    
            echo "Les REVIEWS par défaut ont été ajoutées avec succès." . PHP_EOL;
        } else {
            echo "Les REVIEWS existent déjà." . PHP_EOL;
        }
    } catch (PDOException $e) {
        // Enregistrement de l'erreur dans un fichier de log
        $errorLog = 'Erreur lors de l\'exécution de la requête ou de la récupération des REVIEWS : ' . $e->getMessage() . PHP_EOL;
        error_log($errorLog, 3, 'erreurs.log');
    }
    
    

    


?>

