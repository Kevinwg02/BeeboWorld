<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ../index.php');  // ← corrige bien le chemin
    exit;
}

include '../php/connexion.php';

$isbn = '';
$book = null;
$message = '';
$added = false;
$couverture = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['isbn'])) {
  $isbn = trim($_POST['isbn']);
  $api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . urlencode($isbn);
  $response = @file_get_contents($api_url);
  $data = $response ? json_decode($response, true) : null;

  if ($data && isset($data['items'][0])) {
    $book = $data['items'][0]['volumeInfo'];

    // Format user ou API
    $format = $_POST['format'] ?? ($book['printType'] ?? 'Papier');

    // Récupérer l'URL de la couverture Google Books
    $imageUrl = $book['imageLinks']['thumbnail'] ??
      $book['imageLinks']['smallThumbnail'] ??
      '';

    // Fonction pour télécharger et sauvegarder l'image localement
    function downloadCover($url, $isbn)
    {
      $clean_isbn = preg_replace('/[^0-9Xx]/', '', $isbn);
      $folder = __DIR__ . '/../assets/covers';
      if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
      }
      $localPath = $folder . "/{$clean_isbn}.jpg";

      $imgContent = @file_get_contents($url);
      if ($imgContent !== false) {
        file_put_contents($localPath, $imgContent);
        return "assets/covers/{$clean_isbn}.jpg"; // chemin relatif pour affichage HTML et stockage BDD
      }
      return '';
    }

    // Essayer de télécharger l'image depuis Google Books
    if (!empty($imageUrl)) {
      $couverture = downloadCover($imageUrl, $isbn);
    }

    // Si pas d'image via Google Books, fallback Open Library
    if (empty($couverture)) {
      $openLibUrl = "https://covers.openlibrary.org/b/isbn/" . preg_replace('/[^0-9Xx]/', '', $isbn) . "-L.jpg";
      $couverture = downloadCover($openLibUrl, $isbn);
    }

    if ($_POST['action'] === 'add') {
      $prix = $_POST['prix'] ?? null;

      if (!is_numeric($prix)) {
        $message = "Merci d'entrer un prix valide.";
      } else {
        $titre = $book['title'] ?? '';
        $auteur = $book['authors'][0] ?? '';
        $description = $book['description'] ?? '';
        $editeur = $book['publisher'] ?? '';
        $date_pub = $book['publishedDate'] ?? '';
        $categories = isset($book['categories']) ? implode(', ', $book['categories']) : '';
        $langue = $book['language'] ?? '';
        $nb_pages = $book['pageCount'] ?? '';

        try {
          $stmt = $pdo->prepare("INSERT INTO library 
                        (Auteur, Titre, ISBN, Format, Prix, Date_achat, Date_lecture, Maison_edition, Nombre_pages, Genre, Couverture)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

          $stmt->execute([
            $auteur,
            $titre,
            $isbn,
            $format,
            $prix,
            $_POST['date_achat'] ?? null,
            $_POST['date_lecture'] ?? null,
            $editeur,
            $nb_pages,
            $categories,
            $couverture
          ]);

          $message = "Livre ajouté avec succès !";
          $added = true;
        } catch (PDOException $e) {
          $message = "Erreur base de données : " . $e->getMessage();
        }
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
  <meta charset="UTF-8">
  <title>Ajout de livre</title>
  <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">➕ Ajouter un livre à la bibliothèque</h1>

    <form method="POST" class="row g-3 mb-4">
      <div class="col-md-4">
        <input type="text" name="isbn" class="form-control" placeholder="Entrez un ISBN" required value="<?= htmlspecialchars($isbn) ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="prix" class="form-control" placeholder="Prix (€)" required>
      </div>
      <div class="col-md-3">
        <input type="text" name="format" class="form-control" placeholder="Format (ex: Papier, E-book)">
      </div>
      <div class="col-md-3">
        <input type="date" name="date_achat" class="form-control" placeholder="Date d'achat">
      </div>
      <div class="col-md-3">
        <input type="date" name="date_lecture" class="form-control" placeholder="Date de lecture">
      </div>
      <div class="col-auto">
        <button type="submit" name="action" value="add" class="btn btn-primary">Ajouter</button>
      </div>
    </form>

    <?php if ($message): ?>
      <div class="alert <?= $added ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <?php if ($book): ?>
      <div class="card mb-3" style="max-width: 720px;">
        <div class="row g-0">
          <?php if (!empty($couverture)): ?>
            <div class="col-md-4">
              <img src="<?= htmlspecialchars($couverture) ?>" class="img-fluid rounded-start" alt="Couverture">
            </div>
          <?php endif; ?>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">Titre : <?= htmlspecialchars($book['title'] ?? 'N/A') ?></h5>
              <p class="card-text"><strong>Auteur :</strong> <?= htmlspecialchars($book['authors'][0] ?? 'N/A') ?></p>
              <p class="card-text"><strong>Éditeur :</strong> <?= htmlspecialchars($book['publisher'] ?? 'N/A') ?></p>
              <p class="card-text"><strong>Date de publication :</strong> <?= htmlspecialchars($book['publishedDate'] ?? 'N/A') ?></p>
              <p class="card-text"><strong>Catégories :</strong> <?= htmlspecialchars(implode(', ', $book['categories'] ?? [])) ?></p>
              <p class="card-text"><strong>Langue :</strong> <?= htmlspecialchars($book['language'] ?? 'N/A') ?></p>
              <p class="card-text"><strong>Pages :</strong> <?= htmlspecialchars($book['pageCount'] ?? 'N/A') ?></p>
              <p class="card-text mt-3"><strong>Description :</strong><br><?= nl2br(htmlspecialchars($book['description'] ?? 'Pas de description')) ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>