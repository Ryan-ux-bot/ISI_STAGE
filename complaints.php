<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['cloturer'])) {
    $pdo->prepare("UPDATE complaints SET statut = 'traitee' WHERE id = ?")
        ->execute([(int)$_GET['cloturer']]);
    header('Location: complaints.php');
    exit();
}

$complaints = $pdo->query("
    SELECT c.*, s.nom, s.prenom 
    FROM complaints c 
    JOIN students s ON c.student_id = s.id 
    WHERE c.statut = 'ouverte'
")->fetchAll();

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Réclamations Étudiants</h3>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if(empty($complaints)): ?>
        <div class="alert alert-success">Aucune réclamation ouverte.</div>
    <?php endif; ?>

    <ul class="list-group mt-3">
        <?php foreach($complaints as $com): ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold"><?php echo htmlspecialchars($com['nom'] . " " . $com['prenom']); ?></div>
                <?php echo htmlspecialchars($com['contenu']); ?>
            </div>
            <a href="?cloturer=<?php echo $com['id']; ?>" class="btn btn-sm btn-outline-success">
                Marquer comme traitée
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include '../includes/footer.php'; ?>
