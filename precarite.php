C'est entendu, j'ai retiré la section vidéo. Voici la version finale de votre page "Lutte contre la précarité" (precarite.php), parfaitement épurée et conforme à vos dernières instructions.

PHP

<?php
$page = 'autre';
require 'header.php';
?>

<body class="qsn-page">

<section class="container py-5 mt-5">
    <h2 class="section-title text-center mb-4">S'engager dans la lutte contre les précarités</h2>
    <p class="lead text-center">
        La <strong>FAGE</strong> et son réseau s'engagent afin d'organiser pour lutter contre la précarité sous toutes ses formes.
        Retrouvez toutes les initiatives du programme solidarité étudiante portées par les associations.
    </p>
</section>

<section class="container py-5">

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">AGORAé : Épiceries Solidaires</h2>
            <p>
                La FAGE a pour vocation d’améliorer les conditions de vie de la population étudiante. Elle a donc décidé d'intervenir sur les problématiques de précarité et de lutte contre l’exclusion auxquelles les étudiants sont de plus en plus sujets.
            </p>
            <p>La réponse que la FAGE apporte intervient à plusieurs niveaux :</p>
            <ul class="small">
                <li>Une aide alimentaire ;</li>
                <li>La création de lien social ;</li>
                <li>Du conseil à la vie quotidienne ;</li>
                <li>Un accompagnement de projets ;</li>
                <li>Une aide à l’accès aux droits ;</li>
                <li>Une aide à l’accès à la culture, aux loisirs et au départ en vacances ;</li>
                <li>Une aide à l’accès à l’engagement.</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/agorae_visuel.png" alt="Espaces AGORAé" class="imgM">
        </div>
    </div>

    <div class="row align-items-center flex-md-row-reverse mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">UBUC : Un vrai droit aux vacances</h2>
            <p>
                En partenariat avec l'<strong>UCPA</strong>, la FAGE propose chaque année à des étudiant.e.s fragilisé.e.s (boursier.e.s, bénéficiaires AGORAé, ou d'aides sociales d'urgence du CROUS) de partir en vacances dans un centre de loisirs UCPA en pleine nature.
            </p>
            <p>
                Ce dispositif permet de bénéficier d'un tarif social de <strong>50€ par jeune</strong> pour un séjour dont la valeur réelle s'élève à 500€ avec le transport, l'hébergement, les repas et les activités sportives encadrées comprises.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/ubuc_photo.png" alt="Vacances UBUC" class="imgM">
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Lutte contre la précarité menstruelle</h2>
            <p>
                La précarité menstruelle désigne la situation dans laquelle se trouvent les personnes menstruées qui n’ont pas assez de protections périodiques et des produits d’hygiène lors des menstruations à cause de leurs ressources financières.
            </p>
            <p>
                Face à l’absence de produits périodiques, ces personnes doivent utiliser des moyens de substitution qui présentent des risques sanitaires (infections, etc.). La précarité menstruelle empêche de vivre dignement.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <div class="p-5 rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center"
                 style="width: 300px; height: 300px; background-color: #f8f9fa; border: 2px dashed var(--fage-blue);">
                <div class="text-center">
                    <i class="fa-solid fa-hand-holding-heart fa-5x mb-3" style="color: var(--fage-blue);"></i>
                    <p class="fw-bold mb-0" style="color: var(--fage-blue);">Action Solidarité</p>
                    <p class="small text-muted">Hygiène & Dignité</p>
                </div>
            </div>
        </div>
    </div>

</section>

<div class="row justify-content-center text-center telechargement-section mx-0">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-uppercase mb-4">Plaquette de présentation</h2>
        <p class="mb-4">Consultez notre document officiel sur les campagnes d'Innovation Sociale :</p>
        <div class="d-flex justify-content-center">
            <a href="assets/pdf/plaquette-is.pdf" class="btn btn-primary px-4 py-2" download>
                📄 Télécharger la plaquette des campagnes IS
            </a>
        </div>
    </div>
</div>

<br><br><br>

<?php require 'footer.php'; ?>
</body>