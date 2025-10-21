<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FAGE | Fédération des associations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg fixed-top px-3 <?php if(isset($page) && $page === 'autre') echo 'scrolled'; ?>" id="navbar">

    <a class="navbar-brand" href="index.php"><img src="assets/image/LogoFageBlanc.png" class="logo-img" alt="Logo"></a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">LA FAGE</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="quiSommeNous.php">Qui sommes-nous</a></li><li><a class="dropdown-item" href="#">Évènement</a></li></ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">NOS IDEES</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="#">Éducation</a></li><li><a class="dropdown-item" href="#">Santé</a></li></ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">INNOVATION SOCIALE</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="#">Vivre en bonne santé</a></li><li><a class="dropdown-item" href="#">Lutte contre la précarité</a></li></ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">SERVICES</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="Formation_benevole.php">Formation des bénévoles</a></li><li><a class="dropdown-item" href="#">Financer ses projets</a></li></ul>
            </li>
        </ul>
        <button id="searchBtn" class="btn text-white ms-lg-3"><i class="bi bi-search fs-5"></i></button>
        <input type="text" id="searchInput" placeholder="Rechercher...">
    </div>
</nav>

<?php if(isset($page) && $page === 'autre'){
                                               echo '<br><br><br><br>';
                                           } ?>
