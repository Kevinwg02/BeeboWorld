<?php
include 'connexion.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Livre introuvable.");
}

// Suppression
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM library WHERE ID = ?")->execute([$deleteId]);
    header("Location: admin_book.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['Titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img{
            width: 70%;
        }
        .label {
            font-weight: bold;
            color: #333;
        }

        .value {
            word-break: break-word;
        }

        .detail-row {
            border-bottom: 1px solid #dee2e6;
            padding: 0.25rem 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 2rem;
            border-bottom: 2px solid #ccc;
            padding-bottom: .25rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
            <a href="library.php" class="btn btn-primary mb-3">Library</a>
    <a href="add_manual.php" class="btn btn-primary mb-3">+ Ajout manuel</a>
        <h1 class="mb-4"><?= htmlspecialchars($book['Titre']) ?></h1>
        <div class="row">
            <!-- Couverture -->
            <div class="col-md-4">
                <?php
                $cover = $book['Couverture'] ?: "https://covers.openlibrary.org/b/isbn/" . preg_replace('/[^0-9Xx]/', '', $book['ISBN']) . "-L.jpg";
                ?>
                <img src="<?= htmlspecialchars($cover) ?>" alt="Couverture" class="img-fluid shadow-sm rounded">
            </div>

            <!-- Infos -->
            <div class="col-md-8">
                <div class="row">
                    <?php
                    $fields = [
                        "Auteur", "ISBN", "Date_achat", "Prix",   "Date_lecture", "Dedicace","Maison_edition", "Goodies", "Format", "Marquepages","Chronique_ecrite", "Chronique_publiee",
                         "Nombre_pages", "Relecture", "Genre", "Notation",  "Couple", "Themes"
                    ];
                    foreach ($fields as $field):
                        $value = $book[$field] ?? '';
                        ?>
                        <div class="col-md-6 detail-row">
                            <span class="label"><?= htmlspecialchars($field) ?> :</span><br>
                            <span class="value"><?= nl2br(htmlspecialchars($value)) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Actions -->
                <div class="mt-3">
                    <a href="library.php" class="btn btn-primary me-2">⬅ Retour</a>
                    <a href="update.php?id=<?= $book['ID'] ?>" class="btn btn-warning me-2">✏️ Modifier</a>
                    <a href="?delete=<?= $book['ID'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer ce livre ?')">🗑️ Supprimer</a>
                </div>
            </div>
        </div>

        <!-- Détails & Chronique -->
        <div class="mt-5">
            <div class="section-title">📝 Description</div>
            <p><?= nl2br(htmlspecialchars($book['Details'])) ?></p>

            <div class="section-title">📖 Chronique</div>
            <p><?= nl2br(htmlspecialchars($book['Chronique'])) ?></p>
        </div>
    </div>
</body>

</html>
