<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: login.php');
    exit();
}
include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Espace Entreprise — <?php echo htmlspecialchars($_SESSION['company_name']); ?></h2>
        <a href="../../logout.php" class="btn btn-outline-danger">Déconnexion</a>
    </div>

    <div class="list-group">
        <a href="post_stage.php" class="list-group-item list-group-item-action">➕ Publier une offre de stage</a>
        <!-- CORRECTION : apllicants.php → applicants.php -->
        <a href="applicants.php" class="list-group-item list-group-item-action">👥 Candidatures reçues</a>
        <a href="messages.php" class="list-group-item list-group-item-action">💬 Messages</a>
        <a href="profile.php" class="list-group-item list-group-item-action">🏢 Profil entreprise</a>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
