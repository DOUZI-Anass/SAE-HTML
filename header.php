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
        else echo 'Fédération des associations';
        ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
// Détermine la classe BODY dynamique
$body_class = '';
if(isset($page) && $page === 'formation') {
    $body_class = 'formation-page';
} else if(isset($page) && $page === 'evenements') {
    $body_class = 'evenement-page';
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
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="quiSommeNous.php">Qui sommes-nous</a></li><li><a class="dropdown-item" href="evenements.php">Évènement</a></li></ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">NOS IDEES</a>
                
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">INNOVATION SOCIALE</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="vivreEnBonneSante.php">Vivre en bonne santé</a></li></ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">SERVICES</a>
                <ul class="dropdown-menu"><li><a class="dropdown-item" href="benevole.php">Formation des bénévoles</a></li></ul>
            </li>
        </ul>
        <button id="searchBtn" class="btn text-white ms-lg-3"><i class="bi bi-search fs-5"></i></button>
        <input type="text" id="searchInput" placeholder="Rechercher...">
    </div>
</nav>

<?php if(isset($page) && $page === 'autre'){
    echo '<br><br><br><br>';
} ?>