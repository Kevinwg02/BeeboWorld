<?php
include 'connexion.php';

$annee = $_GET['annee'] ?? null;
$mois = $_GET['mois'] ?? null;
$livres = [];

try {
    if ($annee) {
        $stmt = $pdo->prepare("
            SELECT * FROM library 
            WHERE (YEAR(Date_achat) = :annee OR YEAR(Date_lecture) = :annee)
            ORDER BY Date_achat, Date_lecture
        ");
        $stmt->execute(['annee' => $annee]);
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Livres de l'année $annee";
    } elseif ($mois) {
        $stmt = $pdo->prepare("
            SELECT * FROM library 
            WHERE (DATE_FORMAT(Date_achat, '%Y-%m') = :mois OR DATE_FORMAT(Date_lecture, '%m-%Y') = :mois)
            ORDER BY Date_achat, Date_lecture
        ");
        $stmt->execute(['mois' => $mois]);
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $titre = "Livres du mois $mois";
    } else {
        $titre = "Période non spécifiée";
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

    <?php if (isset($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php elseif (empty($livres)): ?>
        <div class="alert alert-warning">Aucun livre trouvé pour cette période.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Date Achat</th>
                        <th>Date Lecture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livres as $livre): ?>
                        <tr>
                            <td><?= htmlspecialchars($livre['Titre']) ?></td>
                            <td><?= htmlspecialchars($livre['Auteur']) ?></td>
                            <td><?= htmlspecialchars($livre['Date_achat']) ?></td>
                            <td><?= htmlspecialchars($livre['Date_lecture']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
