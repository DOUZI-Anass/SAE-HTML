<?php
global $pdo;
session_start();
require 'config.php'; // Assurez-vous que la connexion PDO ($pdo) est incluse

// --- 1. Protection de la page (Seuls les administrateurs peuvent insérer) ---
if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

$role_utilisateur = $_SESSION['benevole']['role'] ?? 'bénévole';
if ($role_utilisateur !== 'administrateur') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php');
    exit;
}

$success_message = '';
$error_message = '';

// --- 2. Détection du type de formulaire soumis ---

// A. Traitement d'un NOUVEL ÉVÉNEMENT
if (isset($_POST['titre_evenement'], $_POST['date_evenement'], $_POST['lieu_evenement'], $_POST['budget'])) {
    $titre       = trim($_POST['titre_evenement']);
    $date        = $_POST['date_evenement'];
    $lieu        = trim($_POST['lieu_evenement']);
    $budget      = $_POST['budget'];
    $description = trim($_POST['description_evenement'] ?? '');

    if ($titre === '' || $date === '' || $lieu === '' || !is_numeric($budget) || $budget < 0) {
        $error_message = "Erreur : tous les champs obligatoires ne sont pas valides.";
    } else {
        try {
            // Insertion de l'événement
            $stmt = $pdo->prepare("
                INSERT INTO evenement (titre, date_evenement, lieu, budget, description)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$titre, $date, $lieu, $budget, $description]);

            // RÉCUPÉRATION DE L'ID IMMÉDIATEMENT APRÈS L'INSERTION
            $id_evenement = $pdo->lastInsertId();

            // INSERTION DU MATÉRIEL (DOIT ÊTRE DANS CE BLOC)
            if (!empty($_POST['materiels']) && is_array($_POST['materiels'])) {
                $stmtUtilise = $pdo->prepare("
                    INSERT INTO utilise (id_evenement, id_materiel, quantite)
                    VALUES (?, ?, ?)
                ");

                foreach ($_POST['materiels'] as $id_materiel) {
                    $id_materiel = (int)$id_materiel;
                    if ($id_materiel > 0) {
                        $stmtUtilise->execute([$id_evenement, $id_materiel, 1]); // quantite fixée à 1
                    }
                }
            }

            $success_message = "L'événement « {$titre} » a été ajouté avec succès.";

        } catch (PDOException $e) {
            $error_message = "Erreur BDD lors de l'ajout de l'événement : " . $e->getMessage();
        }
    }
}
// B. Traitement d'un NOUVEAU MATÉRIEL
elseif (isset($_POST['nom_materiel'])) {
    $nom      = trim($_POST['nom_materiel'] ?? '');
    $quantite = (int)($_POST['quantite_materiel'] ?? -1);

    if ($nom === '' || $quantite < 0) {
        $error_message = "Erreur : Le nom du matériel et la quantité sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO materiel (nom, qt_materiel) VALUES (?, ?)");
            $stmt->execute([$nom, $quantite]);

            $success_message = "Le matériel '{$nom}' a été ajouté avec succès !";
        } catch (PDOException $e) {
            $error_message = "Erreur BDD lors de l'ajout du matériel : " . $e->getMessage();
        }
    }
}

// --- 3. Redirection avec message ---
$redirect_url = 'admin.php';
if ($success_message) {
    $redirect_url .= '?message=' . urlencode($success_message) . '&type=success';
} elseif ($error_message) {
    $redirect_url .= '?message=' . urlencode($error_message) . '&type=error'; // Changé 'danger' en 'error' pour correspondre à tes variables
}

session_start();
require 'config.php';

// Sécurité admin
if (!isset($_SESSION['benevole']) || $_SESSION['benevole']['role'] !== 'administrateur') {
    header('Location: evenements.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: evenements.php');
    exit;
}

$titre = trim($_POST['titre_evenement']);
$date = $_POST['date_evenement'];
$lieu = trim($_POST['lieu_evenement']);
$description = trim($_POST['description_evenement']);

$stmt = $pdo->prepare("
    INSERT INTO evenement (titre, description, date_evenement, lieu)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([$titre, $description, $date, $lieu]);

header('Location: evenements.php');
exit;


header('Location: ' . $redirect_url);
exit;
?>