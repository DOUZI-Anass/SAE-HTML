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

<section class="container py-5">

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="bloc-blanc h-100"> <h2 class="fw-bold text-uppercase text-primary">Notre mission</h2>
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
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/missionA.png" alt="Mission de la FAGE" class="imgM">
        </div>
    </div>

    <div class="row align-items-center flex-md-row-reverse mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="bloc-blanc h-100">
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
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/valeurA.png" alt="Valeurs de la FAGE" class="imgM">
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="bloc-blanc h-100">
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
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/formationA.png" alt="Formation à la FAGE" class="imgM">
        </div>
    </div>

</section>

<div class="container mb-5">
    <div class="row justify-content-center text-center">
        <div class="col-12 col-md-10 telechargement-section">
            <h2 class="fw-bold text-uppercase mb-4">Documents à télécharger</h2>
            <p class="mb-4">Découvrez nos documents officiels pour en savoir plus sur nos actions et nos engagements :</p>
            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                <a href="assets/pdf/Projet-educatif.pdf" class="btn btn-primary px-4 py-2" download>
                    📄 Présentation FAGE
                </a>
                <a href="assets/pdf/5850-FAGE-rapport-2018-BD.pdf" class="btn btn-outline-primary px-4 py-2" download>
                    📘 Rapport d'activité
                </a>
            </div>
        </div>
    </div>
</div>

<section class="py-5 bg-light border-top">
    <div class="container">
        <h2 class="section-title text-center mb-5">Où nous trouver ?</h2>
        <div class="row align-items-center">
            <div class="col-md-5 mb-4 mb-md-0">
                <h3>Siège de la FAGE</h3>
                <p class="lead">Venez nous rencontrer !</p>
                <p><i class="fa-solid fa-location-dot text-primary"></i> 79 Rue Périer, 92120 Montrouge</p>
                <p><i class="fa-solid fa-phone text-primary"></i> 01 40 33 70 70</p>
                <p><i class="fa-solid fa-envelope text-primary"></i> contact@fage.org</p>
            </div>
            <div class="col-md-7">
                <div class="shadow rounded overflow-hidden">
                    <iframe
                            width="100%"
                            height="350"
                            frameborder="0"
                            style="border:0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2626.887268809653!2d2.3168!3d48.8225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e671aa7a7a7a7a%3A0x7a7a7a7a7a7a7a7a!2s79%20Rue%20P%C3%A9rier%2C%2092120%20Montrouge!5e0!3m2!1sfr!2sfr!4v1600000000000!5m2!1sfr!2sfr"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
</body>