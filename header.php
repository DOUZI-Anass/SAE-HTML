<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>
            FAGE |
            <?php
            if(isset($page) && $page === 'evenements') echo '36ème Congrès National';
            else if(isset($page) && $page === 'formation') echo 'Formation des bénévoles';
            else if(isset($page) && $page === 'actualites') echo 'Actualités';
            else echo 'Fédération des associations';
            ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="assets/style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>

<body style="background-color: #f8f9fa;">

<nav class="navbar navbar-expand-lg fixed-top px-3" id="navbar" style="background-color: #4da0c0;">

    <a class="navbar-brand" href="index.php">
        <img src="assets/image/LogoFageBlanc.png" style="height: 50px;" alt="Logo">
    </a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown">LA FAGE</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="quiSommeNous.php">Qui sommes-nous</a></li>
                    <li><a class="dropdown-item" href="evenements.php">Évènements</a></li>
                    <li><a class="dropdown-item" href="agenda.php">Agenda</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown">NOS IDÉES</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="actualites.php">Actualités</a></li>
                    <li><a class="dropdown-item" href="engagements.php">Nos engagements</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown">INNOVATION SOCIALE</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="vivreEnBonneSante.php">Vivre en bonne santé</a></li>
                    <li><a class="dropdown-item" href="precarite.php">Lutte contre la précarité</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white fw-bold" href="#" data-bs-toggle="dropdown">SERVICES</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="benevole.php">Formation des bénévoles</a></li>
                    <li><a class="dropdown-item" href="financement.php">Financer ses projets</a></li>
                </ul>
            </li>
        </ul>

        <div class="d-flex align-items-center gap-3">
            <?php if (isset($_SESSION['benevole'])): ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white profile-pill"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                            <i class="fa-solid fa-user" style="color: #4da0c0; font-size: 0.9rem;"></i>
                        </div>
                        <span class="fw-bold text-white"><?= htmlspecialchars($_SESSION['benevole']['prenom']) ?></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 custom-profile-menu">
                        <li><h6 class="dropdown-header text-muted small">Mon Espace</h6></li>

                        <li><a class="dropdown-item" href="mon_compte.php">
                                <i class="fa-solid fa-user me-2 text-primary"></i> Profil
                            </a></li>

                        <?php if (isset($_SESSION['benevole']['role']) && ($_SESSION['benevole']['role'] === 'administrateur' || $_SESSION['benevole']['role'] === 'redacteur')): ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-muted small">GESTION</h6></li>

                            <li><a class="dropdown-item fw-bold" href="creation_article.php">
                                    <i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Publier un article
                                </a></li>

                            <?php if ($_SESSION['benevole']['role'] === 'administrateur'): ?>
                                <li><a class="dropdown-item" href="admin.php">
                                        <i class="fa-solid fa-gauge-high me-2 text-danger"></i> Administration
                                    </a></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <li><hr class="dropdown-divider"></li>

                        <li><a class="dropdown-item text-danger fw-bold" href="deconnexion.php">
                                <i class="fa-solid fa-power-off me-2 text-danger"></i> Déconnexion
                            </a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="connexion.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Connexion</a>
                <a href="inscription.php" class="btn btn-primary btn-sm rounded-pill px-3 ms-2">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php if(isset($page) && $page === 'autre') echo '<div style="margin-top:100px;"></div>'; ?>