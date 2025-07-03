<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../php/connexion.php';

$annee = $_GET['annee'] ?? null;
$mois = $_GET['mois'] ?? null;
$pages_lues = [];
$titre = 'Période non spécifiée';
$erreur = null;

try {
    if ($annee && !$mois) {
        // Requête pour toutes les pages lues dans l'année
        $stmt = $pdo->prepare("
            SELECT * FROM nb_page_lu
            WHERE YEAR(date) = :annee
            ORDER BY date ASC
        ");
        $stmt->execute(['annee' => $annee]);
        $pages_lues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Pages lues en $annee";
    } elseif ($mois) {
        // On attend un format 'YYYY-MM' pour $mois
        $stmt = $pdo->prepare("
            SELECT * FROM nb_page_lu
            WHERE DATE_FORMAT(date, '%Y-%m') = :mois
            ORDER BY date ASC
        ");
        $stmt->execute(['mois' => $mois]);
        $pages_lues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Pages lues en " . date('F Y', strtotime($mois . '-01'));
    }
} catch (PDOException $e) {
    $erreur = "Erreur lors de la récupération : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($titre) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" />
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4"><?= htmlspecialchars($titre) ?></h1>
    <a href="stats.php" class="btn btn-secondary mb-3">← Retour</a>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php elseif (empty($pages_lues)): ?>
        <div class="alert alert-warning">Aucune donnée de pages lues pour cette période.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Nombre de pages</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages_lues as $ligne): ?>
                        <tr>
                            <td><?= htmlspecialchars($ligne['date']) ?></td>
                            <td><?= number_format($ligne['pages'], 0, ',', ' ') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
