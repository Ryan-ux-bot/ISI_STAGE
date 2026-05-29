<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
require_once '../../includes/db.php';

$message = "";
$student  = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$student->execute([$_SESSION['student_id']]);
$student  = $student->fetch();

// CORRECTION : formulaire avec method, action et traitement
if (isset($_POST['update'])) {
    $competences = htmlspecialchars(trim($_POST['competences']));
    $langues     = htmlspecialchars(trim($_POST['langues']));
    $certificats = htmlspecialchars(trim($_POST['certificats']));

    $pdo->prepare("UPDATE students SET competences = ?, langues = ?, certificats = ? WHERE id = ?")
        ->execute([$competences, $langues, $certificats, $_SESSION['student_id']]);
    $message = "Profil mis à jour avec succès.";
}

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mon Profil</h2>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- CORRECTION : method="POST" et action ajoutés -->
    <form method="POST" action="profile.php">
        <div class="mb-3">
            <label class="form-label">Compétences</label>
            <input type="text" name="competences" class="form-control"
                   placeholder="ex: PHP, MySQL, Bootstrap..."
                   value="<?php echo htmlspecialchars($student['competences'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Langues</label>
            <input type="text" name="langues" class="form-control"
                   placeholder="ex: Français, Anglais..."
                   value="<?php echo htmlspecialchars($student['langues'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Certificats</label>
            <input type="text" name="certificats" class="form-control"
                   placeholder="ex: CCNA, TOEFL..."
                   value="<?php echo htmlspecialchars($student['certificats'] ?? ''); ?>">
        </div>
        <button type="submit" name="update" class="btn btn-main">Mettre à jour</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
