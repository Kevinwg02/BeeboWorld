<?php


include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

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
    <div class="container py-4">
        <a href="/index.php" class="btn btn-primary mb-2">📚 Library</a>
        <a href="/public/public_stats.php" class="btn btn-warning mb-2">📊 Stats</a>
        <a href="/public/nanopublicstats.php" class="btn btn-success mb-2">📊 Nano Stats</a>
          <a href="/public/nanopublic.php" class="btn btn-primary mb-2">📊 Nano</a>
    </div>
    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><?= htmlspecialchars($projet) ?></h1>
            <div>
                <a href="/public/nanopublic.php" class="btn btn-sm btn-secondary mt-2">← Retour</a>
            </div>
        </div>


        <?php if (empty($entries)): ?>
            <div class="alert alert-warning text-center">Aucune entrée pour ce projet.</div>
        <?php else: ?>

            <div class="mb-4">
                <label for="chapterFilter" class="form-label fw-semibold">Filtrer par chapitre :</label>
                <select id="chapterFilter" class="form-select">
                    <option value="">— Tous les chapitres —</option>
                    <?php foreach ($chapitres as $chap): ?>
                        <option value="<?= htmlspecialchars($chap) ?>"><?= htmlspecialchars($chap) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="chapterContainer">
                <?php foreach ($entries as $entry): ?>

                    <div class="card mb-4 shadow-sm border-0 chapter-block" data-chapitre="<?= htmlspecialchars($entry['chapitre']) ?>">
                        <div class="card-body">
                            <div class="mb-2 text-muted small d-flex justify-content-between align-items-center">
                                <div>
                                    📅 <?= htmlspecialchars($entry['date_ajout']) ?> — ✍️ <?= (int)$entry['nb_mots'] ?> mots
                                </div>
                                
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