<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /php/login.php.php');  // ← corrige bien le chemin
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';
// Suppression livre
if (isset($_GET['delete'])) {
  $deleteId = (int) $_GET['delete'];
  $pdo->prepare("DELETE FROM library WHERE ID = ?")->execute([$deleteId]);
  header("Location: admin_book.php?success=1");
  exit;
}

// Suppression pages lues
if (isset($_GET['delete_page'])) {
  $deletePageId = (int) $_GET['delete_page'];
  $pdo->prepare("DELETE FROM nb_page_lu WHERE id = ?")->execute([$deletePageId]);
  header("Location: admin_book.php?success_page_delete=1");
  exit;
}

// Filtres livres
$search = $_GET['search'] ?? '';
$genreFilter = $_GET['genre'] ?? '';
$notationFilter = $_GET['notation'] ?? '';
$formatFilter = $_GET['format'] ?? '';

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

$whereSQL = $whereClauses ? ('WHERE ' . implode(' AND ', $whereClauses)) : '';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Total count (for pagination)
$countSql = "SELECT COUNT(*) FROM library $whereSQL";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalBooks = $countStmt->fetchColumn();
$totalPages = ceil($totalBooks / $limit);

// Book query with LIMIT
$sql = "SELECT * FROM library $whereSQL ORDER BY ID DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $i => $param) {
  $stmt->bindValue($i + 1, $param);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filters data
$genres = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre")->fetchAll(PDO::FETCH_COLUMN);
$notations = $pdo->query("SELECT DISTINCT notation FROM library WHERE notation IS NOT NULL AND notation != '' ORDER BY notation")->fetchAll(PDO::FETCH_COLUMN);
$formats = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format")->fetchAll(PDO::FETCH_COLUMN);

// Récupération des pages lues
$sql_pages = "SELECT * FROM nb_page_lu ORDER BY date DESC";
$stmt_pages = $pdo->prepare($sql_pages);
$stmt_pages->execute();
$pages_lues = $stmt_pages->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon" />
  <title>Admin - Gestion complète de la bibliothèque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/themes.css" />
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">

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
                    <li class="nav-item">
                        <a class="nav-link" href="/nano/nanostats.php">📊 Nano Stats</a>
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

</body>

<body class="bg-light">
  <div class="container-fluid py-4">
    <h1 class="mb-4">📚 Administration complète des livres</h1>
    <!-- <a href="library.php" class="btn btn-warning mb-3">📚 Library</a>
    <a href="stats.php" class="btn btn-primary mb-3">📊 Stats</a>
    <a href="add_manual.php" class="btn btn-success mb-3">➕ Ajout manuel</a> -->

    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Titre ou auteur..." value="<?= htmlspecialchars($search) ?>" />
      </div>
      <div class="col-md-3">
        <select name="genre" class="form-select">
          <option value="">Tous les genres</option>
          <?php foreach ($genres as $genre): ?>
            <option value="<?= htmlspecialchars($genre) ?>" <?= $genreFilter === $genre ? 'selected' : '' ?>>
              <?= htmlspecialchars($genre) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="notation" class="form-select">
          <option value="">Toutes les médailles</option>
          <?php foreach ($notations as $notation): ?>
            <option value="<?= htmlspecialchars($notation) ?>" <?= $notationFilter === $notation ? 'selected' : '' ?>>
              <?= htmlspecialchars($notation) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="format" class="form-select">
          <option value="">Tous les formats</option>
          <?php foreach ($formats as $format): ?>
            <option value="<?= htmlspecialchars($format) ?>" <?= $formatFilter === $format ? 'selected' : '' ?>>
              <?= htmlspecialchars($format) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-primary" type="submit">Filtrer</button>
        <button type="button" class="btn btn-info md-3" data-bs-toggle="modal" data-bs-target="#pagesLuesModal">
          📖 Pages lues
        </button>
      </div>

    </form>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">Livre supprimé avec succès.</div>
    <?php endif; ?>

    <?php if (isset($_GET['success_page_delete'])): ?>
      <div class="alert alert-success">Entrée de pages lues supprimée avec succès.</div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered table-hover bg-white table-sm">
        <thead class="table-light">
          <tr>
            <?php if (!empty($books)): ?>
              <?php foreach (array_keys($books[0]) as $column): ?>
                <th><?= htmlspecialchars($column) ?></th>
              <?php endforeach; ?>
            <?php endif; ?>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
            <tr>
              <?php foreach ($book as $key => $value): ?>
                <td>
                  <?php
                  if ($key === 'Details') {
                    $text = strip_tags($value ?? '');
                    echo htmlspecialchars(mb_strimwidth($text, 0, 100, '...'));
                  } else {
                    echo htmlspecialchars($value ?? '');
                  }
                  ?>
                </td>
              <?php endforeach; ?>
              <td style="white-space: nowrap;">
                <a href="update.php?id=<?= $book['ID'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="?delete=<?= $book['ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce livre ?')">Supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($books)): ?>
            <tr>
              <td colspan="100" class="text-center text-muted">Aucun livre trouvé.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Modal Pages lues -->
    <div class="modal fade" id="pagesLuesModal" tabindex="-1" aria-labelledby="pagesLuesModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="pagesLuesModalLabel">📖 Gestion des pages lues</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover bg-white table-sm">
                <thead class="table-light">
                  <tr>
                    <?php if (!empty($pages_lues)): ?>
                      <?php foreach (array_keys($pages_lues[0]) as $column): ?>
                        <th><?= htmlspecialchars($column) ?></th>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pages_lues as $page): ?>
                    <tr>
                      <?php foreach ($page as $key => $value): ?>
                        <td><?= htmlspecialchars($value ?? '') ?></td>
                      <?php endforeach; ?>
                      <td style="white-space: nowrap;">
                        <a href="update_pages.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <a href="?delete_page=<?= $page['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette entrée de pages lues ?')">Supprimer</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  <?php if (empty($pages_lues)): ?>
                    <tr>
                      <td colspan="100" class="text-center text-muted">Aucune donnée de pages lues.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>