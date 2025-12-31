<?php
require 'header.php';
require 'config.php';

if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

$id_benevole = (int) $_SESSION['benevole']['id_benevole'];

// Récupérer les événements où le bénévole est inscrit
$stmt = $pdo->prepare("
    SELECT e.id_evenement, e.titre, e.date_evenement, e.lieu, e.budget, e.description,
           i.date_inscription
    FROM inscrit i
    JOIN evenement e ON e.id_evenement = i.id_evenement
    WHERE i.id_benevole = ?
    ORDER BY e.date_evenement ASC
");
$stmt->execute([$id_benevole]);
$evenements = $stmt->fetchAll();
?>

<div class="container" style="margin-top:120px;">
    <h1 class="mb-3">Mon espace bénévole</h1>

    <?php if (isset($_GET['message'], $_GET['type'])): ?>
        <div class="alert alert-<?= $_GET['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <p class="text-muted">
        Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['benevole']['prenom'] . ' ' . $_SESSION['benevole']['nom']) ?></strong>
        (<?= htmlspecialchars($_SESSION['benevole']['email']) ?>)
    </p>


    <h3 class="mt-5">Modifier mon mot de passe</h3>

    <form method="post" action="modifier_mdp.php" class="mt-3" style="max-width: 520px;">
        <div class="mb-3">
            <label class="form-label">Mot de passe actuel</label>
            <input type="password" name="mdp_actuel" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="mdp_nouveau" class="form-control" required minlength="8">
            <div class="form-text">8 caractères minimum recommandé.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" name="mdp_confirmation" class="form-control" required minlength="8">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>



    <h3 class="mt-4">Mes événements</h3>

    <?php if (empty($evenements)): ?>
        <div class="alert alert-info mt-3">
            Vous n’êtes inscrit à aucun événement pour le moment.
        </div>
    <?php else: ?>
        <div class="list-group mt-3">
            <?php foreach ($evenements as $e): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="me-3">
                            <h5 class="mb-1"><?= htmlspecialchars($e['titre']) ?></h5>
                            <div class="small text-muted">
                                📅 <?= htmlspecialchars($e['date_evenement']) ?>
                                · 📍 <?= htmlspecialchars($e['lieu']) ?>
                                · 💶 <?= htmlspecialchars($e['budget']) ?> €
                                · Inscrit le : <?= htmlspecialchars($e['date_inscription'] ?? '-') ?>
                            </div>
                            <?php if (!empty($e['description'])): ?>
                                <p class="mb-1 mt-2"><?= nl2br(htmlspecialchars($e['description'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <form method="post" action="desinscription_evenement.php" onsubmit="return confirm('Se désinscrire de cet événement ?');">
                            <input type="hidden" name="id_evenement" value="<?= (int)$e['id_evenement'] ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Se désinscrire
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<br><br>
<?php require 'footer.php'; ?>
