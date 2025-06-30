<?php
// Configuration de la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "kalaa";

// Connexion à la base de données
$connection = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($connection->connect_error) {
    die("Erreur de connexion : " . $connection->connect_error);
}

// Vérification que le formulaire est bien soumis en POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération et nettoyage des données
    $prenom   = isset($_POST["name"])    ? trim($_POST["name"]) : '';
    $nom      = isset($_POST["name1"])   ? trim($_POST["name1"]) : '';
    $adresse  = isset($_POST["adresse"]) ? trim($_POST["adresse"]) : '';
    $telephone= isset($_POST["phone"])   ? trim($_POST["phone"]) : '';
    $email    = isset($_POST["email"])   ? trim($_POST["email"]) : '';
    $notes    = isset($_POST["message"]) ? trim($_POST["message"]) : '';

    // Validation des champs
    $errors = [];

    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }
    if (empty($nom)) {
        $errors[] = "Le nom de famille est requis.";
    }
    if (empty($telephone)) {
        $errors[] = "Le numéro de téléphone est requis.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Une adresse e-mail valide est requise.";
    }

    // Affichage des erreurs si nécessaire
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    // Préparation de la requête d'insertion
    $stmt = $connection->prepare("INSERT INTO inscrit (name, name1, adresse, phone, email, Ordernotes) VALUES (?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("<p style='color:red;'>Erreur de préparation : " . $connection->error . "</p>");
    }

    // Liaison des paramètres
    $stmt->bind_param("ssssss", $prenom, $nom, $adresse, $telephone, $email, $notes);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Inscription réussie !</p>";
        // Redirection possible : header("Location: merci.html"); exit;
    } else {
        echo "<p style='color:red;'>Erreur lors de l'enregistrement : " . $stmt->error . "</p>";
    }

    // Fermeture
    $stmt->close();
    $connection->close();

} else {
    echo "<p style='color:red;'>Méthode non autorisée.</p>";
}
?>
