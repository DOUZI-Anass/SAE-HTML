<?php
$page = 'autre'; // Pour garder la navbar bleue
require 'header.php';
?>

<body class="qsn-page"> <section class="container py-5 mt-5">
    <h2 class="section-title text-center mb-4">Financer ses projets associatifs</h2>
    <p class="lead text-center">
        Vous avez un projet, mais il vous manque des moyens pour le mener à terme ?
        La FAGE et ses partenaires vous accompagnent via différents dispositifs de financement.
    </p>
</section>

<section class="container py-5">

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Le FIRF</h2>
            <p class="text-muted"><em>Fonds des Initiatives du Réseau de la FAGE</em></p>
            <p>
                Le FIRF a pour but de favoriser l'essaimage d'innovations sociales portées par les associations étudiantes du réseau.
                Il soutient les projets ayant une <strong>plus-value sociale</strong> (culture, citoyenneté, économie sociale et solidaire, transition écologique).
            </p>
            <ul>
                <li>Aide plafonnée à <strong>1000€</strong> (max 50% du projet).</li>
                <li>Réservé aux associations membres de la FAGE.</li>
                <li>Dépôt du dossier 1 mois avant la réalisation.</li>
            </ul>
            <a href="https://forms.office.com/e/gafLKnTfag" class="btn btn-donner mt-3">Candidater au FIRF</a>
        </div>
        <div class="col-md-6 text-center">
            <div class="p-4 border rounded bg-light shadow-sm">
                <i class="fa-solid fa-file-pdf fa-4x text-primary mb-3"></i>
                <h5>Fiche technique FIRF</h5>
                <p class="small">Retrouvez tous les détails du fonctionnement et les critères d'éligibilité.</p>
                <a href="assets/pdf/FT-FIRF.pdf" class="btn btn-outline-primary btn-sm" download>Télécharger le PDF</a>
            </div>
        </div>
    </div>

    <div class="row align-items-center flex-md-row-reverse mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Le FSDIE</h2>
            <p class="text-muted"><em>Fonds de Solidarité et de Développement des Initiatives Étudiantes</em></p>
            <p>
                Instauré par le ministère, ce fonds est géré par les Universités. Il est alimenté par une partie de la <strong>CVEC</strong>.
                Il finance l'aide aux projets étudiants et l'amélioration de la vie étudiante.
            </p>
            <p><strong>Exemples d'utilisation :</strong></p>
            <ul class="small">
                <li>Aménagement de lieux de rencontre.</li>
                <li>Aide au montage de projets (forums, congrès).</li>
                <li>Actions de solidarité internationale ou handicap.</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/737.png" alt="Financement Université" class="imgM">
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h2 class="fw-bold text-uppercase text-primary">Culture ActionS</h2>
            <p>
                <strong>Culture ActionS</strong> est un dispositif de soutien aux projets et aux initiatives étudiantes par le réseau des CROUS et du CNOUS. Il comporte 4 fonds d'aide spécifiques :
            </p>
            <ul class="small">
                <li><strong>Le fonds Jeune Talent :</strong> Mise en valeur de la création artistique étudiante dans tous les domaines culturels.</li>
                <li><strong>Le fonds Culture scientifique et technique :</strong> Soutien aux projets privilégiant la recherche.</li>
                <li><strong>Le fonds Culturel :</strong> Financement de projets artistiques divers (festivals, concerts, expositions, théâtre, cinéma, etc.).</li>
                <li><strong>Le fonds ActionS/Engagement :</strong> Projets liés à la citoyenneté, solidarité, environnement, sport ou économie.</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="assets/image/culture-actions-poster.png" alt="Affiche Culture ActionS" class="imgM">
        </div>
    </div>

</section>

<br><br><br>

<?php require 'footer.php'; ?>
</body>
