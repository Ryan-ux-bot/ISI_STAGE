<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Messages</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>
    <p class="text-muted">Aucune conversation pour le moment.</p>
</div>

<?php include '../../includes/footer.php'; ?>
