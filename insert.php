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

// A. Traitement d'un NOUVEL ÉVÉNEMENT (Basé sur le champ 'titre_evenement')
if (isset($_POST['titre_evenement'])) {
    $titre       = trim($_POST['titre_evenement']);
    $date        = $_POST['date_evenement'];
    $lieu        = trim($_POST['lieu_evenement']);
    $description = trim($_POST['description_evenement']);

    if ($titre === '' || $date === '') {
        $error_message = "Erreur : Le titre et la date de l'événement sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO evenement (titre, description, date_evenement, lieu)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$titre, $description, $date, $lieu]);
            $success_message = "L'événement '{$titre}' a été ajouté avec succès !";

        } catch (PDOException $e) {
            $error_message = "Erreur BDD lors de l'ajout de l'événement.";
            // En mode debug, vous pouvez afficher $e->getMessage();
        }
    }
}

// B. Traitement d'un NOUVEAU MATÉRIEL (Basé sur le champ 'nom_materiel')
elseif (isset($_POST['nom_materiel'])) {
    $nom         = trim($_POST['nom_materiel']);
    $quantite    = (int)$_POST['quantite_materiel'];
    $description = trim($_POST['description_materiel']);

    if ($nom === '' || $quantite < 0) {
        $error_message = "Erreur : Le nom du matériel et la quantité sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO materiel (nom, description, quantite_disponible)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$nom, $description, $quantite]);
            $success_message = "Le matériel '{$nom}' a été ajouté avec succès !";

        } catch (PDOException $e) {
            $error_message = "Erreur BDD lors de l'ajout du matériel.";
            // En mode debug, vous pouvez afficher $e->getMessage();
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