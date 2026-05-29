<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id     = (int)$_GET['id'];
    // CORRECTION : 'refuser' (GET) → statut 'refuse' (DB)
    $status = ($_GET['action'] == 'valider') ? 'valide' : 'refuse';
    $pdo->prepare("UPDATE companies SET statut = ? WHERE id = ?")->execute([$status, $id]);
    header('Location: manage_companies.php');
    exit();
}

$companies = $pdo->query("SELECT * FROM companies ORDER BY id DESC")->fetchAll();
include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Gestion des Entreprises</h3>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Entreprise</th>
                <th>Secteur</th>
                <th>Ville</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($companies as $c): ?>
            <tr>
                <td><?php echo htmlspecialchars($c['nom_entreprise']); ?></td>
                <td><?php echo htmlspecialchars($c['secteur'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($c['ville'] ?? '-'); ?></td>
                <td>
                    <span class="badge <?php
                        echo ($c['statut'] == 'valide')  ? 'bg-success' :
                            (($c['statut'] == 'refuse') ? 'bg-danger' : 'bg-warning text-dark');
                    ?>">
                        <?php echo htmlspecialchars($c['statut']); ?>
                    </span>
                </td>
                <td>
                    <?php if($c['statut'] == 'en_attente'): ?>
                        <a href="?action=valider&id=<?php echo $c['id']; ?>" class="btn btn-primary btn-sm">Valider</a>
                        <a href="?action=refuser&id=<?php echo $c['id']; ?>" class="btn btn-outline-danger btn-sm">Refuser</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
