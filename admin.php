<?php
// --- 1. ACTIVATION DES ERREURS (POUR NE PLUS AVOIR DE PAGE BLANCHE) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ----------------------------------------------------------------------

session_start();

// 2. CONFIGURATION & SÉCURITÉ
require 'config.php'; // On charge la BDD ($pdo)

// Vérification de sécurité : Est-on connecté ?
if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

// Vérification de sécurité : Est-on administrateur ?
$role_utilisateur = $_SESSION['benevole']['role'] ?? 'benevole';
if ($role_utilisateur !== 'administrateur') {
    header('Location: index.php');
    exit;
}

// 3. HEADER
include 'header.php';

// 4. RÉCUPÉRATION DES DONNÉES (AVEC SÉCURITÉ)
try {
    // On force (int) pour éviter les erreurs si la base est vide
    $nb_benevoles = (int) $pdo->query("SELECT COUNT(*) FROM benevole WHERE role != 'administrateur'")->fetchColumn();
    $nb_events    = (int) $pdo->query("SELECT COUNT(*) FROM evenement")->fetchColumn();
    $nb_inscriptions = (int) $pdo->query("SELECT COUNT(*) FROM inscrit")->fetchColumn();
    $budget_total = (float) $pdo->query("SELECT SUM(budget) FROM evenement")->fetchColumn();

    // Listes
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

} catch (PDOException $e) {
    // Si une requête SQL plante, on affiche l'erreur proprement
    echo "<div class='alert alert-danger'>Erreur SQL : " . htmlspecialchars($e->getMessage()) . "</div>";
    // On met des valeurs par défaut pour que la page s'affiche quand même
    $nb_benevoles = 0; $nb_events = 0; $nb_inscriptions = 0; $budget_total = 0;
    $materiels = []; $inscrits = [];
}
?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

    <div class="container" style="margin-top: 120px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tableau de Bord & Administration</h1>
            <button id="btn-download-pdf" class="btn btn-danger" <?= empty($inscrits) ? 'disabled' : '' ?>>
                <i class="fa-solid fa-file-pdf"></i> Télécharger liste Inscrits (.pdf)
            </button>
        </div>

        <div class="row mb-5">
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white fw-bold">Vue d'ensemble</div>
                    <div class="card-body">
                        <canvas id="monGraphique"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row g-3">
                    <div class="col-12"><div class="card text-white bg-primary p-3 text-center"><h3><?= $nb_benevoles ?></h3><p>Bénévoles</p></div></div>
                    <div class="col-12"><div class="card text-white bg-success p-3 text-center"><h3><?= $nb_events ?></h3><p>Événements</p></div></div>
                    <div class="col-12"><div class="card text-white bg-warning p-3 text-center"><h3 class="text-dark"><?= $nb_inscriptions ?></h3><p class="text-dark">Participations</p></div></div>
                    <div class="col-12"><div class="card text-white bg-danger p-3 text-center"><h3><?= number_format($budget_total, 0, ',', ' ') ?> €</h3><p>Budget</p></div></div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info alert-dismissible fade show">
                <?= htmlspecialchars($_GET['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="card p-4 h-100 shadow-sm">
                    <h4>Ajouter du Matériel</h4>
                    <form method="post" action="insert.php">
                        <input type="hidden" name="type_form" value="materiel">
                        <div class="mb-3"><label>Nom</label><input type="text" name="nom_materiel" class="form-control" required></div>
                        <div class="mb-3"><label>Quantité</label><input type="number" name="quantite_materiel" class="form-control" required></div>
                        <button type="submit" class="btn btn-success w-100">Ajouter</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="card p-4 h-100 shadow-sm">
                    <h4>Ajouter un Événement</h4>
                    <form method="post" action="insert.php">
                        <input type="hidden" name="type_form" value="evenement">
                        <div class="mb-3"><label>Titre</label><input type="text" name="titre_evenement" class="form-control" required></div>
                        <div class="row">
                            <div class="col-6 mb-3"><label>Date</label><input type="date" name="date_evenement" class="form-control" required></div>
                            <div class="col-6 mb-3"><label>Budget (€)</label><input type="number" name="budget" class="form-control" required></div>
                        </div>
                        <div class="mb-3"><label>Lieu</label><input type="text" name="lieu_evenement" class="form-control" required></div>

                        <?php if (!empty($materiels)): ?>
                            <div class="mb-3 border p-2 rounded" style="max-height:100px; overflow-y:auto;">
                                <label class="small fw-bold">Matériel nécessaire :</label>
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
                    <div class="alert alert-light border">Aucune inscription enregistrée.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="table-inscrits" class="table table-striped mt-3">
                            <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Événement</th>
                                <th>Bénévole</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
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
                                           class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette inscription ?')">X</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. GRAPHIQUE ---
            const ctx = document.getElementById('monGraphique');
            if (ctx) {
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Bénévoles', 'Événements', 'Inscriptions'],
                        datasets: [{
                            label: 'Statistiques',
                            data: [<?= $nb_benevoles ?>, <?= $nb_events ?>, <?= $nb_inscriptions ?>],
                            backgroundColor: ['#0099cc', '#28a745', '#ffc107'], // Couleurs FAGE
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            // --- 2. PDF ---
            const btnPdf = document.getElementById('btn-download-pdf');
            if (btnPdf) {
                btnPdf.addEventListener('click', function () {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();
                    const table = document.getElementById('table-inscrits');

                    if (!table) { alert("Rien à imprimer !"); return; }

                    doc.text("FAGE - Liste des Inscriptions", 14, 20);
                    doc.autoTable({
                        html: '#table-inscrits',
                        startY: 30,
                        theme: 'grid',
                        columns: [
                            { header: 'Date', dataKey: 0 },
                            { header: 'Événement', dataKey: 1 },
                            { header: 'Bénévole', dataKey: 2 },
                            { header: 'Email', dataKey: 3 }
                        ]
                    });
                    doc.save('liste_inscriptions.pdf');
                });
            }
        });
    </script>

<?php include 'footer.php'; ?>