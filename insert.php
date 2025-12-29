<?php
global $pdo;
session_start();
require 'config.php'; // Assurez-vous que la connexion PDO ($pdo) est incluse

// --- 1. Protection de la page (Seuls les administrateurs peuvent insérer) ---

// Redirige si non connecté
if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

// Redirige si ce n'est pas un administrateur
$role_utilisateur = $_SESSION['benevole']['role'] ?? 'bénévole';
if ($role_utilisateur !== 'administrateur') {
    header('Location: index.php');
    exit;
}

// Le traitement se fait uniquement via une méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin.php'); // Rediriger si accès direct
    exit;
}

$success_message = '';
$error_message = '';

// --- 2. Détection du type de formulaire soumis ---

// A. Traitement d'un NOUVEL ÉVÉNEMENT
if (
    isset(
        $_POST['titre_evenement'],
        $_POST['date_evenement'],
        $_POST['lieu_evenement'],
        $_POST['budget']
    )
) {
    $titre       = trim($_POST['titre_evenement']);
    $date        = $_POST['date_evenement'];
    $lieu        = trim($_POST['lieu_evenement']);
    $budget      = $_POST['budget'];
    $description = trim($_POST['description_evenement'] ?? '');

    if (
        $titre === '' ||
        $date === '' ||
        $lieu === '' ||
        !is_numeric($budget) ||
        $budget < 0
    ) {
        $error_message = "Erreur : tous les champs obligatoires ne sont pas valides.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO evenement (titre, date_evenement, lieu, budget, description)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$titre, $date, $lieu, $budget, $description]);

            $success_message = "L'événement « {$titre} » a été ajouté avec succès.";

        } catch (PDOException $e) {
            $error_message = "Erreur BDD lors de l'ajout de l'événement.";
            // en debug : $e->getMessage();
        }
    }
}

$id_evenement = $pdo->lastInsertId();

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
//




// B. Traitement d'un NOUVEAU MATÉRIEL (Basé sur le champ 'nom_materiel')
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



// --- 3. Redirection vers la page d'administration avec un message de succès/erreur ---

$redirect_url = 'admin.php';

if ($success_message) {
    $redirect_url .= '?message=' . urlencode($success_message) . '&type=success';
} elseif ($error_message) {
    $redirect_url .= '?message=' . urlencode($error_message) . '&type=error';
}

header('Location: ' . $redirect_url);
exit;
?>
