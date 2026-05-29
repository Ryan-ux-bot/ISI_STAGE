<?php
session_start();
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4 shadow">
            <h2 class="text-center mb-4">Connexion Étudiant</h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                        if($_GET['error'] == 'auth')    echo "Email ou mot de passe incorrect.";
                        if($_GET['error'] == 'pending') echo "Votre compte est en attente de validation.";
                        if($_GET['error'] == 'refused') echo "Votre accès a été refusé.";
                    ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success">Inscription réussie ! Connectez-vous.</div>
            <?php endif; ?>

            <!-- CORRECTION : action pointe vers le bon fichier auth -->
            <form action="dashboard/student/auth_student.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email étudiant</label>
                    <input type="email" name="email" class="form-control" placeholder="ex: aziz@isi.tn" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login_student" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <hr>
            <p class="text-center">
                Connexion entreprise ? <a href="dashboard/company/login.php">Ici</a>
                &nbsp;|&nbsp;
                Pas encore de compte ? <a href="register.php">S'inscrire</a>
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
