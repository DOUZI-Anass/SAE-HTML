<?php
// On démarre la session pour accéder à $_SESSION['benevole']
session_start();

// 1. Vérification de la connexion
if (!isset($_SESSION['benevole'])) {
    // Si l'utilisateur n'est pas connecté, on le renvoie à la connexion
    header('Location: connexion.php');
    exit;
}

// 2. Vérification de l'autorisation (rôle)
// On récupère le rôle, avec 'bénévole' comme valeur par défaut au cas où
$role_utilisateur = $_SESSION['benevole']['role'] ?? 'benevole';

if ($role_utilisateur !== 'administrateur') {
    header('Location: header.php');
    exit;
}


include 'header.php'; // Incluez votre en-tête HTML ici
?>
<form method="post" action="insert.php">

<div class="container" style="margin-top: 120px;">
    <h1>Espace Administration</h1>
    <p class="lead mb-5">Bienvenue jeune Fage! Vous pouvez gérer le contenu ici.</p>

    <div class="row">
        <div class="col-md-6 mb-5">
            <h2>Ajouter un Événement</h2>
            <form method="post" action="evenements.php">
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre_evenement" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date_evenement" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lieu</label>
                    <input type="text" name="lieu_evenement" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description_evenement" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter Événement</button>
            </form>
        </div>

        <div class="col-md-6 mb-5">
            <h2>Ajouter du Matériel</h2>
            <form method="post" action="traitement_materiel.php">
                <div class="mb-3">
                    <label class="form-label">Nom du Matériel</label>
                    <input type="text" name="nom_materiel" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantité</label>
                    <input type="number" name="quantite_materiel" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description_materiel" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Ajouter Matériel</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
