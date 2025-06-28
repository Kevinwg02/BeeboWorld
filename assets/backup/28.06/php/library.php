<?php
include 'connexion.php';

// Récupération des livres
$sql = "SELECT * FROM library ORDER BY ID DESC";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Ma Bibliothèque</title>
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    <h1 class="mb-4">📚 Ma Bibliothèque</h1>
    <a href="../index.php" class="btn btn-success mb-4">ISBN</a>
    <a href="/php/admin_book.php" class="btn btn-success mb-4">📚 Voir la bibliothèque (admin)</a>
    <a href="add_manual.php" class="btn btn-success mb-4">+ Ajout manuel</a>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
      <?php foreach ($books as $book): ?>
        <?php
        $coverUrl = '';
        if (!empty($book['Couverture'])) {
          $coverUrl = htmlspecialchars($book['Couverture']);
        } elseif (!empty($book['ISBN'])) {
          // Clean ISBN (remove dashes or non-digit characters except X)
          $isbn = preg_replace('/[^0-9Xx]/', '', $book['ISBN']);
          $coverUrl = "https://covers.openlibrary.org/b/isbn/{$isbn}-L.jpg";
        }
        ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($coverUrl)): ?>
              <img src="<?= $coverUrl ?>" class="card-img-top" alt="Couverture de <?= htmlspecialchars($book['Titre']) ?>">
            <?php else: ?>
              <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 10em;">
                Pas d'image
              </div>
            <?php endif; ?>
            <div class="card-body p-2 d-flex align-items-center justify-content-center">
              <h5 class="card-title" title="<?= htmlspecialchars($book['Titre']) ?>"><?= htmlspecialchars($book['Titre']) ?></h5>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($books)): ?>
        <p class="text-center text-muted">Aucun livre trouvé.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>