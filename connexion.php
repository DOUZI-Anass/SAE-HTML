<?php
global $pdo;
session_start();
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp   = $_POST['mdp'] ?? '';

    if ($email === '' || $mdp === '') {
        $errors[] = "Email et mot de passe sont obligatoires.";
    } else {
        // NOTE: $pdo est disponible grâce à require 'config.php' si config.php définit $pdo.
        $stmt = $pdo->prepare("SELECT * FROM benevole WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Vérification de l'utilisateur et du mot de passe haché
        if (!$user || !password_verify($mdp, $user['mdp'])) {
            $errors[] = "Identifiants incorrects.";
        } else {

            // --- C'EST LA PARTIE CORRIGÉE ET SIMPLIFIÉE ---

            // Le rôle est lu directement depuis la BDD ($user['role']).
            // Si l'utilisateur a 'administrateur' dans la BDD, c'est ce qui sera utilisé.
            $role_utilisateur = $user['role'] ?? 'bénévole';

            $_SESSION['benevole'] = [
                    'id_benevole' => $user['id_benevole'],
                    'nom'         => $user['nom'],
                    'prenom'      => $user['prenom'],
                    'email'       => $user['email'],
                    'role'        => $role_utilisateur
            ];

            // --- FIN DE LA MODIFICATION ---

            header('Location: index.php');
            exit;
        }
    }
}

$page = 'autre';
include 'header.php';
?>

    <div class="container" style="margin-top: 120px;">
        <h1>Connexion</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="mt-4" style="max-width: 400px;">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="mdp" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

<?php include 'footer.php'; ?>