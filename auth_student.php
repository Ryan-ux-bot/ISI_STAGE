<?php
session_start();
// CORRECTION : chemin correct vers db.php (2 niveaux au-dessus)
include '../../includes/db.php';

if (isset($_POST['login_student'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch();

    // CORRECTION : utiliser password_verify pour les mots de passe hachés
    if ($student && password_verify($password, $student['password'])) {

        if ($student['statut'] === 'valide') {
            $_SESSION['student_id']     = $student['id'];
            $_SESSION['student_name']   = $student['nom'] . ' ' . $student['prenom'];
            $_SESSION['student_points'] = $student['points'];

            // CORRECTION : student_dashboard.php → dashboard.php
            header('Location: dashboard.php');
            exit();
        } else {
            // Compte en attente ou refusé
            header('Location: ../../login.php?error=pending');
            exit();
        }

    } else {
        header('Location: ../../login.php?error=auth');
        exit();
    }
}

// Si on arrive ici sans POST, retour login
header('Location: ../../login.php');
exit();
?>
