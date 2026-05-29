<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../../includes/db.php';

// Traitement : accepter ou refuser une candidature
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id     = (int)$_GET['id'];
    $status = ($_GET['action'] == 'accepter') ? 'acceptee' : 'refusee';
    $pdo->prepare("UPDATE applications SET statut = ? WHERE id = ?")
        ->execute([$status, $id]);
    header('Location: applicants.php');
    exit();
}

// Récupérer les candidatures pour cette entreprise
$applications = $pdo->query("
    SELECT a.*, s.nom, s.prenom, s.email, i.titre 
    FROM applications a
    JOIN students s ON a.student_id = s.id
    JOIN internships i ON a.internship_id = i.id
    WHERE i.company_id = " . (int)$_SESSION['company_id'] . "
    ORDER BY a.id DESC
")->fetchAll();

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Candidatures reçues</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if(empty($applications)): ?>
        <div class="alert alert-info">Aucune candidature reçue pour le moment.</div>
    <?php endif; ?>

    <?php foreach($applications as $app): ?>
    <div class="card p-3 mb-3 shadow-sm">
        <h5><?php echo htmlspecialchars($app['nom'] . ' ' . $app['prenom']); ?></h5>
        <p class="text-muted">Stage : <?php echo htmlspecialchars($app['titre']); ?> | Email : <?php echo htmlspecialchars($app['email']); ?></p>
        <p><?php echo htmlspecialchars($app['motivation'] ?? ''); ?></p>
        <?php if(($app['statut'] ?? 'en_attente') == 'en_attente'): ?>
            <a href="?action=accepter&id=<?php echo $app['id']; ?>" class="btn btn-success btn-sm">Accepter</a>
            <a href="?action=refuser&id=<?php echo $app['id']; ?>" class="btn btn-danger btn-sm">Refuser</a>
        <?php else: ?>
            <span class="badge bg-<?php echo ($app['statut'] == 'acceptee') ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($app['statut']); ?>
            </span>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<?php include '../../includes/footer.php'; ?>
