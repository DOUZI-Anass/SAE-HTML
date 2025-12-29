
<?php
$page = 'home';
require 'header.php';
?>
<section class="hero d-flex flex-column justify-content-center align-items-center text-center text-white">
    <div class="container">
        <h1 class="fw-bold mb-3">La FAGE, c’est bien plus qu’une fédération...</h1>
        <p class="lead">Un mouvement d’étudiants engagés pour d’autres étudiants.</p>
    </div>
</section>

<!-- ACTUALITÉS -->
<section id="actualites" class="py-5">
    <div class="container">
        <h2 class="section-title">Actualités</h2>
        <div class="row g-4 justify-content-center">

            <!-- Actu 1 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="assets/image/BOUGE_TON_CAMPUS.png" class="card-img-top" alt="Actu1">
                    <div class="card-body">
                        <h5 class="card-title">Résultats des élections CNESER 2025</h5>
                        <small class="text-muted">06/06/2025</small>
                        <p class="mt-2">
                            La FAGE confirme sa place de première organisation étudiante représentative au CNESER
                            à l’issue des élections 2025. Un résultat qui témoigne de l’engagement continu de nos
                            militants pour défendre les droits et les intérêts de tous les étudiants.
                        </p>
                        <a href="actualite-cneser2025.php" class="btn btn-outline-primary">Lire plus</a>
                    </div>
                </div>
            </div>

            <!-- Actu 2 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="assets/image/INDIC_COUT_RENTREE.jpeg" class="card-img-top" alt="Actu 2">
                    <div class="card-body">
                        <h5 class="card-title">Coût de la rentrée 2025</h5>
                        <small class="text-muted">05/09/2025</small>
                        <p class="mt-2">
                            Le coût d’une année étudiante augmente de 2.2%, Un étudiant devra en moyenne débourser 3.227
                            euros pour une année universitaire, selon la Fage. Une hausse qui alerte le syndicat, alors
                            que le deuxième volet de la réforme des bourses est à nouveau reporté..</p>
                        <a href="#" class="btn btn-outline-primary">Lire plus</a>
                    </div>
                </div>
            </div>

            <!-- Actu 3 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="assets/image/BAROMETRE.png" class="card-img-top" alt="Actu 3">
                    <div class="card-body">
                        <h5 class="card-title">Baromètre de la précarité étudiante 2025</h5>
                        <small class="text-muted">05/09/2025</small>
                        <p class="mt-2">
                            Le nouveau baromètre de la précarité étudiante révèle une situation toujours préoccupante,
                            marquée par la hausse du coût de la vie et des inégalités persistantes. La FAGE appelle
                            à des mesures concrètes pour garantir une vie étudiante digne.</p>
                        <a href="#" class="btn btn-outline-primary">Lire plus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NOS ACTIONS -->
<section id="actions" class="py-5">
    <div class="container">
        <h2 class="section-title">Nos Actions</h2>
        <div class="row g-4 text-center justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm p-3">
                    <i class="bi bi-mortarboard fs-1 text-primary"></i>
                    <h5 class="mt-3">Formation</h5>
                    <p>Formations pour bénévoles et responsables.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm p-3">
                    <i class="bi bi-cash-coin fs-1 text-primary"></i>
                    <h5 class="mt-3">Financement</h5>
                    <p>Aides pour lancer et gérer tes projets.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm p-3">
                    <i class="bi bi-heart-fill fs-1 text-primary"></i>
                    <h5 class="mt-3">Solidarité</h5>
                    <p>Un engagement pour plus de justice sociale.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paragraphe -->
<section id="paragraphe" class="py-5">
    <div class="container text-center">
        <p class="lead">
            <span class="blue-text">La FAGE</span>, c’est bien plus qu’une fédération :
            c’est un mouvement d’étudiants engagés pour d’autres étudiants.
        </p>

        <p class="lead">
            <span class="blue-text">Ensemble</span>, nous agissons pour une vie étudiante plus épanouissante,
            plus solidaire et plus juste.
        </p>

        <p class="lead">
            Parce qu’être <span class="blue-text">étudiant</span>, c’est aussi être acteur du changement — et
            <span class="blue-text">la FAGE</span> est là pour accompagner chaque pas vers cet avenir collectif.
        </p>

        <a href="https://www.helloasso.com/associations/federation-des-associations-generales-etudiantes-fage/formulaires/1" class="btn btn-donner mt-4">Faire un don</a>
    </div>
</section>
//
<?php require 'footer.php'?>
