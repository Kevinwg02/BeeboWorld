<?php
include '../php/connexion.php';

$projet = $_GET['projet'] ?? '';
if (empty($projet)) {
    die("Projet introuvable.");
}

$stmt = $pdo->prepare("SELECT * FROM nano WHERE projet = ? ORDER BY date_ajout DESC");
$stmt->execute([$projet]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($projet) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><?= htmlspecialchars($projet) ?></h1>
        <a href="nano.php" class="btn btn-outline-secondary">← Retour</a>
    </div>

    <?php if (empty($entries)): ?>
        <div class="alert alert-warning text-center">Aucune entrée pour ce projet.</div>
    <?php endif; ?>

    <?php foreach ($entries as $entry): ?>
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="mb-2 text-muted small">
                    📅 <?= $entry['date_ajout'] ?> — ✍️ <?= $entry['nb_mots'] ?> mots
                </div>
                <?php if (!empty($entry['chapitre'])): ?>
                    <h5 class="card-title"><?= htmlspecialchars($entry['chapitre']) ?></h5>
                <?php endif; ?>
                <p class="card-text" style="white-space: pre-wrap;"><?= nl2br(htmlspecialchars($entry['contenu'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
