<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: ../../login.php');
    exit();
}
require_once '../../includes/db.php';

$stage_id = isset($_GET['stage_id']) ? (int)$_GET['stage_id'] : 0;
$message  = "";

// CORRECTION : formulaire avec method et action + traitement
if (isset($_POST['postuler'])) {
    $motivation = htmlspecialchars(trim($_POST['motivation']));
    $sid        = (int)$_POST['stage_id'];
    $student_id = $_SESSION['student_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO applications (student_id, internship_id, motivation) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $sid, $motivation]);
        $message = "Candidature envoyée avec succès !";
    } catch (PDOException $e) {
        $message = "Erreur : vous avez peut-être déjà postulé à ce stage.";
    }
}

include '../../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Postuler à un stage</h2>
        <a href="stages.php" class="btn btn-sm btn-outline-secondary">← Retour aux stages</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- CORRECTION : method="POST" et action ajoutés -->
    <form method="POST" action="apply.php">
        <input type="hidden" name="stage_id" value="<?php echo $stage_id; ?>">
        <div class="mb-3">
            <label class="form-label">Lettre de motivation</label>
            <textarea name="motivation" class="form-control mb-3" rows="6" placeholder="Expliquez pourquoi vous postulez à ce stage..." required></textarea>
        </div>
        <button type="submit" name="postuler" class="btn btn-main">Envoyer ma candidature</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
