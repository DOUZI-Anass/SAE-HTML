<?php
session_start();
require 'config.php';

// 1. Sécurité : Vérifier si c'est bien un admin
if (!isset($_SESSION['benevole']) || $_SESSION['benevole']['role'] !== 'administrateur') {
    header('Location: index.php');
    exit;
}

// 2. Vérifier si on a bien reçu les infos
if (isset($_GET['id_evenement'], $_GET['id_benevole'])) {
    $id_event = (int)$_GET['id_evenement'];
    $id_benevole = (int)$_GET['id_benevole'];

    try {
        // 3. Supprimer l'inscription dans la table de liaison 'inscrit'
        $stmt = $pdo->prepare("DELETE FROM inscrit WHERE id_evenement = ? AND id_benevole = ?");
        $stmt->execute([$id_event, $id_benevole]);

        // Message de succès
        $msg = "Désinscription effectuée avec succès.";
        header("Location: admin.php?type=success&message=" . urlencode($msg));
        exit;

    } catch (PDOException $e) {
        // Erreur SQL
        $msg = "Erreur lors de la désinscription : " . $e->getMessage();
        header("Location: admin.php?type=danger&message=" . urlencode($msg));
        exit;
    }
} else {
    // Si il manque des paramètres
    header("Location: admin.php?type=danger&message=Paramètres manquants.");
    exit;
}
