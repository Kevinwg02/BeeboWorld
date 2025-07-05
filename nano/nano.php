<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';


// On récupère la liste des projets avec leur ID et nom
$stmt = $pdo->query("SELECT id, nom FROM projets ORDER BY nom ASC");
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
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">📚 Beeboworld</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Section Nano -->
                <li class="nav-item">
                    <a class="nav-link" href="/nano/nano.php">✍️ Nano Projets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nano/nanoadd.php">➕ Ajouter Nano</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- Section Admin -->
                <li class="nav-item">
                    <a class="nav-link" href="/private/admin_book.php">🛠️ Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/stats.php">📊 Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/library.php">📚 Library</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/add_manual.php">➕ Ajout manuel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn" data-bs-toggle="modal" data-bs-target="#pagesModal" href="#">📖 Pages lues</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <div class="container py-5">
        <h1 class="mb-5 text-center">🗂️ Mes projets</h1>

        <?php if (empty($projects)): ?>
            <div class="alert alert-info text-center">Aucun projet enregistré.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($projects as $projet): ?>
                    <?php
                    // Récupérer le total des mots pour ce projet
                    $stmt = $pdo->prepare("SELECT SUM(nb_mots) as total_mots FROM nano WHERE projet_id = ?");
                    $stmt->execute([$projet['id']]);
                    $total = $stmt->fetchColumn() ?: 0;
                    ?>
                    <div class="col">
                        <a href="nanoproject.php?projet_id=<?= $projet['id'] ?>" class="text-decoration-none">
                            <div class="card project-card h-100 border-0 bg-white shadow-sm">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-2"><?= htmlspecialchars($projet['nom']) ?></h5>
                                    <p class="text-muted"><?= $total ?> mots au total</p>
                                    <span class="badge bg-primary">Voir le contenu</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Ajout Pages Lues -->
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
</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</html>