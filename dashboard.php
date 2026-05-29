<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$count_students       = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$count_companies      = $pdo->query("SELECT COUNT(*) FROM companies")->fetchColumn();
// CORRECTION : lien et requête vers manage_stages (table internships)
$count_pending_stages = $pdo->query("SELECT COUNT(*) FROM internships WHERE validation_admin = 0")->fetchColumn();

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tableau de Bord Administrateur</h2>
        <a href="../logout.php" class="btn btn-outline-danger">Déconnexion</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4 shadow">
                <div class="card-body">
                    <h5>Étudiants inscrits</h5>
                    <h3><?php echo $count_students; ?></h3>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="manage_students.php">Voir détails</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4 shadow">
                <div class="card-body">
                    <h5>Entreprises partenaires</h5>
                    <h3><?php echo $count_companies; ?></h3>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="manage_companies.php">Voir détails</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark mb-4 shadow">
                <div class="card-body">
                    <h5>Stages en attente</h5>
                    <h3><?php echo $count_pending_stages; ?></h3>
                </div>
                <!-- CORRECTION : manage_internships.php → manage_stages.php -->
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-dark stretched-link" href="manage_stages.php">Valider les stages</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <a href="complaints.php" class="btn btn-outline-secondary w-100 mb-2">Réclamations étudiants</a>
        </div>
        <div class="col-md-6">
            <a href="rewards.php" class="btn btn-outline-warning w-100 mb-2">Récompenses</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
