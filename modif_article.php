<?php
global $pdo;
session_start();
require_once 'config.php';
require_once 'header.php';

// 1. SÉCURITÉ
if (!isset($_SESSION['benevole']['role']) ||
    ($_SESSION['benevole']['role'] !== 'administrateur' && $_SESSION['benevole']['role'] !== 'redacteur')) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// 2. RÉCUPÉRATION DE L'ARTICLE ACTUEL
if (!isset($_GET['id'])) {
    echo "<script>window.location.href='actualites.php';</script>";
    exit();
}
$id = $_GET['id'];
$req = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
$req->execute([$id]);
$article = $req->fetch();

// 3. TRAITEMENT DU FORMULAIRE DE MODIFICATION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    // Par défaut, on garde l'ancienne image
    $nom_image = $article['image'];

    // Si une nouvelle image est uploadée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $dossier = 'assets/image/';
        $nom_image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nom_image);
    }

    // Mise à jour SQL
    $sql = "UPDATE article SET titre = :titre, contenu = :contenu, image = :image WHERE id_article = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titre' => $titre,
        ':contenu' => $contenu,
        ':image' => $nom_image,
        ':id' => $id
    ]);

    // Redirection après succès
    echo "<script>window.location.href='actualites.php';</script>";
    exit();
}
?>

    <main class="container" style="margin-top: 150px; margin-bottom: 100px; min-height: 80vh;">
        <h1 class="section-title">Modifier l'article</h1>

        <form method="post" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <textarea name="contenu" rows="8" class="form-control" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image (Laisser vide pour garder l'actuelle)</label>
                <input type="file" name="image" class="form-control">
                <?php if($article['image']): ?>
                    <div class="mt-2">
                        <small>Image actuelle :</small><br>
                        <img src="assets/image/<?php echo $article['image']; ?>" width="100" class="rounded">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-warning fw-bold">Enregistrer les modifications</button>
            <a href="actualites.php" class="btn btn-secondary">Annuler</a>
        </form>
    </main>

<?php require_once 'footer.php'; ?>