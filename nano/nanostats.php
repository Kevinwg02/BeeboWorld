<?php
include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

// Statistiques globales
$stmt = $pdo->query("SELECT COUNT(DISTINCT projet_id) AS nb_projets, SUM(nb_mots) AS total_mots FROM nano");
$stats = $stmt->fetch(PDO::FETCH_ASSOC);
$nbProjects = (int)$stats['nb_projets'];
$totalWords = (int)$stats['total_mots'];

// Stats par projet (avec nom du projet)
$stmt = $pdo->query("
    SELECT p.nom AS projet, SUM(n.nb_mots) AS mots
    FROM nano n
    JOIN projets p ON n.projet_id = p.id
    GROUP BY n.projet_id
    ORDER BY mots DESC
");
$projectsStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Graphique mots par projet
$labels = [];
$dataWords = [];
foreach ($projectsStats as $row) {
    $labels[] = $row['projet'];
    $dataWords[] = (int)$row['mots'];
}

// Progression mots par jour
$stmt = $pdo->query("SELECT date_ajout, SUM(nb_mots) AS mots_ajoutes FROM nano GROUP BY date_ajout ORDER BY date_ajout ASC");
$progressionStats = $stmt->fetchAll(PDO::FETCH_ASSOC);
$progressDates = array_column($progressionStats, 'date_ajout');
$progressMots = array_map('intval', array_column($progressionStats, 'mots_ajoutes'));

// Mots ajoutés ce mois
$stmt = $pdo->prepare("SELECT SUM(nb_mots) FROM nano WHERE YEAR(date_ajout) = YEAR(CURDATE()) AND MONTH(date_ajout) = MONTH(CURDATE())");
$stmt->execute();
$motsCeMois = (int) $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>📊 Stats Nano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <style>
        .stat-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .stat-card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <a href="../index.php" class="navbar-brand">📝 Nano</a>
        <div>
            <a href="nano.php" class="btn btn-outline-primary">Voir projets</a>
        </div>
</nav>

<div class="container py-4">
    <h1 class="mb-4 text-center">📊 Statistiques d’écriture</h1>

    <div class="row row-cols-1 row-cols-md-3 g-3 text-center mb-5">
        <div class="col">
            <div class="bg-white rounded shadow-sm p-4 stat-card">
                <h5 class="text-muted">Nombre de projets</h5>
                <h2 class="text-primary"><?= $nbProjects ?></h2>
            </div>
        </div>
        <div class="col">
            <div class="bg-white rounded shadow-sm p-4 stat-card">
                <h5 class="text-muted">Total de mots écrits</h5>
                <h2 class="text-success"><?= number_format($totalWords, 0, ',', ' ') ?></h2>
            </div>
        </div>
        <div class="col">
            <div class="bg-white rounded shadow-sm p-4 stat-card">
                <h5 class="text-muted">Mots ajoutés ce mois</h5>
                <h2 class="text-warning"><?= number_format($motsCeMois, 0, ',', ' ') ?></h2>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3>Mots écrits par projet et progression</h3>
        <div class="row">
            <div class="col-md-6">
                <canvas id="wordsChart" style="width:100%; height:400px;"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="progressChart" style="width:100%; height:400px;"></canvas>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3>Détails projets</h3>
        <table class="table table-striped table-hover bg-white shadow-sm">
            <thead>
                <tr>
                    <th>Projet</th>
                    <th class="text-end">Mots écrits</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projectsStats as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['projet']) ?></td>
                        <td class="text-end"><?= number_format($row['mots'], 0, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    new Chart(document.getElementById('wordsChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Mots écrits',
                data: <?= json_encode($dataWords) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Projet' } },
                y: { beginAtZero: true, title: { display: true, text: 'Nombre de mots' } }
            }
        }
    });

    new Chart(document.getElementById('progressChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode($progressDates) ?>,
            datasets: [{
                label: 'Mots ajoutés par jour',
                data: <?= json_encode($progressMots) ?>,
                borderColor: 'rgba(255, 99, 132, 0.8)',
                backgroundColor: 'rgba(255, 99, 132, 0.3)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        parser: 'yyyy-MM-dd',
                        unit: 'day',
                        displayFormats: { day: 'dd MMM' }
                    },
                    title: { display: true, text: 'Date' }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Nombre de mots' }
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
