<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] == 'valider') {
        $pdo->prepare("UPDATE students SET statut = 'valide' WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] == 'refuser') {
        $pdo->prepare("UPDATE students SET statut = 'refuse' WHERE id = ?")->execute([$id]);
    }
    header('Location: manage_students.php');
    exit();
}

$students = $pdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Gestion des Étudiants</h3>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <table class="table table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nom &amp; Prénom</th>
                <th>Email</th>
                <th>Filière</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['nom'] . " " . $s['prenom']); ?></td>
                <td><?php echo htmlspecialchars($s['email']); ?></td>
                <td><?php echo htmlspecialchars($s['filiere'] ?? '-'); ?></td>
                <td>
                    <span class="badge <?php
                        echo ($s['statut'] == 'valide')  ? 'bg-success' :
                            (($s['statut'] == 'refuse') ? 'bg-danger' : 'bg-warning text-dark');
                    ?>">
                        <?php echo htmlspecialchars($s['statut']); ?>
                    </span>
                </td>
                <td>
                    <?php if($s['statut'] == 'en_attente'): ?>
                        <a href="manage_students.php?action=valider&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-success">Valider</a>
                        <a href="manage_students.php?action=refuser&id=<?php echo $s['id']; ?>" class="btn btn-sm btn-danger">Refuser</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
