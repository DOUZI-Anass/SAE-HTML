<?php
session_start();
require 'config.php';

// 1) Sécurité : connecté ?
if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

// 2) POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: mon_compte.php');
    exit;
}

$id_benevole = (int)$_SESSION['benevole']['id_benevole'];

$mdp_actuel       = $_POST['mdp_actuel'] ?? '';
$mdp_nouveau      = $_POST['mdp_nouveau'] ?? '';
$mdp_confirmation = $_POST['mdp_confirmation'] ?? '';

function redirect_msg(string $msg, string $type = 'error'): void {
    header('Location: mon_compte.php?message=' . urlencode($msg) . '&type=' . urlencode($type));
    exit;
}

// 3) Validations
if ($mdp_nouveau !== $mdp_confirmation) {
    redirect_msg("La confirmation ne correspond pas.", "error");
}

if (strlen($mdp_nouveau) < 8) {
    redirect_msg("Le nouveau mot de passe doit contenir au moins 8 caractères.", "error");
}

try {
    // 4) Récupérer le hash actuel en base
    $stmt = $pdo->prepare("SELECT mdp FROM benevole WHERE id_benevole = ?");
    $stmt->execute([$id_benevole]);
    $row = $stmt->fetch();

    if (!$row) {
        redirect_msg("Compte introuvable.", "error");
    }

    $hash_actuel = $row['mdp'];

    // 5) Vérifier l'ancien mot de passe
    if (!password_verify($mdp_actuel, $hash_actuel)) {
        redirect_msg("Mot de passe actuel incorrect.", "error");
    }

    // 6) Empêcher de remettre le même mot de passe (optionnel mais bien)
    if (password_verify($mdp_nouveau, $hash_actuel)) {
        redirect_msg("Le nouveau mot de passe doit être différent de l'ancien.", "error");
    }

    // 7) Mettre à jour avec un nouveau hash
    $nouveau_hash = password_hash($mdp_nouveau, PASSWORD_DEFAULT);

    $upd = $pdo->prepare("UPDATE benevole SET mdp = ? WHERE id_benevole = ?");
    $upd->execute([$nouveau_hash, $id_benevole]);

    redirect_msg("Mot de passe mis à jour avec succès ✅", "success");

} catch (PDOException $e) {
    redirect_msg("Erreur BDD lors de la mise à jour du mot de passe.", "error");
}
