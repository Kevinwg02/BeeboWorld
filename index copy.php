<?php
include 'php/connexion.php';

$isbn = $_POST['isbn'] ?? '';
$book = null;
$message = '';
$added = false;

// Statistiques globales
try {
    // Total de livres
    $stmt = $pdo->query("SELECT COUNT(*) FROM library");
    $total_livres = $stmt->fetchColumn();

    // Total de lectures
    $stmt = $pdo->query("SELECT COUNT(*) FROM library WHERE Date_lecture IS NOT NULL AND Date_lecture != ''");
    $total_lectures = $stmt->fetchColumn();

    // Sur les 30 derniers jours
    $stmt = $pdo->query("SELECT COUNT(*) FROM library WHERE Date_achat >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $livres_30j = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM library WHERE Date_lecture >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $lectures_30j = $stmt->fetchColumn();
} catch (PDOException $e) {
    $stats_error = "Erreur lors de la récupération des statistiques : " . $e->getMessage();
}

// Préparation des données pour le graphique (depuis la date la plus ancienne)
try {
    // Ajouts mensuels depuis le début
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(Date_achat, '%Y-%m') AS mois,
            COUNT(*) AS nb_ajouts
        FROM library
        WHERE Date_achat IS NOT NULL
        GROUP BY mois
        ORDER BY mois ASC
    ");
    $ajouts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Lectures mensuelles depuis le début
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(Date_lecture, '%Y-%m') AS mois,
            COUNT(*) AS nb_lectures
        FROM library
        WHERE Date_lecture IS NOT NULL
        GROUP BY mois
        ORDER BY mois ASC
    ");
    $lectures = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Fusionner les mois des deux jeux de données
    $mois = array_unique(array_merge(array_keys($ajouts), array_keys($lectures)));
    sort($mois);

    $data_ajouts = [];
    $data_lectures = [];

    foreach ($mois as $m) {
        $data_ajouts[] = $ajouts[$m] ?? 0;
        $data_lectures[] = $lectures[$m] ?? 0;
    }
} catch (PDOException $e) {
    $chart_error = "Erreur graphique : " . $e->getMessage();
}

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
        <h1 class="mb-3">Bibliothèque BeeboWorld</h1>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <form method="POST" class="d-flex align-items-center" style="gap: 0.5rem;">
                <input type="text" name="isbn" class="form-control" placeholder="Entrez un ISBN" required
                    value="<?= htmlspecialchars($isbn) ?>" />
                <button type="submit" name="action" value="find" class="btn btn-info">Recherche</button>
            </form>
            <a href="/php/admin_book.php" class="btn btn-success">📘 Admin</a>
            <a href="php/library.php" class="btn btn-primary">📚 Library</a>
            <a href="/php/add_manual.php" class="btn btn-warning">➕ Ajout manuel</a>
        </div>

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
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <?php if (isset($stats_error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($stats_error) ?></div>
        <?php else : ?>
            <div class="row my-5">
                <div class="col-md-3">
                    <div class="card shadow-sm p-3 text-center bg-light">
                        <h5>Total livres</h5>
                        <h2><?= $total_livres ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3 text-center bg-light">
                        <h5>Total lectures</h5>
                        <h2><?= $total_lectures ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3 text-center bg-light">
                        <h5>Ajouts 30 derniers jours</h5>
                        <h2><?= $livres_30j ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm p-3 text-center bg-light">
                        <h5>Lectures 30 derniers jours</h5>
                        <h2><?= $lectures_30j ?></h2>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($chart_error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($chart_error) ?></div>
        <?php else : ?>
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">📊 Évolution des ajouts et lectures (depuis la création)</h5>
                <canvas id="chartEvolution"></canvas>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartEvolution').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($mois ?? []) ?>,
                datasets: [{
                    label: 'Ajouts',
                    data: <?= json_encode($data_ajouts ?? []) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3,
                }, {
                    label: 'Lectures',
                    data: <?= json_encode($data_lectures ?? []) ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Évolution des ajouts et lectures (depuis la création)'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
</body>

</html>
