<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../php/connexion.php';

$message = '';
$added = false;

// Récupération des listes
try {
    $stmt = $pdo->query("SELECT DISTINCT localisation FROM library WHERE localisation IS NOT NULL AND localisation != '' ORDER BY localisation ASC");
    $localisation = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $localisation = [];
}

try {
    $stmt = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format ASC");
    $formats = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $formats = [];
}

try {
    $stmt = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre ASC");
    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $genres = [];
}

try {
    $stmt = $pdo->query("SELECT DISTINCT Notation FROM library WHERE Notation IS NOT NULL AND Notation != '' ORDER BY Notation ASC");
    $notations = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $notations = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO library 
            (Auteur, Titre, Dedicace, Marquepages, Goodies, ISBN, Format, Prix, Date_achat, Date_lecture, Relecture, Chronique_ecrite, Chronique_publiee, Citation, Details, Themes, Maison_edition, Nombre_pages, Notation, Genre, Couverture, Couple, Chronique, localisation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['auteur'] ?? '',
            $_POST['titre'] ?? '',
            $_POST['dedicace'] ?? '',
            $_POST['marquepages'] ?? '',
            $_POST['goodies'] ?? '',
            $_POST['isbn'] ?? '',
            $_POST['format'] ?? '',
            $_POST['prix'] ?? '',
            $_POST['date_achat'] ?? '',
            $_POST['date_lecture'] ?? '',
            $_POST['relecture'] ?? '',
            $_POST['chronique_ecrite'] ?? '',
            $_POST['chronique_publiee'] ?? '',
            $_POST['citation'] ?? '',
            $_POST['details'] ?? '',
            $_POST['Themes'] ?? '',
            $_POST['maison_edition'] ?? '',
            $_POST['nombre_pages'] ?? '',
            $_POST['notation'] ?? '',
            $_POST['genre'] ?? '',
            !empty($_POST['couverture']) ? $_POST['couverture'] : '../assets/covers/TheAdventureOfBeebo.jpg',
            $_POST['couple'] ?? '',
            $_POST['chronique'] ?? '',
            $_POST['localisation'] ?? ''
        ]);

        $message = "Livre ajouté avec succès !";
        $added = true;
        $_POST = []; // Réinitialise le formulaire
    } catch (PDOException $e) {
        $message = "Erreur base de données : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout manuel d’un livre</title>
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">📚 Beeboworld</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto"></ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="admin_book.php">🛠️ Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="stats.php">📊 Stats</a></li>
                <li class="nav-item"><a class="nav-link" href="library.php">📚 Library</a></li>
                <li class="nav-item"><a class="nav-link" href="add_manual.php">➕ Ajout manuel</a></li>
                <li class="nav-item"><a class="nav-link btn" data-bs-toggle="modal" data-bs-target="#pagesModal">📖 Pages lues</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h1 class="mb-4">✍️ Ajout manuel d’un livre</h1>

    <a href="stats.php" class="btn btn-primary mb-2">📊 Stats</a>
    <a href="library.php" class="btn btn-warning mb-2">📚 Library</a>

    <?php if ($message): ?>
        <div class="alert <?= $added ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label>Titre</label>
            <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label>Auteur</label>
            <input type="text" name="auteur" class="form-control" value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>" required>
        </div>
        <div class="col-md-4">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label>Dédicace</label>
            <select name="dedicace" class="form-select">
                <option value="">Non précisé</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>
        <div class="col-md-4">
            <label>Marque-pages</label>
            <select name="marquepages" class="form-select">
                <option value="">Non précisé</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Goodies</label>
            <select name="goodies" class="form-select">
                <option value="">Non précisé</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Format</label>
            <input type="text" name="format" class="form-control" list="format-list" value="<?= htmlspecialchars($_POST['format'] ?? '') ?>">
            <datalist id="format-list">
                <?php foreach ($formats as $f): ?>
                    <option value="<?= htmlspecialchars($f) ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="col-md-4">
            <label>Prix (€)</label>
            <input type="text" name="prix" class="form-control" value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label>Date d'achat</label>
            <input type="date" name="date_achat" class="form-control" value="<?= htmlspecialchars($_POST['date_achat'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label>Date de lecture</label>
            <input type="date" name="date_lecture" class="form-control" value="<?= htmlspecialchars($_POST['date_lecture'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label>Relecture</label>
            <input type="date" name="relecture" class="form-control" value="<?= htmlspecialchars($_POST['relecture'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label>Chronique écrite</label>
            <select name="chronique_ecrite" class="form-select">
                <option value="">Non précisé</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Chronique publiée</label>
            <select name="chronique_publiee" class="form-select">
                <option value="">Non précisé</option>
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Maison d'édition</label>
            <input type="text" name="maison_edition" class="form-control" value="<?= htmlspecialchars($_POST['maison_edition'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label>Nombre de pages</label>
            <input type="text" name="nombre_pages" class="form-control" value="<?= htmlspecialchars($_POST['nombre_pages'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control" list="genre-list" value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>">
            <datalist id="genre-list">
                <?php foreach ($genres as $g): ?>
                    <option value="<?= htmlspecialchars($g) ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="col-md-3">
            <label>Localisation</label>
            <input type="text" name="localisation" class="form-control" list="localisation-list" value="<?= htmlspecialchars($_POST['localisation'] ?? '') ?>">
            <datalist id="localisation-list">
                <?php foreach ($localisation as $loc): ?>
                    <option value="<?= htmlspecialchars($loc) ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="col-md-3">
            <label>Notation</label>
            <input type="text" name="notation" class="form-control" list="notation-list" value="<?= htmlspecialchars($_POST['notation'] ?? '') ?>">
            <datalist id="notation-list">
                <?php foreach ($notations as $n): ?>
                    <option value="<?= htmlspecialchars($n) ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
        <div class="col-md-3">
            <label>Couple</label>
            <input type="text" name="couple" class="form-control" value="<?= htmlspecialchars($_POST['couple'] ?? '') ?>">
        </div>
        <div class="col-3">
            <label>Themes</label>
            <input type="text" name="Themes" class="form-control" value="<?= htmlspecialchars($_POST['Themes'] ?? '') ?>">
        </div>
        <div class="col-md-12">
            <label>Image (URL de couverture)</label>
            <input type="text" name="couverture" class="form-control" value="<?= htmlspecialchars($_POST['couverture'] ?? '../assets/covers/TheAdventureOfBeebo.jpg') ?>">
        </div>
        <div class="col-12">
            <label>Résumé</label>
            <textarea name="details" class="form-control" rows="4"><?= htmlspecialchars($_POST['details'] ?? '') ?></textarea>
        </div>
        <div class="col-12">
            <label>Chronique</label>
            <textarea name="chronique" class="form-control" rows="4"><?= htmlspecialchars($_POST['chronique'] ?? '') ?></textarea>
        </div>
        <div class="col-12">
            <label>Citation</label>
            <textarea name="citation" class="form-control" rows="4"><?= htmlspecialchars($_POST['citation'] ?? '') ?></textarea>
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-success">➕ Ajouter le livre</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="pagesModal" tabindex="-1" aria-labelledby="pagesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="pages_lu.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter des pages lues</h5>
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
