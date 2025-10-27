<?php
$page = 'evenements';
require 'header.php';
?>
<body class="evenement-page">

<!-- =========================
     BANNIÈRE / HERO
========================= -->
<section class="hero-evenement">
    <img src="/assets/image/evenement.png" alt="Congrès National de la FAGE" class="hero-image">
    <div class="hero-overlay">
        <h1>36ème Congrès National de la FAGE</h1>
        <p>Les associations au service de l’intérêt général — du 25 au 28 septembre 2025 à Paris</p>
        <a href="#" class="btn  mt-3">Découvrir l’événement</a>
    </div>
</section>

<!-- =========================
     DESCRIPTION PRINCIPALE
========================= -->
<section class="container py-5 mt-5">
    <h2 class="section-title text-center mb-4">36ème Congrès National de la FAGE</h2>
    <p class="lead text-center mb-4">
        La <strong>FAGE</strong> vous donne rendez-vous à son 36ème Congrès National, placé sous le thème :
        <em>« Les associations au service de l’intérêt général »</em>.
    </p>
    <p class="text-center">
        Chaque année, la FAGE rassemble les esprits dynamiques et engagés de la communauté étudiante
        pour un moment d’échanges, de formations et de débats autour des grands enjeux de la jeunesse.
        Cette édition se tiendra <strong>du 25 au 28 septembre 2025 à Paris</strong>, en partenariat avec l’<strong>AGEP</strong>.
    </p>
</section>

<!-- =========================
     SECTION INFORMATIONS
========================= -->
<section class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3>Un moment de rencontre et de démocratie</h3>
            <p>
                Depuis 1990, le Congrès National de la FAGE est un rendez-vous incontournable du réseau.
                Il réunit chaque année plus de 300 responsables associatifs venus de toute la France
                pour échanger, débattre et construire ensemble les projets de demain.
            </p>
            <p>
                Le Congrès se clôture par une <strong>Assemblée Générale Ordinaire</strong>, temps fort de la démocratie
                participative, où les grandes orientations du projet de la FAGE pour l’année à venir sont définies.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1200&q=80"
                 alt="Assemblée FAGE" class="imgM">
        </div>
    </div>
</section>

<!-- =========================
     SECTION FORMATION
========================= -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h3 class="mb-4">Montée en compétences par les pairs</h3>
        <p class="mb-4">
            La formation est un des temps forts du Congrès. Novices ou initié·es du monde associatif,
            chacun·e peut développer ses connaissances sur diverses thématiques : engagement, démocratie,
            précarité étudiante, handicap, transition écologique...
        </p>
        <p>
            L’objectif ? Donner à chaque militant·e les clés pour aider les jeunes à s’émanciper et
            faire bouger les lignes au sein de la société.
        </p>
    </div>
</section>

<!-- =========================
     SECTION ÉMANCIPATION
========================= -->
<section class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6 text-center">
            <img src="assets/image/evenement2.png"
                 alt="Débat FAGE" class="imgM">
        </div>
        <div class="col-md-6">
            <h3>Émancipation et engagement de la jeunesse</h3>
            <p>
                Le Congrès est aussi un espace de débat sur les enjeux politiques et sociaux
                qui concernent la jeunesse. Cette 36e édition mettra notamment en lumière
                la place des ONG et des associations face aux défis de demain.
            </p>
            <p>
                Ensemble, réfléchissons à la manière d’accompagner les jeunes vers plus d’autonomie
                et d’engagement, dans un monde en constante évolution.
            </p>
        </div>
    </div>
</section>

<!-- =========================
     SECTION INSCRIPTION
========================= -->
<section id="inscription" class="bg-light py-5">
    <div class="container text-center">
        <h3 class="mb-4">Inscriptions</h3>
        <p>
            Les inscriptions ouvrent le <strong>2 septembre 2025 à 18h</strong> sur la boutique de la FAGE.<br>
            <strong>Les places sont limitées !</strong>
        </p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <ul class="text-start">
                    <li>Tarif participant·e : 45€ (hébergement, restauration, formations et animations)</li>
                    <li>Tarif membre AGEP : 30€ (restauration, formations et animations)</li>
                    <li>Modes de paiement : CB ou virement bancaire (3 jours max après inscription)</li>
                </ul>

                <p class="mt-4">
                    <strong>Lien d'inscription :</strong><br>
                    <a href="https://fage.org/boutique/8819" target="_blank">fage.org/boutique/8819</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- =========================
     SECTION GALA
========================= -->
<section class="container py-5 text-center">
    <h3 class="mb-4">Assemblée Générale et Gala</h3>
    <p class="mb-4">
        L’Assemblée Générale marque la clôture du Congrès et la transition vers un nouveau mandat.
        Les membres de l’<strong>AAAF</strong> et les parents peuvent également participer à la soirée de Gala
        via la billetterie <strong>HelloAsso</strong>.
    </p>
    <p>
        <strong>Tarif Gala :</strong> 35€ (personnes en emploi) — 20€ (étudiant·es ou faible revenu)
    </p>
</section>

<?php require 'footer.php'; ?>
</body>
</html>
