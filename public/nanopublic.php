<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /index.php');  // ← corrige bien le chemin
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';
// Récupère tous les projets avec infos de base
$stmt = $pdo->query("SELECT id, nom, couverture, date_debut, date_fin, etat, resume FROM projets ORDER BY nom ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pour chaque projet, on ajoute ses thèmes
foreach ($projects as &$projet) {
    $stmtThemes = $pdo->prepare("
        SELECT t.nom 
        FROM themes t 
        JOIN projets_themes pt ON pt.theme_id = t.id 
        WHERE pt.projet_id = ?
        ORDER BY t.nom
    ");
    $stmtThemes->execute([$projet['id']]);
    $projet['themes'] = $stmtThemes->fetchAll(PDO::FETCH_COLUMN);
}
unset($projet); // bonne pratique pour éviter les effets de bord
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

    <div class="container py-4">
        <a href="/index.php" class="btn btn-primary mb-2">📚 Library</a>
        <a href="/public/public_stats.php" class="btn btn-warning mb-2">📊 Stats</a>
        <a href="/public/nanopublicstats.php" class="btn btn-success mb-2">📊 Nano Stats</a>
        <a href="/public/nanopublic.php" class="btn btn-primary mb-2">📊 Nano</a>
    </div>
    <div class="container py-5">
        <h1 class="mb-5 text-center">🗂️ Mes projets</h1>

        <?php if (empty($projects)): ?>
            <div class="alert alert-info text-center">Aucun projet enregistré.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($projects as $projet): ?>
                    <?php
                    // Total mots pour le projet
                    $stmt = $pdo->prepare("SELECT SUM(nb_mots) FROM nano WHERE projet_id = ?");
                    $stmt->execute([$projet['id']]);
                    $total = $stmt->fetchColumn() ?: 0;
                    ?>
                    <div class="col">
                        <div class="card project-card h-100 border-0 bg-white shadow-sm">
                            <?php if (!empty($projet['couverture'])): ?>
                                <img src="<?= htmlspecialchars($projet['couverture']) ?>" class="card-img-top" style="max-height: 200px; object-fit: cover;" alt="Couverture">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($projet['nom']) ?></h5>
                                <p class="text-muted mb-1"><?= $total ?> mots au total</p>
                                <p class="mb-1">
                                    <strong>Thèmes :</strong>
                                    <?php if (!empty($projet['themes'])): ?>
                                        <span class="badge bg-secondary me-1"><?= implode('</span> <span class="badge bg-secondary me-1">', array_map('htmlspecialchars', $projet['themes'])) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Aucun</span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-1"><strong>Dates :</strong> <?= htmlspecialchars($projet['date_debut']) ?> → <?= htmlspecialchars($projet['date_fin']) ?></p>
                                <p class="mb-1"><strong>État :</strong> <?= htmlspecialchars($projet['etat']) ?></p>

                                <button class="btn btn-sm btn-outline-secondary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#resume<?= $projet['id'] ?>">
                                    📖 Voir le résumé
                                </button>
                                <a href="nanopublicproject.php?projet_id=<?= $projet['id'] ?>" class="btn btn-sm btn-primary mt-2">🔎 Voir le projet</a>

                                <div class="collapse mt-2" id="resume<?= $projet['id'] ?>">
                                    <p class="small"><?= nl2br(htmlspecialchars($projet['resume'])) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Pages lues -->
    <div class="modal fade" id="pagesModal" tabindex="-1" aria-labelledby="pagesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="pages_lu.php" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pagesModalLabel">Ajouter des pages lues</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="pages" class="form-label">Nombre de pages lues</label>
                        <input type="number" class="form-control" name="pages" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>