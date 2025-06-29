<?php
include 'php/connexion.php';
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM library WHERE ID = ?");
    $stmt->execute([$deleteId]);
    header('Location: library.php');
    exit;
}


// Récupération des filtres
$search = $_GET['search'] ?? '';
$genreFilter = $_GET['genre'] ?? '';
$notationFilter = $_GET['notation'] ?? '';
$formatFilter = $_GET['format'] ?? '';

// Construction de la requête SQL dynamique
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



$whereSQL = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Récupération des options pour les filtres
$genres = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre")->fetchAll(PDO::FETCH_COLUMN);
$notations = $pdo->query("SELECT DISTINCT notation FROM library WHERE notation IS NOT NULL AND notation != '' ORDER BY notation")->fetchAll(PDO::FETCH_COLUMN);
$formats = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format")->fetchAll(PDO::FETCH_COLUMN);

// Récupération des livres filtrés
$sql = "SELECT * FROM library $whereSQL ORDER BY ID DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ma Bibliothèque</title>
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
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <div class="alert alert-success">📘 Livre supprimé avec succès.</div>
    <?php endif; ?>

    <div class="container py-4">
        <h1 class="mb-4">📚 Ma Bibliothèque</h1>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Titre ou auteur..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2">
                <select name="genre" class="form-select">
                    <option value="">Tous les genres</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= htmlspecialchars($genre) ?>" <?= $genreFilter === $genre ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genre) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="notation" class="form-select">
                    <option value="">Toutes les médailles</option>
                    <?php foreach ($notations as $notation): ?>
                        <option value="<?= htmlspecialchars($notation) ?>" <?= $notationFilter === $notation ? 'selected' : '' ?>>
                            <?= htmlspecialchars($notation) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="format" class="form-select">
                    <option value="">Tous les formats</option>
                    <?php foreach ($formats as $format): ?>
                        <option value="<?= htmlspecialchars($format) ?>" <?= $formatFilter === $format ? 'selected' : '' ?>>
                            <?= htmlspecialchars($format) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Filtrer</button>
                <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn btn-outline-secondary">Réinitialiser</a>
            </div>
        </form>

        <div class="mb-3">
            <a href="php/stats.php" class="btn btn-warning mb-2">📊 Stats</a>
            <a href="php/add_manual.php" class="btn btn-primary mb-2">➕ Ajout manuel</a>
            <a href="php/admin_book.php" class="btn btn-success mb-2">📚 Admin</a>
            <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#pagesModal">
                📖 Pages lues
            </button>

        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
            <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    if (!empty($book['Couverture'])) {
                        $coverUrl = htmlspecialchars($book['Couverture']);
                    } elseif (!empty($book['ISBN'])) {
                        $isbn = preg_replace('/[^0-9Xx]/', '', $book['ISBN']);
                        $coverUrl = "https://covers.openlibrary.org/b/isbn/{$isbn}-L.jpg";
                    } else {
                        $coverUrl = "https://greenhousescribes.com/wp-content/uploads/2020/10/book-cover-generic.jpg";
                    }
                    ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <a href="php/book.php?id=<?= $book['ID'] ?>">
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
    </div>
    <!-- Modal Ajout Pages Lues -->
    <div class="modal fade" id="pagesModal" tabindex="-1" aria-labelledby="pagesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="php/pages_lu.php" class="modal-content">
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