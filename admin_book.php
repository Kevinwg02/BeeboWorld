<?php
include 'connexion.php';

// Suppression
if (isset($_GET['delete'])) {
  $deleteId = (int) $_GET['delete'];
  $pdo->prepare("DELETE FROM library WHERE ID = ?")->execute([$deleteId]);
  header("Location: admin_book.php?success=1");
  exit;
}

// Filtres
$search = $_GET['search'] ?? '';
$genreFilter = $_GET['genre'] ?? '';
$notationFilter = $_GET['notation'] ?? '';  // <-- nouveau filtre
$formatFilter = $_GET['format'] ?? '';  // <-- nouveau filtre

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
  $whereClauses[] = "notation = ?";  // <-- filtre médaille
  $params[] = $notationFilter;
}
if ($formatFilter) {
  $whereClauses[] = "Format = ?";  // <-- filtre format
  $params[] = $formatFilter;
}

$whereSQL = $whereClauses ? ('WHERE ' . implode(' AND ', $whereClauses)) : '';

// Récupération des livres
$sql = "SELECT * FROM library $whereSQL ORDER BY ID DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Liste des genres
$genres = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre")->fetchAll(PDO::FETCH_COLUMN);

// Liste des médailles (distinctes et valides)
$notations = $pdo->query("SELECT DISTINCT notation FROM library WHERE notation IS NOT NULL AND notation != '' ORDER BY notation")->fetchAll(PDO::FETCH_COLUMN);

// Liste des format (distinctes et valides) 
$format = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format")->fetchAll(PDO::FETCH_COLUMN);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <title>Admin - Gestion complète de la bibliothèque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/themes.css">
</head>

<body class="bg-light">
  <div class="container-fluid py-4">
    <h1 class="mb-4">📚 Administration complète des livres</h1>
    <a href="../index.php" class="btn btn-warning mb-3">📚 Library</a>
    <a href="stats.php" class="btn btn-primary mb-3">📊 Stats</a>
    <a href="add_manual.php" class="btn btn-success mb-3">➕ Ajout manuel</a>

    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Titre ou auteur..." value="<?= htmlspecialchars($search) ?>">
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
          <option value="">Toutes les format</option>
          <?php foreach ($format as $format): ?>
            <option value="<?= htmlspecialchars($format) ?>" <?= $formatFilter === $format ? 'selected' : '' ?>>
              <?= htmlspecialchars($format) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <button class="btn btn-primary" type="submit">Filtrer</button>
      </div>
    </form>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">Livre supprimé avec succès.</div>
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
  </div>
</body>

</html>