<?php
session_start();
include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4 shadow">
            <h2 class="text-center mb-4">Connexion Entreprise</h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                        if($_GET['error'] == 'auth')    echo "Email ou mot de passe incorrect.";
                        if($_GET['error'] == 'pending') echo "Votre compte est en attente de validation par l'administration.";
                        if($_GET['error'] == 'refused') echo "Votre accès a été refusé.";
                    ?>
                </div>
            <?php endif; ?>

            <form action="auth_company.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="contact@entreprise.tn" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" name="login_company" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <p class="text-center mt-3">
                Pas encore de compte ? <a href="../../register.php">Créer un compte</a>
            </p>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
