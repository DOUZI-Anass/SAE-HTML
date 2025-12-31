<?php
session_start();
require 'config.php';

if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id_evenement'])) {
    header('Location: mon_compte.php');
    exit;
}

$id_evenement = (int) $_POST['id_evenement'];
$id_benevole  = (int) $_SESSION['benevole']['id_benevole'];

try {
    $stmt = $pdo->prepare("
        DELETE FROM inscrit
        WHERE id_evenement = ? AND id_benevole = ?
    ");
    $stmt->execute([$id_evenement, $id_benevole]);

    header('Location: mon_compte.php?message=' . urlencode("Désinscription effectuée.") . '&type=success');
    exit;

} catch (PDOException $e) {
    header('Location: mon_compte.php?message=' . urlencode("Erreur BDD lors de la désinscription.") . '&type=error');
    exit;
}
