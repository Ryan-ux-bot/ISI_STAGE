<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../../includes/db.php';

$message = "";
$stmt = $pdo->prepare("SELECT * FROM companies WHERE id = ?");
$stmt->execute([$_SESSION['company_id']]);
$company = $stmt->fetch();

if (isset($_POST['update'])) {
    $secteur = htmlspecialchars(trim($_POST['secteur']));
    $ville   = htmlspecialchars(trim($_POST['ville']));
    $desc    = htmlspecialchars(trim($_POST['description']));

    $pdo->prepare("UPDATE companies SET secteur = ?, ville = ?, description = ? WHERE id = ?")
        ->execute([$secteur, $ville, $desc, $_SESSION['company_id']]);
    $message = "Profil mis à jour.";
}

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Profil Entreprise</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="profile.php">
        <div class="mb-3">
            <label class="form-label">Secteur d'activité</label>
            <input type="text" name="secteur" class="form-control"
                   placeholder="ex: Informatique, Finance..."
                   value="<?php echo htmlspecialchars($company['secteur'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Ville</label>
            <input type="text" name="ville" class="form-control"
                   placeholder="ex: Tunis"
                   value="<?php echo htmlspecialchars($company['ville'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Description de l'entreprise</label>
            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($company['description'] ?? ''); ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-main">Mettre à jour</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
