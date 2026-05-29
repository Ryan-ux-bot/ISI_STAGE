<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$message = "";

if (isset($_POST['add_reward'])) {
    $student_id   = (int)$_POST['student_id'];
    $points       = (int)$_POST['points'];
    $badge        = htmlspecialchars(trim($_POST['badge']));
    $remuneration = htmlspecialchars(trim($_POST['remuneration']));

    try {
        $pdo->beginTransaction();

        $stmt1 = $pdo->prepare("INSERT INTO rewards (student_id, points, badge, remuneration_symbolique) VALUES (?, ?, ?, ?)");
        $stmt1->execute([$student_id, $points, $badge, $remuneration]);

        $stmt2 = $pdo->prepare("UPDATE students SET points = points + ? WHERE id = ?");
        $stmt2->execute([$points, $student_id]);

        $pdo->commit();
        $message = "Récompense attribuée avec succès !";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Erreur lors de l'attribution : " . $e->getMessage();
    }
}

$all_students    = $pdo->query("SELECT id, nom, prenom, points FROM students ORDER BY nom ASC")->fetchAll();
$rewards_history = $pdo->query("
    SELECT r.*, s.nom, s.prenom 
    FROM rewards r 
    JOIN students s ON r.student_id = s.id 
    ORDER BY r.id DESC LIMIT 10
")->fetchAll();

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Gestion des Récompenses</h3>
        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">Attribuer une Récompense</div>
                <div class="card-body">
                    <?php if($message): ?>
                        <div class="alert alert-info small"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="rewards.php">
                        <div class="mb-3">
                            <label class="form-label small">Étudiant</label>
                            <select name="student_id" class="form-select form-select-sm" required>
                                <option value="">Choisir un étudiant...</option>
                                <?php foreach($all_students as $st): ?>
                                    <option value="<?php echo $st['id']; ?>">
                                        <?php echo htmlspecialchars($st['nom'] . " " . $st['prenom']); ?>
                                        (<?php echo $st['points']; ?> pts)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Points à ajouter</label>
                            <input type="number" name="points" class="form-control form-control-sm" value="0" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Badge</label>
                            <input type="text" name="badge" class="form-control form-control-sm" placeholder="ex: Top Développeur">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Rémunération symbolique</label>
                            <input type="text" name="remuneration" class="form-control form-control-sm" placeholder="ex: Bon d'achat 20DT">
                        </div>
                        <button type="submit" name="add_reward" class="btn btn-primary btn-sm w-100">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">Dernières Récompenses</div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Points</th>
                                <th>Badge</th>
                                <th>Rémunération</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($rewards_history)): ?>
                                <tr><td colspan="4" class="text-center py-3">Aucune récompense pour le moment.</td></tr>
                            <?php endif; ?>
                            <?php foreach($rewards_history as $rh): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rh['nom'] . " " . $rh['prenom']); ?></td>
                                <td>+<?php echo $rh['points']; ?></td>
                                <td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars($rh['badge']); ?></span></td>
                                <td class="small text-muted"><?php echo htmlspecialchars($rh['remuneration_symbolique']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
