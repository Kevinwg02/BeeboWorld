<?php
include 'connexion.php';

$isbn = $_POST['isbn'] ?? '';
$book = null;
$message = '';
$added = false;

$message = '';
$added = false;

// Récupération des genres existants dans la BDD
try {
    $stmt = $pdo->query("SELECT DISTINCT Format FROM library WHERE Format IS NOT NULL AND Format != '' ORDER BY Format ASC");
    $formats = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $formats = [];
}
// Récupération des formtats existants dans la BDD
try {
    $stmt = $pdo->query("SELECT DISTINCT Genre FROM library WHERE Genre IS NOT NULL AND Genre != '' ORDER BY Genre ASC");
    $genres = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $genres = [];
}

// Récupération des notations existantes dans la BDD
try {
    $stmt = $pdo->query("SELECT DISTINCT Notation FROM library WHERE Notation IS NOT NULL AND Notation != '' ORDER BY Notation ASC");
    $notations = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $notations = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO library 
            (Auteur, Titre, Dedicace, Marquepages, Goodies, ISBN, Format, Prix, Date_achat, Date_lecture, Relecture, Chronique_ecrite, Chronique_publiee, Details, Maison_edition, Nombre_pages, Notation, Genre, Couverture, Couple)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

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
            $_POST['details'] ?? '',
            $_POST['maison_edition'] ?? '',
            $_POST['nombre_pages'] ?? '',
            $_POST['notation'] ?? '',
            $_POST['genre'] ?? '',
            $_POST['couverture'] ?? '',
            $_POST['couple'] ?? ''
        ]);

        $message = "Livre ajouté avec succès !";
        $added = true;
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

    <div class="container py-5">
        <h1 class="mb-4">✍️ Ajout manuel d’un livre</h1>
        <a href="stats.php" class="btn btn-primary mb-2">📊 Stats</a>
        <a href="../index.php" class="btn btn-warning mb-2">📚 Library</a>



        <?php if ($message): ?>
            <div class="alert <?= $added ? 'alert-success' : 'alert-danger' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="row g-3">
            <div class="col-md-6">
                <label>Titre</label>
                <input type="text" name="titre" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Auteur</label>
                <input type="text" name="auteur" class="form-control">
            </div>


            <div class="col-md-4">
                <label>ISBN</label>
                <input type="text" name="isbn" class="form-control">
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
                <input type="text" name="genre" class="form-control" list="format-list">
                <datalist id="format-list">
                    <?php foreach ($formats as $formats): ?>
                        <option value="<?= htmlspecialchars($formats) ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>

            <div class="col-md-4">
                <label>Prix (€)</label>
                <input type="text" name="prix" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Date d'achat</label>
                <input type="date" name="date_achat" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Date de lecture</label>
                <input type="date" name="date_lecture" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Relecture</label>
                <input type="date" name="relecture" class="form-control">
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
                <input type="text" name="maison_edition" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Nombre de pages</label>
                <input type="text" name="nombre_pages" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Genre</label>
                <input type="text" name="genre" class="form-control" list="genre-list">
                <datalist id="genre-list">
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= htmlspecialchars($genre) ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>


            <div class="col-md-4">
                <label>Notation</label>
                <select name="notation" class="form-select">
                    <option value="">-- Choisir une médaille --</option>
                    <?php foreach ($notations as $notation): ?>
                        <option value="<?= htmlspecialchars($notation) ?>" <?= isset($livre['notation']) && $livre['notation'] === $notation ? 'selected' : '' ?>>
                            <?= htmlspecialchars($notation) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label>Couple</label>
                <input type="text" name="couple" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Image (URL de couverture)</label>
                <input type="text" name="couverture" class="form-control">
            </div>
            <div class="col-12">
                <label>Description</label>
                <textarea name="details" class="form-control" rows="4"></textarea>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">➕ Ajouter le livre</button>
            </div>

        </form>
    </div>

</body>

</html>