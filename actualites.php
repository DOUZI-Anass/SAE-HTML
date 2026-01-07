<?php
// 1. Connexion à la base de données
// Si config.php lance déjà session_start(), pas besoin de le remettre, sinon décommente la ligne suivante :
if (session_status() === PHP_SESSION_NONE) session_start();

global $pdo;
require_once 'config.php';
require_once 'header.php';

// 2. Récupération des articles (du plus récent au plus vieux)
try {
    $sql = "SELECT * FROM article ORDER BY date_publication DESC";
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des articles : " . $e->getMessage();
    $articles = [];
}
?>

    <main class="Actualité container" style="margin-top: 150px; margin-bottom: 50px;">

        <h1 class="section-title text-center mb-5">Nos Dernières Actualités</h1>

        <?php if (empty($articles)): ?>
            <div class="alert alert-info text-center">
                Aucune actualité n'a été publiée pour le moment.
            </div>
        <?php else: ?>

            <div class="row">
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 card-actu"> <?php
                            $imagePath = !empty($article['image']) ? 'assets/image/' . $article['image'] : 'assets/image/default.jpg';
                            ?>

                            <a href="article.php?id=<?= $article['id_article'] ?>">
                                <div class="card-img-top-wrapper" style="height: 200px; overflow: hidden;">
                                    <img src="<?= htmlspecialchars($imagePath) ?>"
                                         class="card-img-top w-100 h-100"
                                         style="object-fit: cover;"
                                         alt="<?= htmlspecialchars($article['titre']) ?>"
                                         onerror="this.src='assets/image/logo-fage.png';">
                                </div>
                            </a>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold">
                                    <?= htmlspecialchars($article['titre']) ?>
                                </h5>

                                <p class="text-muted small">
                                    <i class="fa fa-calendar-alt"></i>
                                    Publié le <?= date('d/m/Y', strtotime($article['date_publication'])) ?>
                                </p>

                                <p class="card-text flex-grow-1">
                                    <?= htmlspecialchars(substr($article['contenu'], 0, 100)) ?>...
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3">

                                    <a href="article.php?id=<?= $article['id_article'] ?>" class="btn btn-donner btn-sm">
                                        Lire la suite
                                    </a>

                                    <?php if (isset($_SESSION['benevole']['role']) &&
                                            ($_SESSION['benevole']['role'] === 'administrateur' || $_SESSION['benevole']['role'] === 'redacteur')): ?>
                                        <div>
                                            <a href="modif_article.php?id=<?= $article['id_article'] ?>" class="btn btn-outline-warning btn-sm me-1" title="Modifier">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="Sup_Article.php?id=<?= $article['id_article'] ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');"
                                               title="Supprimer">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                </div> </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </main>

<?php require_once 'footer.php'; ?>