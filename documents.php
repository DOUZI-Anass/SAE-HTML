<?php
global $pdo;
session_start();
require_once 'config.php';

// 1. SÉCURITÉ : Accès réservé aux bénévoles connectés
if (!isset($_SESSION['id_benevole'])) {
    header('Location: connexion.php');
    exit();
}

require_once 'header.php';

// 2. TRAITEMENT DE L'UPLOAD (Réservé aux Admins)
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur') {

    if (isset($_FILES['fichier_doc']) && $_FILES['fichier_doc']['error'] == 0) {
        $titre = $_POST['titre'];
        $type = $_POST['type_doc'];

        // Dossier de destination (crée le dossier 'assets/pdf' s'il n'existe pas !)
        $dossier = 'assets/pdf/';
        $nom_fichier = time() . '_' . basename($_FILES['fichier_doc']['name']);

        // Autoriser seulement les PDF et Word
        $ext = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));
        if (in_array($ext, ['pdf', 'doc', 'docx'])) {
            if (move_uploaded_file($_FILES['fichier_doc']['tmp_name'], $dossier . $nom_fichier)) {

                // Insertion en BDD
                $sqlInsert = "INSERT INTO document (titre, type_doc, fichier, date_ajout) VALUES (:titre, :type, :fichier, NOW())";
                $stmt = $pdo->prepare($sqlInsert);
                $stmt->execute([
                        ':titre' => $titre,
                        ':type' => $type,
                        ':fichier' => $nom_fichier
                ]);
                $msg = "<div class='alert alert-success'>Document ajouté avec succès !</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Format non autorisé (PDF ou Word uniquement).</div>";
        }
    }
}
?>

    <main class="container py-5 mt-5">
        <h1 class="section-title">Espace Documentaire</h1>
        <p class="lead text-muted">Retrouvez ici tous les documents internes et comptes-rendus.</p>

        <?php echo $msg; ?>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'): ?>
            <div class="card p-4 mb-5 shadow-sm bg-light">
                <h4 class="mb-3 text-primary"><i class="fa-solid fa-cloud-arrow-up"></i> Ajouter un document</h4>
                <form method="post" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="titre" class="form-control" placeholder="Titre du document" required>
                    </div>
                    <div class="col-md-3">
                        <select name="type_doc" class="form-select">
                            <option value="Compte-Rendu">Compte-Rendu</option>
                            <option value="Administratif">Administratif</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="fichier_doc" class="form-control" required accept=".pdf,.doc,.docx">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-donner">Déposer le document</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="list-group shadow-sm">
            <?php
            $sql = "SELECT * FROM document ORDER BY date_ajout DESC";
            $stmt = $pdo->query($sql);

            while ($doc = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Icône selon le type
                $icon = 'fa-file';
                if (strpos($doc['fichier'], '.pdf') !== false) $icon = 'fa-file-pdf text-danger';
                elseif (strpos($doc['fichier'], '.doc') !== false) $icon = 'fa-file-word text-primary';
                ?>

                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-regular <?php echo $icon; ?> fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-1 fw-bold"><?php echo htmlspecialchars($doc['titre']); ?></h5>
                            <small class="text-muted">
                                <span class="badge bg-info text-dark"><?php echo htmlspecialchars($doc['type_doc']); ?></span>
                                Ajouté le <?php echo date('d/m/Y', strtotime($doc['date_ajout'])); ?>
                            </small>
                        </div>
                    </div>

                    <a href="assets/pdf/<?php echo htmlspecialchars($doc['fichier']); ?>"
                       class="btn btn-outline-primary btn-sm rounded-pill px-3"
                       download>
                        <i class="fa-solid fa-download"></i> Télécharger
                    </a>
                </div>

                <?php
            }
            ?>
        </div>
    </main>

<?php require_once 'footer.php'; ?>