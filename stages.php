<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
require_once '../../includes/db.php';

// Récupérer les stages validés par l'admin
$stages = $pdo->query("
    SELECT i.*, c.nom_entreprise 
    FROM internships i 
    JOIN companies c ON i.company_id = c.id 
    WHERE i.validation_admin = 1 
    ORDER BY i.id DESC
")->fetchAll();

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Stages disponibles</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if(empty($stages)): ?>
        <div class="alert alert-info">Aucun stage disponible pour le moment.</div>
    <?php endif; ?>

    <?php foreach($stages as $stg): ?>
    <div class="card p-3 mb-3 shadow-sm">
        <h4><?php echo htmlspecialchars($stg['titre']); ?></h4>
        <p class="text-muted">Entreprise : <?php echo htmlspecialchars($stg['nom_entreprise']); ?>
            <?php if(!empty($stg['localisation'])): ?> — <?php echo htmlspecialchars($stg['localisation']); ?><?php endif; ?>
        </p>
        <p><?php echo htmlspecialchars(substr($stg['description'], 0, 200)); ?>...</p>
        <a href="apply.php?stage_id=<?php echo $stg['id']; ?>" class="btn btn-main">Postuler</a>
    </div>
    <?php endforeach; ?>
</div>

<?php include '../../includes/footer.php'; ?>
