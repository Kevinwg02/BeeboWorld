<?php
// session_start();
// if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
//     header('Location: ../index.php');
//     exit;
// }

include '../php/connexion.php';

setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra', 'fr_FR', 'fr', 'French_France.1252');
$annee_actuelle = date('Y');
$mois_actuel = date('m');

// Pages lues ce mois
$stmt = $pdo->prepare("SELECT SUM(pages) FROM nb_page_lu WHERE YEAR(date) = ? AND MONTH(date) = ?");
$stmt->execute([$annee_actuelle, $mois_actuel]);
$pages_mois_actuel = $stmt->fetchColumn() ?? 0;

// Livres lus cette année
$stmt = $pdo->prepare("SELECT COUNT(*) FROM library WHERE YEAR(Date_lecture) = ? AND localisation = 'Bibliothèque physique'");
$stmt->execute([$annee_actuelle]);
$nb_lus_annee = $stmt->fetchColumn();

// Livres achetés cette année
$stmt = $pdo->prepare("SELECT COUNT(*) FROM library WHERE YEAR(Date_achat) = ? AND localisation = 'Bibliothèque physique'");
$stmt->execute([$annee_actuelle]);
$nb_achetes_annee = $stmt->fetchColumn();

// Total livres
$stmt = $pdo->query("SELECT COUNT(*) FROM library WHERE localisation = 'Bibliothèque physique'");
$nb_total_biblio = $stmt->fetchColumn();

// Somme prix total
$stmt = $pdo->query("SELECT SUM(Prix) FROM library WHERE Prix IS NOT NULL AND localisation = 'Bibliothèque physique'");
$prix_total = $stmt->fetchColumn();

// Format mois
function formatMois($annee, $mois) {
    return sprintf("%02d-%s", $mois, $annee);
}

// Données par mois
$pages_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(date, '%Y-%m') AS mois, SUM(pages) AS total FROM nb_page_lu GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages_par_mois[$row['mois']] = (int)$row['total'];
}

$achats_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(Date_achat, '%Y-%m') AS mois, COUNT(*) AS count FROM library GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $achats_par_mois[$row['mois']] = (int)$row['count'];
}

$lectures_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(Date_lecture, '%Y-%m') AS mois, COUNT(*) AS count FROM library WHERE Date_lecture IS NOT NULL AND Date_lecture <> '0000-00-00' GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $lectures_par_mois[$row['mois']] = (int)$row['count'];
}

function regrouperParAnnee($data) {
    $result = [];
    foreach ($data as $mois => $count) {
        list($annee, $moisNum) = explode('-', $mois);
        if (!isset($result[$annee])) $result[$annee] = [];
        $result[$annee][$moisNum] = $count;
    }
    krsort($result);
    foreach ($result as &$moisArray) krsort($moisArray);
    return $result;
}

$achats_par_annee = regrouperParAnnee($achats_par_mois);
$lectures_par_annee = regrouperParAnnee($lectures_par_mois);
$pages_par_annee = regrouperParAnnee($pages_par_mois);

$all_months = array_unique(array_merge(array_keys($achats_par_mois), array_keys($lectures_par_mois), array_keys($pages_par_mois)));
sort($all_months);

