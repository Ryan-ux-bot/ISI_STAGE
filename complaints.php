<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
require_once '../../includes/db.php';

$message = "";

// CORRECTION : formulaire avec method, action et traitement
if (isset($_POST['envoyer'])) {
    $contenu    = htmlspecialchars(trim($_POST['contenu']));
    $student_id = $_SESSION['student_id'];

    if (!empty($contenu)) {
        $pdo->prepare("INSERT INTO complaints (student_id, contenu, statut) VALUES (?, ?, 'ouverte')")
            ->execute([$student_id, $contenu]);
        $message = "Réclamation envoyée avec succès.";
    }
}

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Soumettre une Réclamation</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- CORRECTION : method="POST" et action ajoutés -->
    <form method="POST" action="complaints.php">
        <div class="mb-3">
            <label class="form-label">Votre réclamation</label>
            <textarea name="contenu" class="form-control mb-3" rows="5" placeholder="Décrivez votre problème..." required></textarea>
        </div>
        <button type="submit" name="envoyer" class="btn btn-danger">Envoyer la réclamation</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
