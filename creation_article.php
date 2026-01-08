<?php
// 1. D'ABORD LE PHP (AVANT TOUT HTML)
global $pdo;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php'; // Ta connexion $pdo

// Vérification des droits (Admin ou Rédacteur)
if (!isset($_SESSION['benevole']) ||
        (!in_array($_SESSION['benevole']['role'], ['administrateur', 'redacteur']))) {
    header('Location: index.php');
    exit();
}

$message = "";

// TRAITEMENT DU FORMULAIRE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    // On récupère l'ID depuis la session correcte
    $idAuteur = $_SESSION['benevole']['id_benevole'] ?? 1;

    // Gestion de l'image
    $nom_image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $dossier = 'assets/image/';
        if (!is_dir($dossier)) { mkdir($dossier, 0777, true); }

        $nom_fichier = time() . '_' . basename($_FILES['image']['name']);
        $extensions_autorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($nom_fichier, PATHINFO_EXTENSION));

        if (in_array($extension, $extensions_autorisees)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nom_fichier)) {
                $nom_image = $nom_fichier;
            } else {
                $message = "<div class='alert alert-danger'>Erreur lors de l'enregistrement de l'image.</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>Format d'image non valide.</div>";
        }
    }

    // Si pas d'erreur, on insère et ON REDIRIGE
    if (empty($message)) {
        $sql = "INSERT INTO article (titre, contenu, image, date_publication, id_auteur)
                VALUES (:titre, :contenu, :image, NOW(), :idAuteur)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                    ':titre' => $titre,
                    ':contenu' => $contenu,
                    ':image' => $nom_image,
                    ':idAuteur' => $idAuteur
            ]);

            // C'EST ICI QUE LA REDIRECTION FONCTIONNERA MAINTENANT
            // CAR AUCUN HTML N'A ÉTÉ AFFICHÉ AVANT
            header('Location: actualites.php');
            exit();

        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Erreur Base de Données : " . $e->getMessage() . "</div>";
        }
    }
}

// 2. ENSUITE LE HTML (HEADER ET FORMULAIRE)
require_once 'header.php';
?>

    <main class="container" style="margin-top: 150px; margin-bottom: 100px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="section-title mb-4 text-center">Créer un nouvel article</h1>

                <?php echo $message; ?>

                <form method="post" enctype="multipart/form-data" class="shadow p-5 rounded bg-white border">
                    <div class="mb-3">
                        <label for="titre" class="form-label fw-bold">Titre de l'article</label>
                        <input type="text" name="titre" id="titre" class="form-control" required placeholder="Ex: Soirée de rentrée...">
                    </div>

                    <div class="mb-3">
                        <label for="contenu" class="form-label fw-bold">Contenu</label>
                        <textarea name="contenu" id="contenu" rows="8" class="form-control" required placeholder="Rédigez votre article ici..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Photo (Optionnel)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="actualites.php" class="btn btn-outline-secondary px-4 rounded-pill">Annuler</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold rounded-pill">
                            <i class="fa-solid fa-paper-plane me-2"></i> Publier l'article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php require_once 'footer.php'; ?>