<?php
session_start();
// CORRECTION : db_connect.php → db.php, chemin correct
include '../../includes/db.php';

if (isset($_POST['login_company'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM companies WHERE email = ?");
    $stmt->execute([$email]);
    $company = $stmt->fetch();

    // CORRECTION : utiliser password_verify pour les mots de passe hachés
    if ($company && password_verify($password, $company['password'])) {

        if ($company['statut'] === 'valide') {
            $_SESSION['company_id']   = $company['id'];
            $_SESSION['company_name'] = $company['nom_entreprise'];
            // CORRECTION : index.php → dashboard.php
            header('Location: dashboard.php');
            exit();
        } elseif ($company['statut'] === 'en_attente') {
            header('Location: login.php?error=pending');
            exit();
        } else {
            header('Location: login.php?error=refused');
            exit();
        }

    } else {
        header('Location: login.php?error=auth');
        exit();
    }
}

// Si accès direct sans POST
header('Location: login.php');
exit();
?>
