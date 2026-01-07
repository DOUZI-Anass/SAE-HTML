<?php
// 1. Connexion et Header
global $pdo;
require_once 'config.php';
require_once 'header.php';


// 2. Vérification de l'ID dans l'URL
// Si pas d'ID, on renvoie vers la liste des actus
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: actualites.php');
    exit();
}

$id_article = $_GET['id'];
$article = null;

try {
    // 3. Récupération de l'article spécifique
    $sql = "SELECT * FROM article WHERE id_article = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_article]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'article n'existe pas dans la BDD
    if (!$article) {
        echo "<div class='container mt-5'><p class='alert alert-warning'>Article introuvable.</p></div>";
        require_once 'footer.php';
        exit();
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

    <main class="Article">

        <a href="actualites.php" class="btn btn-secondary mb-4">
            <i class="fa-solid fa-arrow-left"></i> Retour aux actualités
        </a>

        <article class="bg-white p-4 rounded shadow-sm">

            <h1 class="section-title mb-3" style="font-size: 2.5rem;">
                <?php echo htmlspecialchars($article['titre']); ?>
            </h1>

            <div class="text-muted mb-4">
                <i class="fa-regular fa-calendar"></i>
                Publié le <?php echo date('d/m/Y à H:i', strtotime($article['date_publication'])); ?>
            </div>

            <?php if (!empty($article['image'])): ?>
                <div class="mb-4 text-center">
                    <img src="assets/image/<?php echo htmlspecialchars($article['image']); ?>"
                         alt="Illustration article"
                         class="img-fluid rounded"
                         style="max-height: 500px; width: auto;">
                </div>
            <?php endif; ?>

            <div class="article-content" style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
            </div>

        </article>
    </main>

<?php require_once 'footer.php'; ?>