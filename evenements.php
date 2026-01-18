<?php
session_start();
global $pdo;
$page = 'evenements';

require 'header.php';
require 'config.php';

// === 1. Récupération des événements AVEC le nombre d'inscrits ===
try {
    $sql = "SELECT e.*, COUNT(i.id_benevole) as nb_inscrits 
            FROM evenement e 
            LEFT JOIN inscrit i ON e.id_evenement = i.id_evenement 
            GROUP BY e.id_evenement
            ORDER BY e.date_evenement ASC";

    $stmt = $pdo->query($sql);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $events = [];
}

// === 2. Récupération des inscriptions du bénévole connecté ===
$mes_inscriptions = [];
if (isset($_SESSION['benevole']['id_benevole'])) {
    $req = $pdo->prepare("SELECT id_evenement FROM inscrit WHERE id_benevole = ?");
    $req->execute([$_SESSION['benevole']['id_benevole']]);
    $mes_inscriptions = $req->fetchAll(PDO::FETCH_COLUMN);
}
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.carousel-slide');
        const nextBtn = document.querySelector('.carousel-btn.next');
        const prevBtn = document.querySelector('.carousel-btn.prev');
        let current = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }
        if(nextBtn) nextBtn.addEventListener('click', () => {
            current = (current + 1) % slides.length;
            showSlide(current);
        });
        if(prevBtn) prevBtn.addEventListener('click', () => {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        });
    });
</script>

<body class="evenement-page">

<section class="carousel-simple">
    <div class="carousel-slide active">
        <img src="assets/image/evenement.png" alt="Événement FAGE" style="width:100%; height:100%; object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=1600&q=80';">
        <div class="carousel-caption">
            <h2>Semaine de l’Engagement</h2>
            <p>Une semaine pour mettre à l’honneur l’engagement étudiant.</p>
        </div>
    </div>
    <button class="carousel-btn prev">❮</button>
    <button class="carousel-btn next">❯</button>
</section>

<section class="container py-5 mt-5">
    <h2 class="section-title text-center mb-4">Les événements de la FAGE</h2>
    <p class="lead text-center">
        Les événements de la <strong>FAGE</strong> sont bien plus que de simples rassemblements : ils représentent des espaces d’échange,
        de formation et d’expression pour les jeunes engagés dans la vie étudiante.
    </p>
    <p class="text-center">
        Qu’il s’agisse du <em>Forum National de la Jeunesse</em>, du <em>FAGE Camp</em> ou des <em>Assises Nationales</em>,
        chaque moment est une opportunité de partager des expériences, de débattre des grandes causes étudiantes et
        de renforcer la cohésion du réseau.
    </p>
</section>

<section class="container py-5">
    <h2 class="section-title text-center mb-5" style="color: var(--fage-blue);">Calendrier & Inscriptions</h2>

    <?php if (isset($_SESSION['benevole']) && $_SESSION['benevole']['role'] === 'administrateur'): ?>
        <div class="text-end mb-4">
            <a href="creation_event.php" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Ajouter un événement
            </a>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($events)): ?>
            <div class="col-12 text-center text-muted">Aucun événement à venir pour le moment.</div>
        <?php else: ?>
            <?php foreach ($events as $event): ?>

                <div class="col-12 mb-5">
                    <div class="card shadow-sm border-0 overflow-hidden">
                        <div class="row g-0 align-items-center">

                            <div class="col-md-3 text-white d-flex flex-column justify-content-center align-items-center p-4 text-center"
                                 style="background-color: var(--fage-blue); min-height: 250px;">
                                <span class="display-4 fw-bold mb-0"><?= date('d', strtotime($event['date_evenement'])) ?></span>
                                <span class="h3 text-uppercase mb-0"><?= date('M', strtotime($event['date_evenement'])) ?></span>
                                <span class="h5"><?= date('Y', strtotime($event['date_evenement'])) ?></span>
                            </div>

                            <div class="col-md-9">
                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h3 class="card-title fw-bold text-dark mb-0"><?= htmlspecialchars($event['titre']) ?></h3>
                                        <span class="badge bg-light text-dark border p-2">
                                            <i class="fa-solid fa-users text-primary"></i>
                                            <?= $event['nb_inscrits'] ?> participant(s)
                                        </span>
                                    </div>

                                    <p class="text-muted mb-2">
                                        <i class="fa-solid fa-location-dot me-1"></i> <?= htmlspecialchars($event['lieu']) ?>
                                    </p>

                                    <p class="card-text text-secondary mb-3">
                                        <?= nl2br(htmlspecialchars($event['description'])) ?>
                                    </p>

                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <?php if (isset($_SESSION['benevole']) && $_SESSION['benevole']['role'] === 'administrateur'): ?>

                                            <a href="modifier_event.php?id=<?= $event['id_evenement'] ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-pen"></i> Modifier
                                            </a>

                                            <form action="supprimer_event.php" method="POST"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cet événement ?');"
                                                  class="m-0">
                                                <input type="hidden" name="id_evenement" value="<?= $event['id_evenement'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-trash"></i> Supprimer
                                                </button>
                                            </form>

                                        <?php endif; ?>


                                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#map-<?= $event['id_evenement'] ?>">
                                            <i class="fa-solid fa-map-location-dot"></i> Voir le plan d'accès
                                        </button>

                                        <?php if (isset($_SESSION['benevole'])): ?>
                                            <?php if (in_array($event['id_evenement'], $mes_inscriptions)): ?>
                                                <button class="btn btn-secondary btn-sm" disabled><i class="fa-solid fa-check"></i> Inscrit</button>
                                                <form action="desinscription_evenement.php" method="POST" class="m-0">
                                                    <input type="hidden" name="id_evenement" value="<?= $event['id_evenement'] ?>">
                                                    <button type="submit" class="btn btn-link text-danger btn-sm text-decoration-none">Désinscrire</button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-primary btn-sm btn-inscription"
                                                        style="background-color: var(--fage-blue); border: none;"
                                                        data-id="<?= $event['id_evenement'] ?>">
                                                    Je participe !
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="connexion.php" class="btn btn-outline-primary btn-sm">Se connecter</a>
                                        <?php endif; ?>
                                    </div>

                                    <div class="collapse mt-3" id="map-<?= $event['id_evenement'] ?>">
                                        <div class="card card-body p-0 border-0 rounded overflow-hidden">
                                            <iframe
                                                    width="100%"
                                                    height="300"
                                                    frameborder="0"
                                                    style="border:0;"
                                                    src="https://maps.google.com/maps?q=<?= urlencode($event['lieu']) ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
    document.querySelectorAll('.btn-inscription').forEach(button => {
        button.addEventListener('click', function() {
            const idEvent = this.getAttribute('data-id');
            const btn = this;
            const formData = new FormData();
            formData.append('id_evenement', idEvent);

            fetch('inscription_evenement.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        btn.className = 'btn btn-secondary btn-sm';
                        btn.innerHTML = '<i class="fa-solid fa-check"></i> Inscrit !';
                        btn.disabled = true;
                        setTimeout(() => location.reload(), 1000);
                    } else if (data.error) alert("Erreur : " + data.error);
                });
        });
    });
</script>

<?php require 'footer.php'; ?>
</body>