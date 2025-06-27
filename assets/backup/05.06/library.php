<?php include 'connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ma Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1 class="mb-4">📚 Ma Bibliothèque</h1>
        <div class="col-md-3 mb-4">
            <a href="../index.php" class="btn btn-primary">ISBN Check</a>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

            <?php
            $stmt = $pdo->query("SELECT * FROM Books ORDER BY id DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
            ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($row['couverture'])): ?>
                            <img src="<?= htmlspecialchars($row['couverture']) ?>" class="card-img-top" alt="Couverture">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($row['titre']) ?></h5>
                            <p class="card-text"><strong>Auteur :</strong> <?= htmlspecialchars($row['auteur']) ?></p>
                            <p class="card-text"><strong>ISBN :</strong> <?= htmlspecialchars($row['isbn']) ?></p>
                            <p class="card-text text-muted"><strong>Éditeur :</strong> <?= htmlspecialchars($row['maison_edition']) ?></p>
                            <p class="card-text"><strong>Catégories :</strong> <?= htmlspecialchars($row['categories']) ?></p>
                            <p class="card-text"><strong>Langue :</strong> <?= htmlspecialchars($row['langue']) ?></p>
                            <p class="card-text"><strong>Pages :</strong> <?= htmlspecialchars($row['nbPage']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>

</body>

</html>
