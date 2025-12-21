<?php
session_start();


if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}


$role_utilisateur = $_SESSION['benevole']['role'] ?? 'benevole';

if ($role_utilisateur !== 'administrateur') {
    header('Location: index.php');
    exit;
}


include 'header.php';

require 'config.php';

$materiels = $pdo->query("SELECT id_materiel, nom, qt_materiel FROM materiel ORDER BY nom")->fetchAll();

?>


<div class="container" style="margin-top: 120px;">
    <h1>Espace Administration</h1>

    <?php if (isset($_GET['message'], $_GET['type'])): ?>

        <div class="alert alert-<?= $_GET['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mt-4" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    <?php endif; ?>

    <p class="lead mb-5">Bienvenue jeune Fage! Vous pouvez gérer le contenu ici.</p>

    <div class="row">


        <div class="col-md-6 mb-5">
            <h2>Ajouter du Matériel</h2>
            <form method="post" action="insert.php">
                <div class="mb-3">
                    <label class="form-label">Nom du Matériel</label>
                    <input type="text" name="nom_materiel" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantité</label>
                    <input type="number" name="quantite_materiel" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description_materiel" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Ajouter Matériel</button>
            </form>
        </div>


        <div class="col-md-6 mb-5">
            <h2>Ajouter un Événement</h2>
            <form method="post" action="insert.php">

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre_evenement" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date_evenement" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lieu</label>
                    <input type="text" name="lieu_evenement" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Budget (€)</label>
                    <input type="number" name="budget" class="form-control" min="0" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description_evenement" class="form-control" rows="3"></textarea>
                </div>

                <h4 class="mt-4">Matériel utilisé</h4>

                <?php if (empty($materiels)): ?>
                    <div class="alert alert-warning mb-0">
                        Aucun matériel disponible. Ajoute du matériel avant de créer un événement.
                    </div>
                <?php else: ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sélectionner le matériel</label>

                        <div class="materiel-picker shadow-sm">
                            <select name="materiels[]" class="form-select materiel-select" multiple size="8">
                                <?php foreach ($materiels as $m): ?>
                                    <option value="<?= (int)$m['id_materiel'] ?>">
                                        <?= htmlspecialchars($m['nom']) ?> — dispo : <?= (int)$m['qt_materiel'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-text">
                            Maintiens <strong>Ctrl</strong> (Windows) / <strong>Cmd</strong> (Mac) pour sélectionner plusieurs matériels.
                        </div>
                    </div>

                <?php endif; ?>




                <button type="submit" class="btn btn-primary">Ajouter Événement</button>
            </form>

        </div>


    </div>
</div>

<?php include 'footer.php'; ?>
