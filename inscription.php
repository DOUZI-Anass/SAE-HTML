<?php
global $pdo;
session_start();
require 'config.php';

$errors = [];

if (isset($_SESSION['benevole'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = trim($_POST['nom'] );
    $prenom = trim($_POST['prenom']);
    $email  = trim($_POST['email'] );
    $mdp    = $_POST['mdp'] ;
    $mdp2   = $_POST['mdp2'];

    if ($nom === '' || $prenom === '' || $email === '' || $mdp === '' || $mdp2 === '') {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if ($mdp !== $mdp2) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }


    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id_benevole FROM benevole WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Un compte existe déjà avec cet email.";
        }
    }


    if (empty($errors)) {
    $hash = password_hash($mdp, PASSWORD_DEFAULT); // <-- 🎯 LE HACHAGE DOIT ÊTRE ICI !

    $stmt = $pdo->prepare("
        INSERT INTO benevole (nom, prenom, email, mdp)
        VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $hash]); // <-- Le HASH ($hash) DOIT ÊTRE UTILISÉ ICI !

        // Récupération de l'id
        $id = $pdo->lastInsertId();

        // Stocker les infos utiles en session
        $_SESSION['benevole'] = [
                'id_benevole' => $id,
                'nom'         => $nom,
                'prenom'      => $prenom,
                'email'       => $email,
                'role'        => 'bénévole' // <--- AJOUTEZ CETTE LIGNE
        ];

        // Redirection vers l'accueil
        header('Location: index.php');
        exit;
    }
}

// visuel a changer  et méthode post fonctionnel
$page = 'autre';
include 'header.php';
?>

<div class="container" style="margin-top: 120px; margin-bottom: 80px;">
    <h1>Inscription bénévole</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-4" style="max-width: 500px;">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control"
                   required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control"
                   required value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-control"
                   required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="mdp2" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer mon compte</button>
    </form>
</div>

<?php include 'footer.php'; ?>
