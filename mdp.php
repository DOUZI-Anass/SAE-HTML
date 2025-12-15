<?php
// ----------------------------------------------------
// ⚠️ Remplacez 'VOTRE_MOT_DE_PASSE_SECRET' par le mot de passe que vous voulez pour l'administrateur
$mdp_admin_clair = 'Leboss';
// ----------------------------------------------------

$hash = password_hash($mdp_admin_clair, PASSWORD_DEFAULT);

echo "Le mot de passe en clair est : " . $mdp_admin_clair . "<br>";
echo "Le HASH pour la BDD est : <strong>" . $hash . "</strong><br><br>";
echo "Copiez cette chaîne (le HASH) et utilisez-la pour la prochaine étape SQL.";
?>