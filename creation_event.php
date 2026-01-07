<?php
session_start();
require 'config.php';

// Sécurité
if (!isset($_SESSION['benevole']) || $_SESSION['benevole']['role'] !== 'administrateur') {
    header('Location: evenements.php');
    exit;
}

require 'header.php';
?>

<div class="container py-5">
    <h2>Créer un événement</h2>

    <form method="POST" action="traitement_event.php">
        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="titre_evenement" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date_evenement" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Lieu</label>
            <input type="text" name="lieu_evenement" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description_evenement" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Créer l’événement</button>
    </form>
</div>

<?php require 'footer.php'; ?>
