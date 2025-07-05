<?php
include '../php/connexion.php';

$projet_id = $_GET['projet_id'] ?? null;
if (!$projet_id || !is_numeric($projet_id)) {
    die("Projet introuvable.");
}

$stmt = $pdo->prepare("SELECT nom FROM projets WHERE id = ?");
$stmt->execute([$projet_id]);
$projet = $stmt->fetchColumn();

if (!$projet) {
    die("Projet non trouvé.");
}

$stmt = $pdo->prepare("SELECT * FROM nano WHERE projet_id = ? ORDER BY chapitre ASC");
$stmt->execute([$projet_id]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Extraire la liste unique des chapitres
$chapitres = array_unique(array_map(fn($e) => $e['chapitre'], $entries));
sort($chapitres);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($projet) ?> - Chapitres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><?= htmlspecialchars($projet) ?></h1>
            <div>
                <a href="nanoadd.php?projet_id=<?= $projet_id ?>" class="btn btn-outline-primary me-2">📘 Ajout Projet</a>
                <a href="nano.php" class="btn btn-outline-secondary">← Retour</a>
            </div>
        </div>

        <?php if (empty($entries)): ?>
            <div class="alert alert-warning text-center">Aucune entrée pour ce projet.</div>
        <?php else: ?>

            <!-- Filtre par chapitre -->
            <div class="mb-4">
                <label for="chapterFilter" class="form-label fw-semibold">Filtrer par chapitre :</label>
                <select id="chapterFilter" class="form-select">
                    <option value="">— Tous les chapitres —</option>
                    <?php foreach ($chapitres as $chap): ?>
                        <option value="<?= htmlspecialchars($chap) ?>"><?= htmlspecialchars($chap) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Liste des chapitres -->
            <div id="chapterContainer">
                <?php foreach ($entries as $entry): ?>
                    <div class="card mb-4 shadow-sm border-0 chapter-block" data-chapitre="<?= htmlspecialchars($entry['chapitre']) ?>">
                        <div class="card-body">
                            <div class="mb-2 text-muted small">
                                📅 <?= $entry['date_ajout'] ?> — ✍️ <?= $entry['nb_mots'] ?> mots
                            </div>
                            <h4 class="text-center fw-bold mb-3"><?= htmlspecialchars($entry['chapitre']) ?></h4>
                            <p class="card-text" style="white-space: pre-wrap;"><?= nl2br(htmlspecialchars($entry['contenu'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('chapterFilter').addEventListener('change', function() {
            const selected = this.value;
            document.querySelectorAll('.chapter-block').forEach(card => {
                const chap = card.getAttribute('data-chapitre');
                card.style.display = (selected === '' || selected === chap) ? 'block' : 'none';
            });
        });
    </script>

</body>

</html>