$achats_js = [];
$lectures_js = [];
$pages_js = [];
$labels_js = [];
foreach ($all_months as $m) {
    $achats_js[] = $achats_par_mois[$m] ?? 0;
    $lectures_js[] = $lectures_par_mois[$m] ?? 0;
    $pages_js[] = $pages_par_mois[$m] ?? 0;
    $labels_js[] = substr($m, 5, 2) . '-' . substr($m, 0, 4);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
    
    <div class="container py-4">
        <div class="mb-3">
            <a href="../index.php" class="btn btn-warning mb-2">📚 Library</a>
        </div>

        <h1>Statistiques de la bibliothèque</h1>
        <div class="row row-cols-1 row-cols-md-5 g-3 text-center mb-4">
            <div class="col">
                <div class="bg-white rounded shadow-sm p-3">
                    <h5 class="text-muted">Livres lus en <?= $annee_actuelle ?></h5>
                    <h3 class="text-primary"><?= $nb_lus_annee ?></h3>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded shadow-sm p-3">
                    <h5 class="text-muted">Livres achetés en <?= $annee_actuelle ?></h5>
                    <h3 class="text-success"><?= $nb_achetes_annee ?></h3>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded shadow-sm p-3">
                    <h5 class="text-muted">Bibliothèque</h5>
                    <h3 class="text-dark"><?= $nb_total_biblio ?></h3>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded shadow-sm p-3">
                    <h5 class="text-muted">Valeur de la bibliothèque</h5>
                    <h3 class="text-danger"><?= number_format($prix_total, 2, ',', ' ') ?> €</h3>
                </div>
            </div>
            <div class="col">
                <div class="bg-white rounded shadow-sm p-3">
                    <h5 class="text-muted">Pages lues en <?= strftime('%B') ?></h5>
                    <h3 class="text-purple"><?= number_format($pages_mois_actuel, 0, ',', ' ') ?> pages</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Graphique des achats et lectures par mois</h2>
                <canvas id="chartStats"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Graphique des pages lues par mois</h2>
                <canvas id="chartPages"></canvas>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Achats par année et mois</h2>
                <?php foreach ($achats_par_annee as $annee => $moisArray): ?>
                    <h3><?= htmlspecialchars($annee) ?></h3>
                    <ul class="list-group mb-3">
                        <?php foreach ($moisArray as $moisNum => $count): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <a href="public_details.php?mois=<?= urlencode("$annee-$moisNum") ?>" class="text-decoration-none flex-grow-1">
                                    <?= formatMois($annee, $moisNum) ?>
                                </a>
                                <span><?= $count ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>
            <div class="col-md-6">
                <h2>Lectures par année et mois</h2>
                <?php foreach ($lectures_par_annee as $annee => $moisArray): ?>
                    <h3><?= htmlspecialchars($annee) ?></h3>
                    <ul class="list-group mb-3">
                        <?php foreach ($moisArray as $moisNum => $count): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <a href="public_details.php?mois=<?= urlencode("$annee-$moisNum") ?>" class="text-decoration-none flex-grow-1">
                                    <?= formatMois($annee, $moisNum) ?>
                                </a>
                                <span><?= $count ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </div>

            <div class="col-md-12">
            <h2>Pages lues par année</h2>
            <ul class="list-group mb-3">
                <?php foreach ($pages_par_annee as $annee => $moisArray): ?>
                    <li class="list-group-item">
                        <a href="public_pages_lues_mois.php?annee=<?= urlencode($annee) ?>">
                            <?= htmlspecialchars($annee) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        </div>

        <a href="../index.php" class="btn btn-primary mt-3">⬅ Retour à la bibliothèque</a>
    </div>

    <script>
        const ctx = document.getElementById('chartStats').getContext('2d');
        const labels = <?= json_encode($labels_js) ?>;
        const dataAchats = <?= json_encode($achats_js) ?>;
        const dataLectures = <?= json_encode($lectures_js) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Livres achetés', data: dataAchats, backgroundColor: 'rgba(0, 248, 74, 0.7)' },
                    { label: 'Livres lus', data: dataLectures, backgroundColor: 'rgba(0, 195, 255, 0.7)' }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, title: { display: true, text: 'Nombre de livres' }},
                    x: { title: { display: true, text: 'Mois' }}
                }
            }
        });

        const ctxPages = document.getElementById('chartPages').getContext('2d');
        const dataPages = <?= json_encode($pages_js) ?>;

        new Chart(ctxPages, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{ label: 'Pages lues', data: dataPages, backgroundColor: 'rgba(153, 102, 255, 0.6)' }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Nombre de pages' }},
                    x: { title: { display: true, text: 'Mois' }}
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
