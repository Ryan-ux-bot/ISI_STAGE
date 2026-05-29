<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Espace Étudiant — <?php echo htmlspecialchars($_SESSION['student_name']); ?></h2>
        <a href="../../logout.php" class="btn btn-outline-danger">Déconnexion</a>
    </div>

    <p class="text-muted">Points accumulés : <strong><?php echo $_SESSION['student_points'] ?? 0; ?></strong></p>

    <div class="list-group">
        <a href="stages.php" class="list-group-item list-group-item-action">📋 Consulter les stages disponibles</a>
        <a href="profile.php" class="list-group-item list-group-item-action">👤 Mon profil</a>
        <a href="messages.php" class="list-group-item list-group-item-action">💬 Messages</a>
        <a href="complaints.php" class="list-group-item list-group-item-action">📢 Réclamations</a>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
