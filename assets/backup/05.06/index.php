<?php
include 'php/connexion.php';

$isbn = '';
$book = null;
$message = '';
$added = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['isbn'])) {
    $isbn = trim($_POST['isbn']);
    $api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . urlencode($isbn);
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    if (isset($data['items'][0])) {
        $book = $data['items'][0]['volumeInfo'];

        if ($_POST['action'] === 'add') {
            // Préparation des données
            $titre = $book['title'] ?? '';
            $auteur = $book['authors'][0] ?? '';
            $description = $book['description'] ?? '';
            $editeur = $book['publisher'] ?? '';
            $date_pub = $book['publishedDate'] ?? '';
            $categories = isset($book['categories']) ? implode(', ', $book['categories']) : '';
            $langue = $book['language'] ?? '';
            $nbpages = $book['pageCount'] ?? 0;
            $couverture = $book['imageLinks']['thumbnail'] ?? '';

            // Insertion en BDD avec noms colonnes corrects (snake_case)
            try {
                $stmt = $pdo->prepare("INSERT INTO Books 
                  (titre, auteur, isbn, description, couverture, maison_edition, date_publication, categories, langue, nbpage)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute([
                    $titre, $auteur, $isbn, $description, $couverture, $editeur,
                    $date_pub, $categories, $langue, $nbpages
                ]);

                $message = "Livre ajouté avec succès !";
                $added = true;

            } catch (PDOException $e) {
                $message = "Erreur base de données : " . $e->getMessage();
            }
        }
    } else {
        $message = "Livre non trouvé avec cet ISBN.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Recherche et ajout de livres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="mb-4">Bibliothèque BeeboWorld</h1>

  <form method="POST" class="row g-3 align-items-center mb-4">
    <div class="col-auto">
      <input type="text" name="isbn" class="form-control" placeholder="Entrez un ISBN" required value="<?= htmlspecialchars($isbn) ?>">
    </div>
    <div class="col-auto">
      <button type="submit" name="action" value="find" class="btn btn-info">Trouver le livre</button>
    </div>
    <div class="col-auto">
      <button type="submit" name="action" value="add" class="btn btn-primary">Ajouter à la bibliothèque</button>
    </div>
    <div class="col-auto">
      <a href="/php/library.php" class="btn btn-secondary">Voir la bibliothèque</a>
    </div>
  </form>

  <?php if ($message): ?>
    <div class="alert <?= $added ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <?php if ($book): ?>
    <div class="card mb-3" style="max-width: 720px;">
      <div class="row g-0">
        <?php if (!empty($book['imageLinks']['thumbnail'])): ?>
        <div class="col-md-4">
          <img src="<?= htmlspecialchars($book['imageLinks']['thumbnail']) ?>" class="img-fluid rounded-start" alt="Couverture de <?= htmlspecialchars($book['title'] ?? '') ?>">
        </div>
        <?php endif; ?>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?></h5>
            <p class="card-text mb-1"><strong>Auteur :</strong> <?= htmlspecialchars($book['authors'][0] ?? 'Inconnu') ?></p>
            <p class="card-text mb-1"><strong>Éditeur :</strong> <?= htmlspecialchars($book['publisher'] ?? 'Non renseigné') ?></p>
            <p class="card-text mb-1"><strong>Date de publication :</strong> <?= htmlspecialchars($book['publishedDate'] ?? 'Inconnue') ?></p>
            <p class="card-text mb-1"><strong>Catégories :</strong> <?= isset($book['categories']) ? htmlspecialchars(implode(', ', $book['categories'])) : 'Non renseigné' ?></p>
            <p class="card-text mb-1"><strong>Langue :</strong> <?= htmlspecialchars($book['language'] ?? 'Inconnue') ?></p>
            <p class="card-text mb-1"><strong>Pages :</strong> <?= htmlspecialchars($book['pageCount'] ?? '0') ?></p>
            <p class="card-text mt-3"><?= nl2br(htmlspecialchars($book['description'] ?? 'Pas de description disponible.')) ?></p>
            <p class="card-text"><small class="text-body-secondary">ISBN : <?= htmlspecialchars($isbn) ?></small></p>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
