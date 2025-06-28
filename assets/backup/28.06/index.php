<?php
include 'php/connexion.php';

$isbn = $_POST['isbn'] ?? '';
$book = null;
$message = '';
$added = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($isbn)) {
    $isbn = trim($isbn);
    $api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . urlencode($isbn);
    $response = @file_get_contents($api_url);

    if ($response === false) {
        $message = "Erreur lors de la connexion à l'API Google Books.";
    } else {
        $data = json_decode($response, true);

        if (isset($data['items'][0])) {
            $book = $data['items'][0]['volumeInfo'];
            $auteur = $book['authors'][0] ?? '';
            $titre = $book['title'] ?? '';
            $details = $book['description'] ?? '';
            $maison_edition = $book['publisher'] ?? '';
            $nombre_pages = $book['pageCount'] ?? '';
            $genre = isset($book['categories']) ? implode(', ', $book['categories']) : '';
            $couverture = $book['imageLinks']['thumbnail'] ?? $book['imageLinks']['smallThumbnail'] ?? '';
            $format = $book['printType'] ?? '';
            $prix = '';
        } else {
            $message = "Livre non trouvé avec cet ISBN.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_final') {
    try {
        $stmt = $pdo->prepare("INSERT INTO library 
            (Auteur, Titre, Dedicace, Marquepages, Goodies, ISBN, Format, Prix, Date_achat, Date_lecture, Relecture, Chronique_ecrite, Chronique_publiee, Details, Maison_edition, Nombre_pages, Notation, Genre, Couverture, Couple)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['auteur'],
            $_POST['titre'],
            $_POST['dedicace'],
            $_POST['marquepages'],
            $_POST['goodies'],
            $_POST['isbn'],
            $_POST['format'],
            $_POST['prix'],
            $_POST['date_achat'],
            $_POST['date_lecture'],
            $_POST['relecture'],
            $_POST['chronique_ecrite'],
            $_POST['chronique_publiee'],
            $_POST['details'],
            $_POST['maison_edition'],
            $_POST['nombre_pages'],
            $_POST['notation'],
            $_POST['genre'],
            $_POST['couverture'],
            $_POST['couple']
        ]);

        $message = "Livre ajouté avec succès !";
        $added = true;
        $book = null;
    } catch (PDOException $e) {
        $message = "Erreur base de données : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Recherche et ajout de livres</title>
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1 class="mb-4">Bibliothèque BeeboWorld</h1>

        <form method="POST" class="row g-3 align-items-center mb-4">
            <div class="col-auto">
                <input type="text" name="isbn" class="form-control" placeholder="Entrez un ISBN" required
                    value="<?= htmlspecialchars($isbn) ?>">
            </div>
            <div class="col-auto">
                <button type="submit" name="action" value="find" class="btn btn-info">Trouver le livre</button>
            </div>
        </form>

        <a href="/php/admin_book.php" class="btn btn-success mb-4"> Admin</a>
        <a href="php/library.php" class="btn btn-primary mb-4">Library</a>
        <a href="/php/add_manual.php" class="btn btn-warning mb-4">+ Ajout manuel</a>


        <?php if ($message) : ?>
            <div class="alert <?= $added ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($book) : ?>
            <form method="POST" class="card p-4 shadow-sm">
                <input type="hidden" name="action" value="add_final">
                <div class="col-md-2">
                    <img src="<?= htmlspecialchars($couverture) ?>" alt="Couverture" class="img-fluid w-100 rounded border">
                </div>

                <div class="row g-3">
                    <input type="hidden" name="isbn" value="<?= htmlspecialchars($isbn) ?>">
                    <input type="hidden" name="couverture" value="<?= htmlspecialchars($couverture) ?>">


                    <div class="col-md-6">
                        <label class="form-label">Auteur</label>
                        <input type="text" name="auteur" class="form-control" value="<?= htmlspecialchars($auteur) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($titre) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Format</label>
                        <select name="format" class="form-select">
                            <option value="Papier" <?= $format === 'Papier' ? 'selected' : '' ?>>Papier</option>
                            <option value="E-book" <?= $format === 'E-book' ? 'selected' : '' ?>>E-book</option>
                            <option value="BD" <?= $format === 'BD' ? 'selected' : '' ?>>BD</option>
                            <option value="Hardback" <?= $format === 'Hardback' ? 'selected' : '' ?>>Hardback</option>
                            <option value="BD" <?= $format === 'Manga' ? 'selected' : '' ?>>Manga</option>
                            <option value="<?= htmlspecialchars($format) ?>" <?= !in_array($format, ['Papier', 'E-book', 'BD', 'Hardback']) ? 'selected' : '' ?>><?= htmlspecialchars($format) ?></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Prix (€)</label>
                        <input type="text" name="prix" class="form-control" value="<?= htmlspecialchars($prix) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date d'achat</label>
                        <input type="date" name="date_achat" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date de lecture</label>
                        <input type="date" name="date_lecture" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="details" class="form-control" rows="4"><?= htmlspecialchars($details) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Éditeur</label>
                        <input type="text" name="maison_edition" class="form-control" value="<?= htmlspecialchars($maison_edition) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pages</label>
                        <input type="text" name="nombre_pages" class="form-control" value="<?= htmlspecialchars($nombre_pages) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Genre</label>
                        <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($genre) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Couple</label>
                        <input type="text" name="couple" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Notation</label>
                        <input type="text" name="notation" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Relecture</label>
                        <input type="date" name="relecture" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chronique écrite</label>
                        <input type="text" name="chronique_ecrite" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chronique publiée</label>
                        <input type="text" name="chronique_publiee" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dédicace</label>
                        <input type="text" name="dedicace" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Marque-pages</label>
                        <input type="text" name="marquepages" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Goodies</label>
                        <input type="text" name="goodies" class="form-control">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">✅ Confirmer et ajouter à la bibliothèque</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

    </div>

</body>

</html>