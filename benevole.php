<?php
// Définir la variable pour que le header.php sache quelle page il charge
$page = 'formation';
// Inclure le header.php (qui contient l'ouverture de <html>, <head>, et <body>)
require 'header.php';
?>
    <main class="page-formation-fage">

        <section class="intro-section">
            <h1>La formation à la FAGE</h1>
            <p>
                Dans son esprit d’organisation de jeunesse et d’éducation populaire, la FAGE et ses fédérations s’engagent à former les
                jeunes bénévoles tout au long de l’année. Ces formations visent à développer l’engagement, la solidarité et la prise de
                responsabilité dans les associations étudiantes, tout en favorisant la montée en compétences.
            </p>
        </section>

        <section class="bloc">
            <div class="bloc-image">
                <img src="assets/image/Fage_diplome.png" alt="Formation FAGE">
            </div>
            <div class="bloc-texte">
                <h2>L’accompagnement</h2>
                <p>
                    Au sein de l’équipe nationale, un vice-président, un chargé de mission et un coordinateur de réseau accompagnent chaque fédération
                    dans son développement. Cet accompagnement repose sur des formations sur mesure, des échanges régionaux et un partage
                    d’expériences entre bénévoles.
                </p>
                <p>
                    L’objectif : aider chaque fédération à se structurer durablement, créer des projets solides et renforcer la cohésion
                    des équipes étudiantes dans toute la France.
                </p>
                <ul>
                    <li> Soutien à la gestion associative</li>
                    <li> Développement du travail en réseau</li>
                    <li> Aide à la création et au financement de projets</li>
                </ul>
            </div>
        </section>

        <section class="bloc inverse">
            <div class="bloc-texte">
                <h2>Les événements de formation</h2>
                <p>
                    Chaque année, la FAGE organise plusieurs temps forts qui rassemblent des centaines d’étudiants bénévoles venus de toute la France :
                </p>
                <ul>
                    <li> Le Congrès National: moment de formation, de débats et de démocratie étudiante.</li>
                    <li> Les Assoliades : universités d’été de la FAGE, centrées sur la formation et la cohésion.</li>
                    <li> Les Séminaires Régionaux: rencontres locales favorisant les échanges entre fédérations.</li>
                </ul>
                <p>
                    Ces événements sont des lieux d’échanges et d’apprentissage, permettant de renforcer les compétences
                    des bénévoles et d’enrichir la vie associative.
                </p>
            </div>
            <div class="bloc-image">
                <img src="assets/image/evenement3.png" alt="Événements FAGE">
            </div>
        </section>

        <section class="bloc">
            <div class="bloc-image">
                <img src="assets/image/Wikifage.png" alt="wikiFAGE">
            </div>
            <div class="bloc-texte">
                <h2>Les outils de formation</h2>
                <p>
                    La FAGE met à disposition de ses membres des outils et supports pour accompagner les bénévoles dans leurs missions :
                </p>
                <ul>
                    <li>Le Guide du Responsable Associatif : comprendre la gestion d’une association étudiante.</li>
                    <li>Le Guide de l’Élu : accompagner les représentants étudiants dans leurs mandats.</li>
                    <li>wikiFAGE : plateforme numérique collaborative de partage de ressources et de formations.</li>
                </ul>
                <p>
                    En tout, plus de 70 formations sont proposées chaque année dans les domaines de la communication,
                    de la gestion, du leadership et de la représentation étudiante.
                </p>
            </div>
        </section>

        <section class="bloc inverse">
            <div class="bloc-texte">
                <h2>Nos valeurs fondamentales</h2>
                <p>
                    La FAGE place au cœur de ses formations des valeurs fortes qui guident chacune de ses actions :
                </p>
                <ul>
                    <li> Éducation populaire : apprendre ensemble, par et pour les jeunes.</li>
                    <li> Solidarité : encourager l’entraide et la coopération entre associations.</li>
                    <li>️ Démocratie participative : donner à chaque étudiant une voix et un rôle actif.</li>
                    <li> Responsabilité citoyenne : s’impliquer pour transformer la société de demain.</li>
                </ul>
            </div>
            <div class="bloc-image">
                <img src="assets/image/solidarite.png" alt="Valeurs FAGE">
            </div>
        </section>


    </main>

<?php require 'footer.php'; ?>