<?php
$page = 'autre';
require 'header.php';
?>
<body class="qsn-page">

<section class="container py-5 mt-5">
    <h2 class="section-title text-center mb-4">Qui sommes-nous ?</h2>
    <p class="lead text-center">
        La <strong>FAGE</strong>, Fédération des Associations Générales Étudiantes, est la première organisation étudiante représentative en France.
        Fondée en 1989, elle repose sur la démocratie participative. Elle regroupe près de 2 000 associations et syndicats, via des fédérations territoriales et de filière, soit environ 300 000 jeunes.
    </p>
</section>

<!-- SECTION CONTENU -->
<section class="container py-5">

    <!-- Bloc 1 -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Notre mission</h2>
            <p>
                La <strong>FAGE</strong> (Fédération des Associations Générales Étudiantes) œuvre depuis 1989 pour
                améliorer les conditions de vie et d’étude des jeunes. Première organisation étudiante en France,
                elle rassemble plus de 2 000 associations et syndicats à travers le pays.
            </p>
            <p>
                Sa mission : représenter, défendre et soutenir les jeunes dans leurs projets, tout en favorisant
                l’innovation sociale et la participation citoyenne.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/missionA.png" alt="Mission de la FAGE" class="imgM">
        </div>
    </div>

    <!-- Bloc 2 -->
    <div class="row align-items-center flex-md-row-reverse mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Nos valeurs</h2>
            <p>
                La FAGE est une organisation <strong>indépendante</strong> des partis politiques et des mutuelles étudiantes.
                Elle repose sur des valeurs <strong>humanistes, républicaines et européennes</strong>, défendant l’autonomie,
                la solidarité et l’engagement.
            </p>
            <p>
                Reconnue par l’État comme organisme de <em>Jeunesse et d’Éducation Populaire</em>, elle agit chaque jour
                pour une société plus juste et inclusive.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/valeurA.png" alt="Valeurs de la FAGE" class="imgM test">
        </div>
    </div>

    <!-- Bloc 3 -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Former et agir</h2>
            <p>
                Chaque année, la FAGE forme des milliers de jeunes bénévoles à travers des formations, des événements et
                des initiatives locales. Ces jeunes deviennent des acteurs de changement dans leurs territoires.
            </p>
            <p>
                La formation est au cœur du projet de la FAGE : elle permet à chacun d’acquérir des compétences utiles,
                d’expérimenter et d’entreprendre.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/formationA.png" alt="Formation à la FAGE" class="imgM">
        </div>
    </div>

    <!-- Bloc 4 -->
    <div class="row justify-content-center centrale">
        <div class="col-12 col-md-8 text-center">
            <h2 class="fw-bold text-uppercase text-primary mb-3">Notre siège</h2>
            <p class="mb-0">
                79 rue Périer, 92120 Montrouge<br>
                <strong>Téléphone :</strong> 01 40 33 70 70
            </p>
        </div>
    </div>

</section>

<!-- Bloc téléchargement PDF -->
<div class="row justify-content-center text-center telechargement-section">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-uppercase mb-4">Documents à télécharger</h2>
        <p class="mb-4">Découvrez nos documents officiels pour en savoir plus sur nos actions et nos engagements :</p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
            <a href="assets/pdf/Projet-educatif.pdf" class="btn btn-primary px-4 py-2" download>
                📄 Télécharger la présentation de la FAGE
            </a>
            <a href="assets/pdf/5850-FAGE-rapport-2018-BD.pdf" class="btn btn-outline-primary px-4 py-2" download>
                📘 Télécharger le rapport d'activité
            </a>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
</body>
