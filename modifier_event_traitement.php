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

if (
    !isset($_POST['id_evenement'], $_POST['titre'], $_POST['date_evenement'], $_POST['lieu'], $_POST['description'])
) {
    header('Location: evenements.php');
    exit;
}

$stmt = $pdo->prepare("
    UPDATE evenement
    SET titre = ?, date_evenement = ?, lieu = ?, description = ?
    WHERE id_evenement = ?
");

$stmt->execute([
    $_POST['titre'],
    $_POST['date_evenement'],
    $_POST['lieu'],
    $_POST['description'],
    $_POST['id_evenement']
]);

header('Location: evenements.php');
exit;
