<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

// Récupération des filtres
$search = $_GET['search'] ?? '';
$genreFilter = $_GET['genre'] ?? '';
$notationFilter = $_GET['notation'] ?? '';
$formatFilter = $_GET['format'] ?? '';
$localisationFilter = $_GET['localisation'] ?? '';
$etatLuFilter = $_GET['etat_lu'] ?? '';

// Construction dynamique de la requête WHERE
$whereClauses = [];
$params = [];

if ($search) {
    $whereClauses[] = "(Titre LIKE ? OR Auteur LIKE ? OR Format LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($genreFilter) {
    $whereClauses[] = "Genre = ?";
    $params[] = $genreFilter;
}

if ($notationFilter) {
    $whereClauses[] = "notation = ?";
    $params[] = $notationFilter;
}

if ($formatFilter) {
    $whereClauses[] = "Format = ?";
    $params[] = $formatFilter;
}

if ($localisationFilter) {
    $whereClauses[] = "localisation = ?";
    $params[] = $localisationFilter;
}

if ($etatLuFilter === 'oui') {
    $whereClauses[] = "(Date_lecture IS NOT NULL AND Date_lecture != '0000-00-00')";
} elseif ($etatLuFilter === 'non') {
    $whereClauses[] = "(Date_lecture IS NULL OR Date_lecture = '0000-00-00')";
}

$whereSQL = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Pagination
$livresParPage = 10;
$pageActuelle = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$countSql = "SELECT COUNT(*) FROM library $whereSQL";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalLivres = $countStmt->fetchColumn();

$totalPages = max(1, min(10000, ceil($totalLivres / $livresParPage)));
$pageActuelle = min($pageActuelle, $totalPages);
$offset = ($pageActuelle - 1) * $livresParPage;

$sql = "
    SELECT *,
           CASE 
               WHEN Date_lecture IS NOT NULL AND Date_lecture != '0000-00-00' THEN 'oui' 
               ELSE 'non' 
           END AS etat_lu
    FROM library
    $whereSQL
    ORDER BY ID DESC
    LIMIT $livresParPage OFFSET $offset
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filtres
$genres = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre")->fetchAll(PDO::FETCH_COLUMN);
$notations = $pdo->query("SELECT DISTINCT notation FROM library WHERE notation IS NOT NULL AND notation != '' ORDER BY notation")->fetchAll(PDO::FETCH_COLUMN);
$formats = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format")->fetchAll(PDO::FETCH_COLUMN);
$localisations = $pdo->query("SELECT DISTINCT localisation FROM library WHERE localisation IS NOT NULL AND localisation != '' ORDER BY localisation")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ma Bibliothèque Public</title>
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 20em;
            object-fit: cover;
        }

        .card-title {
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4"> <a href="php/login.php" class="text-decoration-none text-dark">📚</a> Ma Bibliothèque</h1>

        <form method="GET" class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <input type="text" name="search" class="form-control" placeholder="Titre ou auteur..." value="<?= htmlspecialchars($search) ?>" style="min-width: 200px;">

            <select name="genre" class="form-select" style="width: 250px;">
                <option value="">Tous les genres</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= htmlspecialchars($genre) ?>" <?= $genreFilter === $genre ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="notation" class="form-select" style="width: 250px;">
                <option value="">Toutes les médailles</option>
                <?php foreach ($notations as $notation): ?>
                    <option value="<?= htmlspecialchars($notation) ?>" <?= $notationFilter === $notation ? 'selected' : '' ?>>
                        <?= htmlspecialchars($notation) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="localisation" class="form-select" style="width: 250px;">
                <option value="">Localisation des livres</option>
                <?php foreach ($localisations as $loc): ?>
                    <option value="<?= htmlspecialchars($loc) ?>" <?= $localisationFilter === $loc ? 'selected' : '' ?>>
                        <?= htmlspecialchars($loc) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="format" class="form-select" style="width: 250px;">
                <option value="">Tous les formats</option>
                <?php foreach ($formats as $format): ?>
                    <option value="<?= htmlspecialchars($format) ?>" <?= $formatFilter === $format ? 'selected' : '' ?>>
                        <?= htmlspecialchars($format) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="etat_lu" class="form-select" style="width: 250px;">
                <option value="">Lu ou non</option>
                <option value="oui" <?= $etatLuFilter === 'oui' ? 'selected' : '' ?>>Oui</option>
                <option value="non" <?= $etatLuFilter === 'non' ? 'selected' : '' ?>>Non</option>
            </select>

            <button type="submit" class="btn btn-primary">Filtrer</button>
            <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
        </form>

        <div class="container py-4">
            <a href="/index.php" class="btn btn-primary mb-2">📚 Library</a>
            <a href="/public/public_stats.php" class="btn btn-warning mb-2">📊 Stats</a>
            <a href="/public/nanopublicstats.php" class="btn btn-success mb-2">📊 Nano Stats</a>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
            <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    $cover = trim($book['Couverture']);
                    $coverUrl = (!empty($cover))
                        ? htmlspecialchars($cover)  // Ne pas vérifier file_exists ici car c'est un chemin web
                        : (!empty($book['ISBN'])
                            ? "https://covers.openlibrary.org/b/isbn/" . preg_replace('/[^0-9Xx]/', '', $book['ISBN']) . "-L.jpg"
                            : "../assets/covers/TheAdventureOfBeebo.jpg");
                    ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <a href="public/public_book.php?id=<?= $book['ID'] ?>">
                                <img src="<?= $coverUrl ?>" class="card-img-top" alt="Couverture de <?= htmlspecialchars($book['Titre']) ?>">
                            </a>
                            <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                <h5 class="card-title" title="<?= htmlspecialchars($book['Titre']) ?>"><?= htmlspecialchars($book['Titre']) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Aucun livre trouvé.</p>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="mt-4 d-flex justify-content-center">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $pageActuelle ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>