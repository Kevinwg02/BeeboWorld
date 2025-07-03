<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ../index.php');  // ← corrige bien le chemin
    exit;
}

include '../php/connexion.php';

// Suppression
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM library WHERE ID = ?")->execute([$deleteId]);
    header("Location: library.php?deleted=1");
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Livre introuvable.");
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($book['Titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <style>
        img {
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
        <a href="library.php" class="btn btn-warning mb-3">📚 Library</a>
        <a href="add_manual.php" class="btn btn-primary mb-3">➕ Ajout manuel</a>
        <h1 class="mb-4"><?= htmlspecialchars($book['Titre']) ?></h1>
        <div class="row">
            <!-- Couverture -->
            <div class="col-md-4">
                <?php
                   $cover = trim($book['Couverture']);
                    $coverUrl = (!empty($cover))
                        ? htmlspecialchars($cover)  // Ne pas vérifier file_exists ici car c'est un chemin web
                        : (!empty($book['ISBN'])
                            ? "https://covers.openlibrary.org/b/isbn/" . preg_replace('/[^0-9Xx]/', '', $book['ISBN']) . "-L.jpg"
                            : "../assets/covers/TheAdventureOfBeebo.jpg");

                ?>
                <img src="<?= $coverUrl ?>" alt="Couverture" class="img-fluid shadow-sm rounded">

            </div>

            <!-- Infos -->
            <div class="col-md-8">
                <div class="row">
                    <?php
                    $fields = [
                        "Auteur",
                        "ISBN",
                        "Date_achat",
                        "Prix",
                        "Date_lecture",
                        "Dedicace",
                        "Maison_edition",
                        "Goodies",
                        "Format",
                        "Marquepages",
                        "Nombre_pages",
                        "Relecture",
                        "Genre",
                        "Notation",
                        "Couple",
                        "Themes",
                        "localisation",
                    ];
                    $fieldLabels = [
                        "Auteur" => "Auteur",
                        "ISBN" => "ISBN",
                        "Date_achat" => "Date d'achat",
                        "Prix" => "Prix (€)",
                        "Date_lecture" => "Date de lecture",
                        "Dedicace" => "Dédicace",
                        "Maison_edition" => "Maison d'édition",
                        "Goodies" => "Goodies",
                        "Format" => "Format",
                        "Marquepages" => "Marque-pages",
                        "Nombre_pages" => "Nombre de pages",
                        "Relecture" => "Relecture",
                        "Genre" => "Genre",
                        "Notation" => "Notation",
                        "Couple" => "Couple",
                        "Themes" => "Thèmes",
                        "localisation" => "Emplacement dans la bibliothèque"
                    ];
                    foreach ($fields as $field):
                        // Ignorer les champs qui seront affichés dans la section "Livre lu"
                        if (!empty($book['Date_lecture']) && in_array($field, ['Date_lecture', 'Notation', 'Relecture'])) {
                            continue;
                        }

                        $value = $book[$field] ?? '';

                        // Reformater la date au format français uniquement pour les champs de date
                        if (in_array($field, ['Date_achat', 'Date_lecture', 'Relecture']) && !empty($value) && $value !== '0000-00-00') {
                            $date = DateTime::createFromFormat('Y-m-d', $value);
                            if ($date) {
                                $value = $date->format('d-m-Y'); // format JJ-MM-AAAA
                            }
                        }
                    ?>
                        <div class="col-md-6 detail-row">
                            <span class="label"><?= htmlspecialchars($fieldLabels[$field] ?? $field) ?> :</span><br>
                            <span class="value"><?= nl2br(htmlspecialchars($value)) ?></span>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!empty($book['Date_lecture']) && $book['Date_lecture'] !== '0000-00-00'): ?>
                        <div class="mt-4 p-3 bg-success bg-opacity-10 border border-success rounded">
                            <h5 class="text-success mb-3">📖 Ce livre a été lu</h5>
                            <div class="row">
                                <?php
                                // Date de lecture
                                $dateLecture = DateTime::createFromFormat('Y-m-d', $book['Date_lecture']);
                                echo "<div class='col-md-6 detail-row'><span class='label'>Date de lecture :</span><br><span class='value'>" . $dateLecture->format('d-m-Y') . "</span></div>";

                                // Notation
                                if (!empty($book['Notation'])) {
                                    echo "<div class='col-md-6 detail-row'><span class='label'>Notation :</span><br><span class='value'>" . htmlspecialchars($book['Notation']) . "</span></div>";
                                }

                                // Relecture
                                if (!empty($book['Relecture']) && $book['Relecture'] !== '0000-00-00') {
                                    $dateRelecture = DateTime::createFromFormat('Y-m-d', $book['Relecture']);
                                    echo "<div class='col-md-6 detail-row'><span class='label'>Relecture :</span><br><span class='value'>" . $dateRelecture->format('d-m-Y') . "</span></div>";
                                }

                                // Couple
                                if (!empty($book['Couple'])) {
                                    echo "<div class='col-md-6 detail-row'><span class='label'>Couple :</span><br><span class='value'>" . htmlspecialchars($book['Couple']) . "</span></div>";
                                }

                                // Chronique écrite
                                if (!empty($book['Chronique_ecrite'])) {
                                    echo "<div class='col-md-6 detail-row'><span class='label'>Chronique écrite :</span><br><span class='value'>" . htmlspecialchars($book['Chronique_ecrite']) . "</span></div>";
                                }

                                // Chronique publiée
                                if (!empty($book['Chronique_publiee'])) {
                                    echo "<div class='col-md-6 detail-row'><span class='label'>Chronique publiée :</span><br><span class='value'>" . htmlspecialchars($book['Chronique_publiee']) . "</span></div>";
                                }

                                // Affichage de la chronique si elle est écrite + publiée + non vide
                                if (
                                    !empty($book['Chronique']) &&
                                    strtolower($book['Chronique_ecrite']) === 'oui' &&
                                    strtolower($book['Chronique_publiee']) !== 'non'
                                )
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>



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
            <div class="section-title">📝 Résumé</div>
            <p><?= nl2br(htmlspecialchars($book['Details'])) ?></p>

            <div class="section-title">📖 Chronique</div>
            <p><?= nl2br(htmlspecialchars($book['Chronique'])) ?></p>

            <div class="section-title">📖 Citation</div>
            <p><?= nl2br(htmlspecialchars($book['Citation'])) ?></p>
        </div>
    </div>
</body>

</html>