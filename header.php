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
            // Titre dynamique
            if(isset($page) && $page === 'evenements') echo '36ème Congrès National';
            else if(isset($page) && $page === 'formation') echo 'Formation des bénévoles';
            else if(isset($page) && $page === 'actualites') echo 'Actualités';
            else if(isset($page) && $page === 'documents') echo 'Espace Documentaire';
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
<?php
$body_class = '';

// Gestion des classes CSS par page
if (isset($page)) {
    if ($page === 'home') $body_class = 'home-page';
    else if ($page === 'formation') $body_class = 'formation-page';
    else if ($page === 'evenements') $body_class = 'evenement-page';
    else if ($page === 'actualites') $body_class = 'actualites-page';
}
?>
<body class="<?php echo $body_class; ?>">

<nav class="navbar navbar-expand-lg fixed-top px-3 <?php if(isset($page) && $page === 'autre') echo 'scrolled'; ?>" id="navbar">

    <a class="navbar-brand" href="index.php"><img src="assets/image/LogoFageBlanc.png" class="logo-img" alt="Logo"></a>

    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">LA FAGE</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="quiSommeNous.php">Qui sommes-nous</a></li>
                    <li><a class="dropdown-item" href="evenements.php">Évènement</a></li>
                    <li><a class="dropdown-item" href="agenda.php">Agenda</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">NOS IDÉES</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="actualites.php">Actualités</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">INNOVATION SOCIALE</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="vivreEnBonneSante.php">Vivre en bonne santé</a></li></ul>
            </li>

            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">SERVICES</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="benevole.php">Formation des bénévoles</a></li></ul>
            </li>
        </ul>

        <?php if (isset($_SESSION['benevole'])): ?>

            <span class="navbar-text text-white ms-3 d-none d-xl-inline">
                Bonjour, <?= htmlspecialchars($_SESSION['benevole']['prenom']) ?>
            </span>

            <a href="documents.php" class="btn btn-outline-light btn-sm ms-2" title="Documents internes">
                <i class="fa-solid fa-folder-open"></i> Docs
            </a>

            <?php
            if (isset($_SESSION['benevole']['role']) &&
                    ($_SESSION['benevole']['role'] === 'administrateur' || $_SESSION['benevole']['role'] === 'redacteur')):
                ?>
                <a href="creation_article.php" class="btn btn-warning btn-sm ms-2 text-dark fw-bold">
                    <i class="fa-solid fa-pen-to-square"></i> Publier
                </a>
            <?php endif; ?>

            <a href="mon_compte.php" class="btn btn-outline-light btn-sm ms-2">Mon espace</a>
            <a href="deconnexion.php" class="btn btn-danger btn-sm ms-2"><i class="bi bi-power"></i></a>

        <?php else: ?>
            <a href="connexion.php" class="btn btn-outline-light btn-sm ms-2">Connexion</a>
            <a href="inscription.php" class="btn btn-primary btn-sm ms-2">Inscription</a>
        <?php endif; ?>

        <button id="searchBtn" class="btn text-white ms-lg-3">
            <i class="bi bi-search fs-5"></i>
        </button>
        <input type="text" id="searchInput" placeholder="Rechercher...">
    </div>
</nav>

<?php if(isset($page) && $page === 'autre'){
    echo '<br><br><br><br>';
} ?>