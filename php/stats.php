<?php
include 'connexion.php';

// Fonction pour formater mois en MM-YYYY
function formatMois($annee, $mois)
{
    return sprintf("%02d-%s", $mois, $annee);
}
// Récupération des pages lues par mois
$pages_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(date, '%Y-%m') AS mois, SUM(pages) AS total FROM nb_page_lu GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pages_par_mois[$row['mois']] = (int)$row['total'];
}

// Récupération des achats par mois
$achats_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(Date_achat, '%Y-%m') AS mois, COUNT(*) AS count FROM library GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $achats_par_mois[$row['mois']] = (int)$row['count']; // int cast au cas où
}

// Récupération des lectures par mois
$lectures_par_mois = [];
$stmt = $pdo->query("SELECT DATE_FORMAT(Date_lecture, '%Y-%m') AS mois, COUNT(*) AS count FROM library WHERE Date_lecture IS NOT NULL AND Date_lecture <> '0000-00-00' GROUP BY mois ORDER BY mois DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $lectures_par_mois[$row['mois']] = (int)$row['count'];
}

// Regroupement par année
function regrouperParAnnee($data)
{
    $result = [];
    foreach ($data as $mois => $count) {
        list($annee, $moisNum) = explode('-', $mois);
        if (!isset($result[$annee])) {
            $result[$annee] = [];
        }
        $result[$annee][$moisNum] = $count;
    }
    krsort($result);
    foreach ($result as &$moisArray) {
        ksort($moisArray);
    }
    return $result;
}

$achats_par_annee = regrouperParAnnee($achats_par_mois);
$lectures_par_annee = regrouperParAnnee($lectures_par_mois);

// Préparation données pour graphique : fusion des mois uniques
$all_months = array_unique(array_merge(array_keys($achats_par_mois), array_keys($lectures_par_mois), array_keys($pages_par_mois)));
sort($all_months);


// Préparer arrays JS pour counts
$achats_js = [];
$lectures_js = [];
foreach ($all_months as $m) {
    $achats_js[] = $achats_par_mois[$m] ?? 0;
    $lectures_js[] = $lectures_par_mois[$m] ?? 0;
}

// Labels format MM-YYYY en JS
$labels_js = [];
$pages_js = [];
foreach ($all_months as $m) {
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="mb-3">
            <a href="add_manual.php" class="btn btn-primary mb-2">➕ Ajout manuel</a>
            <a href="../index.php" class="btn btn-warning mb-2">📚 Library</a>
        </div>

        <h1>Statistiques de la bibliothèque</h1>

        <div class="row">
            <div class="col-md-6">
                <h2>Graphique des achats et lectures par mois</h2>
                <canvas id="chartStats" style="width: 100%; height: 350px;"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Graphique des pages lues par mois</h2>
                <canvas id="chartPages" style="width: 100%; height: 350px;"></canvas>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Achats par année et mois</h2>
                <?php if (empty($achats_par_annee)): ?>
                    <p>Aucune donnée d'achat disponible.</p>
                <?php else: ?>
                    <?php foreach ($achats_par_annee as $annee => $moisArray): ?>
                        <h3><?= htmlspecialchars($annee) ?></h3>
                        <ul class="list-group mb-3">
                            <?php foreach ($moisArray as $moisNum => $count):
                                $affichageMois = formatMois($annee, $moisNum);
                            ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?mois=<?= urlencode("$annee-$moisNum") ?>" class="text-decoration-none flex-grow-1">
                                        <?= htmlspecialchars($affichageMois) ?>
                                    </a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <h2>Lectures par année et mois</h2>
                <?php if (empty($lectures_par_annee)): ?>
                    <p>Aucune donnée de lecture disponible.</p>
                <?php else: ?>
                    <?php foreach ($lectures_par_annee as $annee => $moisArray): ?>
                        <h3><?= htmlspecialchars($annee) ?></h3>
                        <ul class="list-group mb-3">
                            <?php foreach ($moisArray as $moisNum => $count):
                                $affichageMois = formatMois($annee, $moisNum);
                            ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <a href="details.php?mois=<?= urlencode("$annee-$moisNum") ?>" class="text-decoration-none flex-grow-1">
                                        <?= htmlspecialchars($affichageMois) ?>
                                    </a>
                                    <span><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
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
                datasets: [{
                        label: 'Livres achetés',
                        data: dataAchats,
                        backgroundColor: 'rgba(0, 248, 74, 0.7)',
                    },
                    {
                        label: 'Livres lus',
                        data: dataLectures,
                        backgroundColor: 'rgba(0, 195, 255, 0.7)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Forcer des ticks entiers (pas de décimales)
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Nombre de livres'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    </script>
    <script>
        const ctxPages = document.getElementById('chartPages').getContext('2d');

        const labelsPages = <?= json_encode($labels_js) ?>;
        const dataPages = <?= json_encode($pages_js) ?>;

        new Chart(ctxPages, {
            type: 'line',
            data: {
                labels: labelsPages,
                datasets: [{
                    label: 'Pages lues',
                    data: dataPages,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de pages'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });
    </script>

</body>

</html>