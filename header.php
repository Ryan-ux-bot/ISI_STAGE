<?php
// Calcul du chemin de base dynamique selon la profondeur du fichier appelant
$depth = substr_count(str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'])), '/') 
       - substr_count(str_replace('\\', '/', realpath(__DIR__ . '/..')), '/');
$base = str_repeat('../', $depth);

require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI STAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark custom-nav">
    <div class="container">
        <a class="navbar-brand logo" href="<?php echo $base; ?>index.php">ISI STAGE</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>login.php">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>register.php">Inscription</a></li>
            </ul>
        </div>
    </div>
</nav>
