<?php
include '../php/connexion.php';

$stmt = $pdo->query("SELECT projet, SUM(nb_mots) as total_mots FROM nano GROUP BY projet ORDER BY projet ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes projets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .project-card:hover {
            transform: scale(1.03);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-5 text-center">🗂️ Mes projets</h1>

    <?php if (empty($projects)): ?>
        <div class="alert alert-info text-center">Aucun projet enregistré.</div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($projects as $projet): ?>
            <div class="col">
                <a href="nanoproject.php?projet=<?= urlencode($projet['projet']) ?>" class="text-decoration-none">
                    <div class="card project-card h-100 border-0 bg-white shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-2"><?= htmlspecialchars($projet['projet']) ?></h5>
                            <p class="text-muted"><?= $projet['total_mots'] ?> mots au total</p>
                            <span class="badge bg-primary">Voir le contenu</span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
