<?php
session_start();
require 'config.php';

// Sécurité admin
if (!isset($_SESSION['benevole']) || $_SESSION['benevole']['role'] !== 'administrateur') {
    header('Location: evenements.php');
    exit;
}

// On accepte uniquement le POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: evenements.php');
    exit;
}

// Récupération des données
$titre = trim($_POST['titre_evenement'] ?? '');
$date = $_POST['date_evenement'] ?? '';
$lieu = trim($_POST['lieu_evenement'] ?? '');
$description = trim($_POST['description_evenement'] ?? '');

// Vérification minimale
if ($titre === '' || $date === '') {
    header('Location: creation_event.php');
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO evenement (titre, description, date_evenement, lieu)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$titre, $description, $date, $lieu]);

} catch (PDOException $e) {
    // En prod on log, ici on redirige simplement
    header('Location: creation_event.php');
    exit;
}

// Redirection finale
header('Location: evenements.php');
exit;
