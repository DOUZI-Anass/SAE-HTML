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

// --- REQUÊTES POUR LES STATISTIQUES ---
$nb_benevoles = $pdo->query("SELECT COUNT(*) FROM benevole WHERE role != 'administrateur'")->fetchColumn();
$nb_events = $pdo->query("SELECT COUNT(*) FROM evenement")->fetchColumn();
$nb_inscriptions = $pdo->query("SELECT COUNT(*) FROM inscrit")->fetchColumn();
$budget_total = $pdo->query("SELECT SUM(budget) FROM evenement")->fetchColumn();

// --- REQUÊTES DONNÉES ---
$materiels = $pdo->query("SELECT id_materiel, nom, qt_materiel FROM materiel ORDER BY nom")->fetchAll();

$sql_inscrits = "
    SELECT e.id_evenement, e.titre AS titre_event, e.date_evenement,
           b.id_benevole, b.nom, b.prenom, b.email
    FROM inscrit i
    JOIN evenement e ON i.id_evenement = e.id_evenement
    JOIN benevole b ON i.id_benevole = b.id_benevole
    ORDER BY e.date_evenement DESC, e.titre, b.nom
";
$inscrits = $pdo->query($sql_inscrits)->fetchAll();
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

    <div class="container" style="margin-top: 120px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tableau de Bord & Administration</h1>
            <button id="btn-download-pdf" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Télécharger liste Inscrits (.pdf)
            </button>
        </div>

        <div class="row mb-5">
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">Vue d'ensemble de l'activité</div>
                    <div class="card-body">
                        <canvas id="monGraphique"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card text-white bg-primary shadow-sm">
                            <div class="card-body text-center">
                                <h3><?= $nb_benevoles ?></h3>
                                <p class="mb-0">Bénévoles Actifs</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card text-white bg-success shadow-sm">
                            <div class="card-body text-center">
                                <h3><?= $nb_events ?></h3>
                                <p class="mb-0">Événements Créés</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card text-white bg-warning shadow-sm">
                            <div class="card-body text-center">
                                <h3 class="text-dark"><?= $nb_inscriptions ?></h3>
                                <p class="mb-0 text-dark">Participations Totales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card text-white bg-danger shadow-sm">
                            <div class="card-body text-center">
                                <h3><?= number_format($budget_total ?? 0, 0, ',', ' ') ?> €</h3>
                                <p class="mb-0">Budget Engagé</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <?php if (isset($_GET['message'], $_GET['type'])): ?>
            <div class="alert alert-<?= $_GET['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="mb-3">Ajouter du Matériel</h4>
                    <form method="post" action="insert.php">
                        <div class="mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom_materiel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Quantité</label>
                            <input type="number" name="quantite_materiel" class="form-control" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Ajouter</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="mb-3">Ajouter un Événement</h4>
                    <form method="post" action="insert.php">
                        <div class="mb-3">
                            <label>Titre</label>
                            <input type="text" name="titre_evenement" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label>Date</label>
                                <input type="date" name="date_evenement" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Budget (€)</label>
                                <input type="number" name="budget" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Lieu</label>
                            <input type="text" name="lieu_evenement" class="form-control" required>
                        </div>

                        <?php if (!empty($materiels)): ?>
                            <div class="mb-3 border p-2 rounded" style="max-height:100px; overflow-y:auto;">
                                <label class="form-label small fw-bold">Matériel nécessaire :</label>
                                <?php foreach ($materiels as $m): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="materiels[]" value="<?= $m['id_materiel'] ?>">
                                        <label class="form-check-label small"><?= htmlspecialchars($m['nom']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-primary w-100">Créer l'Événement</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h3>Dernières Inscriptions</h3>
                <?php if (empty($inscrits)): ?>
                    <div class="alert alert-info">Aucune inscription.</div>
                <?php else: ?>
                    <table id="table-inscrits" class="table table-striped mt-3">
                        <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Événement</th>
                            <th>Bénévole</th>
                            <th>Email</th>
                            <th>Action</th> </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($inscrits as $row): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($row['date_evenement'])) ?></td>
                                <td><?= htmlspecialchars($row['titre_event']) ?></td>
                                <td><?= htmlspecialchars($row['nom'] . ' ' . $row['prenom']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td>
                                    <a href="desinscription.php?id_evenement=<?= $row['id_evenement'] ?>&id_benevole=<?= $row['id_benevole'] ?>"
                                       class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirmer ?')">X</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // --- 1. SCRIPT POUR LE GRAPHIQUE (Chart.js) ---
        const ctx = document.getElementById('monGraphique').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Bénévoles', 'Événements', 'Inscriptions'],
                datasets: [{
                    label: 'Données actuelles',
                    data: [<?= $nb_benevoles ?>, <?= $nb_events ?>, <?= $nb_inscriptions ?>],
                    backgroundColor: ['#36a2eb', '#4bc0c0', '#ffcd56'],
                    borderWidth: 1
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        // --- 2. SCRIPT POUR LE PDF (jsPDF) ---
        document.getElementById('btn-download-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Titre du PDF
            doc.text("Liste des Inscriptions - FAGE", 14, 20);

            // Génération du tableau automatique
            doc.autoTable({
                html: '#table-inscrits', // On cible notre tableau HTML
                startY: 30,              // On commence un peu plus bas
                columns: [0, 1, 2, 3],   // ON GARDE UNIQUEMENT LES COLONNES 0, 1, 2 et 3 (On exclut la colonne Action)
                theme: 'grid'
            });

            // Sauvegarde du fichier
            doc.save('liste_inscriptions.pdf');
        });
    </script>

<?php include 'footer.php'; ?>