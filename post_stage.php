<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../../includes/db.php';

$message = "";

// CORRECTION : traitement du formulaire (method + action)
if (isset($_POST['publier'])) {
    $titre       = htmlspecialchars(trim($_POST['titre']));
    $duree       = htmlspecialchars(trim($_POST['duree']));
    $description = htmlspecialchars(trim($_POST['description']));
    $localisation = htmlspecialchars(trim($_POST['localisation']));
    $company_id  = $_SESSION['company_id'];

    if ($titre && $description) {
        $pdo->prepare("INSERT INTO internships (company_id, titre, duree, description, localisation, validation_admin) VALUES (?, ?, ?, ?, ?, 0)")
            ->execute([$company_id, $titre, $duree, $description, $localisation]);
        $message = "Offre publiée ! Elle sera visible après validation par l'administration.";
    }
}

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Publier une offre de stage</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- CORRECTION : method="POST" et action ajoutés -->
    <form method="POST" action="post_stage.php">
        <div class="mb-3">
            <label class="form-label">Titre du stage</label>
            <input type="text" name="titre" class="form-control" placeholder="ex: Développeur Web PHP" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Durée</label>
            <input type="text" name="duree" class="form-control" placeholder="ex: 2 mois" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Localisation</label>
            <input type="text" name="localisation" class="form-control" placeholder="ex: Tunis">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Décrivez le poste, les missions, les compétences requises..." required></textarea>
        </div>
        <button type="submit" name="publier" class="btn btn-main">Publier l'offre</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
