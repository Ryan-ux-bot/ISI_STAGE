<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['valider'])) {
    $pdo->prepare("UPDATE internships SET validation_admin = 1 WHERE id = ?")
        ->execute([(int)$_GET['valider']]);
    // CORRECTION : manage_internships.php → manage_stages.php
    header('Location: manage_stages.php');
    exit();
}

$stages = $pdo->query("
    SELECT i.*, c.nom_entreprise 
    FROM internships i 
    JOIN companies c ON i.company_id = c.id 
    WHERE i.validation_admin = 0
")->fetchAll();

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Offres de Stage en Attente</h3>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if(empty($stages)): ?>
        <div class="alert alert-info">Aucune offre en attente de validation.</div>
    <?php endif; ?>

    <div class="row">
        <?php foreach($stages as $stg): ?>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($stg['titre']); ?></h5>
                    <p class="text-muted">
                        <?php echo htmlspecialchars($stg['nom_entreprise']); ?>
                        - <?php echo htmlspecialchars($stg['localisation'] ?? ''); ?>
                    </p>
                    <p><?php echo htmlspecialchars(substr($stg['description'], 0, 100)); ?>...</p>
                    <a href="?valider=<?php echo $stg['id']; ?>" class="btn btn-success">Valider l'offre</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
