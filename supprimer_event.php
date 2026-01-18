<?php
global $pdo;
session_start();
require 'config.php';

if (
    !isset($_SESSION['benevole']) ||
    $_SESSION['benevole']['role'] !== 'administrateur'
) {
    header('Location: evenements.php');
    exit;
}

if (!isset($_POST['id_evenement'])) {
    header('Location: evenements.php');
    exit;
}

$id = intval($_POST['id_evenement']);

try {
    // Supprimer d'abord les inscriptions liées
    $stmt = $pdo->prepare("DELETE FROM inscrit WHERE id_evenement = ?");
    $stmt->execute([$id]);

    // Supprimer l'événement
    $stmt = $pdo->prepare("DELETE FROM evenement WHERE id_evenement = ?");
    $stmt->execute([$id]);

} catch (PDOException $e) {
    die("Erreur lors de la suppression");
}

header('Location: evenements.php');
exit;
