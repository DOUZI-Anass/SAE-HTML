<?php
// 1. GESTION PROPRE DE LA SESSION (Évite la Notice)
global $pdo;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. CONFIGURATION & SÉCURITÉ
require 'config.php';

// Protection : Seuls les administrateurs
if (!isset($_SESSION['benevole']) || $_SESSION['benevole']['role'] !== 'administrateur') {
    header('Location: index.php');
    exit;
}

// Protection : Uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php');
    exit;
}

$success_message = '';
$error_message = '';

// --- 3. TRAITEMENT DU FORMULAIRE ---

// A. CAS : NOUVEL ÉVÉNEMENT
if (isset($_POST['titre_evenement'])) {

    // On utilise ?? pour éviter les Warnings "Undefined array key"
    $titre       = trim($_POST['titre_evenement'] ?? '');
    $date        = $_POST['date_evenement'] ?? '';
    $lieu        = trim($_POST['lieu_evenement'] ?? '');

    // SOLUTION FATAL ERROR : Si le budget est vide, on force à 0
    $budget_raw  = $_POST['budget'] ?? '';
    $budget      = ($budget_raw !== '' && is_numeric($budget_raw)) ? (float)$budget_raw : 0;

    $description = trim($_POST['description_evenement'] ?? '');

    if ($titre === '' || $date === '') {
        $error_message = "Erreur : Le titre et la date sont obligatoires.";
    } else {
        try {
            $pdo->beginTransaction();

            // Insertion de l'événement (Vérifie bien tes noms de colonnes : lieu, budget, description)
            $stmt = $pdo->prepare("
                INSERT INTO evenement (titre, date_evenement, lieu, budget, description)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$titre, $date, $lieu, $budget, $description]);

            $id_evenement = $pdo->lastInsertId();

            // Insertion du matériel (Table de liaison 'utilise')
            if (!empty($_POST['materiels']) && is_array($_POST['materiels'])) {
                $stmtUtilise = $pdo->prepare("INSERT INTO utilise (id_evenement, id_materiel, quantite) VALUES (?, ?, ?)");
                foreach ($_POST['materiels'] as $id_materiel) {
                    $id_materiel = (int)$id_materiel;
                    if ($id_materiel > 0) {
                        $stmtUtilise->execute([$id_evenement, $id_materiel, 1]);
                    }
                }
            }

            $pdo->commit();
            $success_message = "L'événement « {$titre} » a été ajouté avec succès.";

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_message = "Erreur BDD : " . $e->getMessage();
        }
    }
}

// B. CAS : NOUVEAU MATÉRIEL
elseif (isset($_POST['nom_materiel'])) {
    $nom      = trim($_POST['nom_materiel'] ?? '');
    $quantite = (int)($_POST['quantite_materiel'] ?? 0);

    if ($nom === '') {
        $error_message = "Erreur : Le nom du matériel est obligatoire.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO materiel (nom, qt_materiel) VALUES (?, ?)");
            $stmt->execute([$nom, $quantite]);
            $success_message = "Le matériel '{$nom}' a été ajouté !";
        } catch (PDOException $e) {
            $error_message = "Erreur BDD matériel : " . $e->getMessage();
        }
    }
}

// --- 4. REDIRECTION FINALE ---
$redirect_url = 'admin.php';
if ($success_message) {
    $redirect_url .= '?message=' . urlencode($success_message) . '&type=success';
} elseif ($error_message) {
    $redirect_url .= '?message=' . urlencode($error_message) . '&type=danger';
}

header('Location: ' . $redirect_url);
exit;