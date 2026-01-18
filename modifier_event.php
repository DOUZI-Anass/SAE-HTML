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

if (!isset($_GET['id'])) {
    header('Location: evenements.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT * FROM evenement WHERE id_evenement = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    header('Location: evenements.php');
    exit;
}
?>

<?php require 'header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Modifier l’événement</h2>

    <form method="POST" action="modifier_event_traitement.php">

        <input type="hidden" name="id_evenement" value="<?= $event['id_evenement'] ?>">

        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control"
                   value="<?= htmlspecialchars($event['titre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date_evenement" class="form-control"
                   value="<?= $event['date_evenement'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Lieu</label>
            <input type="text" name="lieu" class="form-control"
                   value="<?= htmlspecialchars($event['lieu']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save"></i> Enregistrer
        </button>

        <a href="evenements.php" class="btn btn-secondary">Annuler</a>

    </form>
</div>

<?php require 'footer.php'; ?>
