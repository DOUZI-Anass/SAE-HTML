<?php
session_start();
require 'config.php';

// 1. Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['benevole'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non connecté']);
    exit;
}

// 2. Vérifier les données reçues
if (!isset($_POST['id_evenement'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Événement manquant']);
    exit;
}

$id_evenement = (int) $_POST['id_evenement'];
$id_benevole  = (int) $_SESSION['benevole']['id_benevole'];

try {
    // 3. Éviter double inscription
    $check = $pdo->prepare("
        SELECT 1 FROM inscrit
        WHERE id_evenement = ? AND id_benevole = ?
    ");
    $check->execute([$id_evenement, $id_benevole]);

    if ($check->fetch()) {
        echo json_encode(['error' => 'Déjà inscrit']);
        exit;
    }

    // 4. Inscription
    $stmt = $pdo->prepare("
        INSERT INTO inscrit (id_evenement, id_benevole, date_inscription)
        VALUES (?, ?, CURDATE())
    ");
    $stmt->execute([$id_evenement, $id_benevole]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur BDD']);
}
