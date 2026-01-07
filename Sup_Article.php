<?php
global $pdo;
session_start();
require_once 'config.php';

// 1. SÉCURITÉ : Admin uniquement
if (!isset($_SESSION['benevole']['role']) ||
    ($_SESSION['benevole']['role'] !== 'administrateur' && $_SESSION['benevole']['role'] !== 'redacteur')) {
    header('Location: index.php');
    exit();
}

// 2. SUPPRESSION
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // On supprime l'article
    $req = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
    $req->execute([$id]);
}

// 3. RETOUR AUTOMATIQUE
header('Location: actualites.php');
exit();
?>