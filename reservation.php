<?php
// Configuration de la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "kalaa";

// Connexion
$connection = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($connection->connect_error) {
    die("Erreur de connexion : " . $connection->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération et sécurisation des données
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $select = isset($_POST["select"]) ? trim($_POST["select"]) : '';
    $date = isset($_POST["date"]) ? trim($_POST["date"]) : '';
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : '';

    // Validation
    $errors = array();

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse e-mail invalide.";
    }
    if (empty($name)) {
        $errors[] = "Nom requis.";
    }
    if (empty($select)) {
        $errors[] = "Veuillez sélectionner un service.";
    }
    if (empty($date)) {
        $errors[] = "Date requise.";
    }
    if (empty($phone)) {
        $errors[] = "Téléphone requis.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    // Préparation de la requête
$stmt = $connection->prepare("INSERT INTO resrevation (email, name, `select`, date, phone, message) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Erreur de préparation : " . $connection->error);
    }

    $stmt->bind_param("ssssss", $email, $name, $select, $date, $phone, $message);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Réservation envoyée avec succès !</p>";
        // header("Location: merci.html"); // Décommente si tu veux rediriger
        // exit;
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    echo "Méthode non autorisée.";
}
?>
