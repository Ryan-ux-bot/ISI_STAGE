<?php
include 'includes/db.php';

$message = "";

if (isset($_POST['register'])) {
    $nom      = htmlspecialchars(trim($_POST['nom']));
    $prenom   = htmlspecialchars(trim($_POST['prenom']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // CORRECTION : hachage du mot de passe
    $role     = $_POST['role'];

    try {
        if ($role === 'student') {
            $sql  = "INSERT INTO students (nom, prenom, email, password, statut) VALUES (?, ?, ?, ?, 'en_attente')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $email, $password]);
        } else {
            $sql  = "INSERT INTO companies (nom_entreprise, email, password, statut) VALUES (?, ?, ?, 'en_attente')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $email, $password]);
        }

        header('Location: login.php?success=1');
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "Erreur : Cet email est déjà utilisé.";
        } else {
            $message = "Une erreur est survenue lors de l'inscription.";
        }
    }
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="col-md-8 mx-auto">
        <div class="card p-4 shadow">
            <h2 class="text-center mb-4">Créer un compte</h2>

            <?php if(!empty($message)): ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nom / Nom Entreprise</label>
                        <input type="text" name="nom" class="form-control mb-3" placeholder="Nom" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénom (si étudiant)</label>
                        <input type="text" name="prenom" class="form-control mb-3" placeholder="Prénom">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Professionnel / Étudiant</label>
                    <input type="email" name="email" class="form-control" placeholder="exemple@domaine.tn" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Vous êtes :</label>
                    <select name="role" class="form-select" required>
                        <option value="student">Étudiant</option>
                        <option value="company">Entreprise</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required minlength="6">
                </div>

                <button type="submit" name="register" class="btn btn-primary w-100 py-2">
                    S'inscrire sur ISI-STAGE
                </button>
            </form>

            <hr>
            <p class="text-center mt-3">
                Déjà un compte ? <a href="login.php">Connectez-vous ici</a>
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
