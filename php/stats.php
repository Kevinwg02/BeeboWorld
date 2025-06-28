<?php
include 'connexion.php';

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
// Statistiques annuelles
try {
    // Livres achetés par année
    $stmt = $pdo->query("
        SELECT YEAR(Date_achat) AS annee, COUNT(*) AS nb_achats
        FROM library
        WHERE Date_achat IS NOT NULL
        GROUP BY annee
        ORDER BY annee
    ");
    $achats_par_annee = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Livres lus par année
    $stmt = $pdo->query("
        SELECT YEAR(Date_lecture) AS annee, COUNT(*) AS nb_lectures
        FROM library
        WHERE Date_lecture IS NOT NULL
        GROUP BY annee
        ORDER BY annee
    ");
    $lectures_par_annee = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Livres achetés par mois (année-mois)
    $stmt = $pdo->query("
        SELECT DATE_FORMAT(Date_achat, '%Y-%m') AS mois, COUNT(*) AS nb_achats
        FROM library
        WHERE Date_achat IS NOT NULL
        GROUP BY mois
        ORDER BY mois
    ");
    $achats_par_mois = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Livres lus par mois (année-mois)
    $stmt = $pdo->query("
        SELECT DATE_FORMAT(Date_lecture, '%Y-%m') AS mois, COUNT(*) AS nb_lectures
        FROM library
        WHERE Date_lecture IS NOT NULL
        GROUP BY mois
        ORDER BY mois
    ");
    $lectures_par_mois = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $stats_error = "Erreur lors de la récupération des statistiques temporelles : " . $e->getMessage();
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
        <div class="mb-3">
            <a href="../index.php" class="btn btn-warning me-2">📚 Library</a>
            <a href="add_manual.php" class="btn btn-primary">➕ Ajout manuel</a>
        </div>
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

        <?php if (!isset($stats_error)) : ?>
            <div class="my-5">
                <h4>📅 Statistiques annuelles</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Livres achetés par année</h6>
                        <ul class="list-group">
                            <?php foreach ($achats_par_annee as $annee => $count): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?annee=<?= urlencode($annee) ?>" class="text-decoration-none flex-grow-1"><?= htmlspecialchars($annee) ?></a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Livres lus par année</h6>
                        <ul class="list-group">
                            <?php foreach ($lectures_par_annee as $annee => $count): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?annee=<?= urlencode($annee) ?>" class="text-decoration-none flex-grow-1"><?= htmlspecialchars($annee) ?></a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <hr class="my-4" />

                <h4>📆 Statistiques mensuelles</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Livres achetés par mois</h6>
                        <ul class="list-group">
                            <?php foreach ($achats_par_mois as $mois => $count): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?mois=<?= urlencode($mois) ?>" class="text-decoration-none flex-grow-1"><?= htmlspecialchars($mois) ?></a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Livres lus par mois</h6>
                        <ul class="list-group">
                            <?php foreach ($lectures_par_mois as $mois => $count): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?mois=<?= urlencode($mois) ?>" class="text-decoration-none flex-grow-1"><?= htmlspecialchars($mois) ?></a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
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
