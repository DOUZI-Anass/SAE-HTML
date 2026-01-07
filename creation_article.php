<?php
global $pdo;
session_start();
require_once 'config.php'; // Ta connexion $pdo

// 1. SÉCURITÉ : Vérification des droits (Admin ou Redacteur uniquement)
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'administrateur' && $_SESSION['role'] !== 'redacteur')) {
    header('Location: index.php');
    exit();
}

require_once 'header.php';

// 2. TRAITEMENT DU FORMULAIRE
$message = ""; // Variable pour afficher les erreurs ou succès

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $idAuteur = $_SESSION['id_benevole'] ?? 1; // ID par défaut si souci de session

    // Gestion de l'image (Upload)
    $nom_image = null;

    // Si une image est envoyée et qu'il n'y a pas d'erreur technique
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $dossier = 'assets/image/';

        // Création du dossier s'il n'existe pas
        if (!is_dir($dossier)) {
            mkdir($dossier, 0777, true);
        }

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
            $message = "<div class='alert alert-warning'>Format d'image non valide (JPG, PNG, GIF uniquement).</div>";
        }
    }

    // Insertion en base de données seulement si pas d'erreur critique avant
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

            // Succès : Redirection vers la liste des actualités
            // (Tu peux commenter cette ligne si tu veux voir le message de succès d'abord)
            header('Location: actualites.php');
            exit();

        } catch (PDOException $e) {
            // C'est ICI qu'on attrape l'erreur au lieu de faire planter la page !
            $message = "<div class='alert alert-danger'>Erreur Base de Données : " . $e->getMessage() . "</div>";
        }
    }
}
?>

    <main class="container" style="margin-top: 150px; margin-bottom: 100px;">

        <h1 class="section-title mb-4">Créer un nouvel article</h1>

        <?php echo $message; ?>

        <form method="post" enctype="multipart/form-data" class="shadow p-4 rounded bg-white">

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
                <div class="form-text">Formats acceptés : JPG, PNG, GIF.</div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="actualites.php" class="btn btn-secondary me-md-2">Annuler</a>
                <button type="submit" class="btn btn-donner">Publier l'article</button>
            </div>
        </form>
    </main>

<?php require_once 'footer.php'; ?>