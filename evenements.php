<?php
global $pdo;
$page = 'evenements';
require 'header.php';
?>
<body class="evenement-page">

<!-- =========================
     CARROUSEL AVEC FLÈCHES
========================= -->
<section class="carousel-simple">
    <div class="carousel-slide active">
        <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?auto=format&fit=crop&w=1600&q=80" alt="Semaine de l’Engagement">
        <div class="carousel-caption">
            <h2>Semaine de l’Engagement</h2>
            <p>Une semaine pour mettre à l’honneur l’engagement étudiant à travers des actions solidaires.</p>
            <a href="#" class="btn btn-primary mt-3">Découvrir l’événement</a>
        </div>
    </div>

    <div class="carousel-slide">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1600&q=80" alt="FAGE Camp">
        <div class="carousel-caption">
            <h2>FAGE Camp</h2>
            <p>Un rassemblement estival autour de la formation, de la cohésion et de l’engagement associatif.</p>
            <a href="#" class="btn btn-primary mt-3">Découvrir l’événement</a>
        </div>
    </div>

    <div class="carousel-slide">
        <img src="https://images.unsplash.com/photo-1503428593586-e225b39bddfe?auto=format&fit=crop&w=1600&q=80" alt="Assises Nationales">
        <div class="carousel-caption">
            <h2>Assises Nationales</h2>
            <p>Un grand rendez-vous annuel pour débattre et construire la représentation étudiante de demain.</p>
            <a href="congres36.php" class="btn btn-primary mt-3">Découvrir l’événement</a>
        </div>
    </div>

    <!-- Flèches de navigation -->
    <button class="carousel-btn prev">&#10094;</button>
    <button class="carousel-btn next">&#10095;</button>
</section>

<!-- =========================
     DESCRIPTION
========================= -->
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
    <p class="text-center">
        Ces événements sont aussi des lieux d’innovation sociale, où les jeunes peuvent proposer, créer et agir
        concrètement pour une société plus juste, solidaire et démocratique.
        La FAGE accompagne ces dynamiques en favorisant la participation active, la formation et l’autonomie
        de chacun de ses membres.
    </p>
</section>

<?php require 'footer.php'; ?>
</body>

<!-- =========================
     SCRIPT CARROUSEL
========================= -->
<script>
    const slides = document.querySelectorAll('.carousel-slide');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    let current = 0;
    let autoPlay = true;
    let interval = setInterval(nextSlide, 6000);

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    function prevSlide() {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    }

    nextBtn.addEventListener('click', () => {
        nextSlide();
        resetTimer();
    });
    prevBtn.addEventListener('click', () => {
        prevSlide();
        resetTimer();
    });

    function resetTimer() {
        if (autoPlay) {
            clearInterval(interval);
            interval = setInterval(nextSlide, 6000);
        }
    }
</script>

<?php
session_start();
require 'config.php';

// --- 1. Protection de la page ---

// Redirige si non connecté
if (!isset($_SESSION['benevole'])) {
    header('Location: connexion.php');
    exit;
}

// Redirige si ce n'est pas un administrateur
$role_utilisateur = $_SESSION['benevole']['role'] ?? 'bénévole';
if ($role_utilisateur !== 'administrateur') {
    header('Location: index.php');
    exit;
}

// --- 2. Traitement de l'insertion d'Événement ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre_evenement']);
    $date        = $_POST['date_evenement'];
    $lieu        = trim($_POST['lieu_evenement']);
    $description = trim($_POST['description_evenement']);

    if ($titre === '' || $date === '') {
        $error_message = "Erreur : Le titre et la date de l'événement sont obligatoires.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO evenement (titre, description, date_evenement, lieu)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([$titre, $description, $date, $lieu]);

            $success_message = "L'événement '{$titre}' a été ajouté avec succès !";

        } catch (PDOException $e) {
            // Si la table n'existe pas, ou autre erreur SQL
            $error_message = "Erreur BDD lors de l'ajout de l'événement.";
        }
    }
} else {
    // Si l'utilisateur accède à la page sans POST, on le renvoie à l'admin
    header('Location: admin.php');
    exit;
}

// --- 3. Redirection finale ---
$redirect_url = 'admin.php';
$message = $success_message ?? $error_message;
$type = $success_message ? 'success' : 'error';

if ($message) {
    $redirect_url .= '?message=' . urlencode($message) . '&type=' . $type;
}

header('Location: ' . $redirect_url);
exit;
?>
