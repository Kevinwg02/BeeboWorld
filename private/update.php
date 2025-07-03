<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../php/connexion.php';

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    die("ID de livre manquant.");
}

// Récupération des données uniques
function fetchDistinctValues($pdo, $column)
{
    try {
        $stmt = $pdo->query("SELECT DISTINCT `$column` FROM library WHERE `$column` IS NOT NULL AND `$column` != '' ORDER BY `$column` ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        return [];
    }
}

$notations = fetchDistinctValues($pdo, 'Notation');
$localisations = fetchDistinctValues($pdo, 'localisation');
$genres = fetchDistinctValues($pdo, 'Genre');
$formats = fetchDistinctValues($pdo, 'Format');

// Charger le livre existant
$stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Livre introuvable.");
}

// Champs gérés
$fields = [
    'Auteur', 'Titre', 'Dedicace', 'Marquepages', 'Goodies', 'ISBN', 'Format', 'Prix',
    'Date_achat', 'Date_lecture', 'Relecture', 'Chronique_ecrite', 'Chronique_publiee',
    'Details', 'Chronique', 'Maison_edition', 'Nombre_pages', 'Notation', 'Genre',
    'Themes', 'Couple', 'Couverture', 'localisation'
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($fields as $field) {
        $value = $_POST[$field] ?? null;

        if ($field === 'Nombre_pages') {
            $value = ($value === '') ? null : (int)$value;
        } elseif ($field === 'Prix') {
            $value = ($value === '') ? null : (float)$value;
        } elseif ($field === 'Couverture') {
            if (empty($value)) {
                $value = $book['Couverture'] ?: '../assets/covers/TheAdventureOfBeebo.jpg';
            }
        }

        $data[$field] = $value;
    }

    $setParts = array_map(fn($f) => "`$f` = ?", $fields);
    $sql = "UPDATE library SET " . implode(', ', $setParts) . " WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([...array_values($data), $id]);

    $message = "Livre mis à jour avec succès.";

    $stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Modifier un livre</title>
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">✏️ Modifier un livre</h1>
        <a href="admin_book.php" class="btn btn-success mb-3">📚 Voir la bibliothèque (admin)</a>
        <a href="library.php" class="btn btn-warning mb-3">📚 Library</a>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" class="row g-3">
            <?php
            function input($label, $name, $type = 'text', $size = 6, $list = null)
            {
                global $book;
                $value = $book[$name] ?? '';
                if ($name === 'Couverture' && empty($value)) {
                    $value = '../assets/covers/TheAdventureOfBeebo.jpg';
                }
                $value = htmlspecialchars($value);
                echo "<div class='col-md-$size'>
                    <label class='form-label'>$label</label>
                    <input type='$type' name='$name' class='form-control' value=\"$value\"" . ($list ? " list=\"$list\"" : "") . ">
                </div>";
            }

            function textarea($label, $name, $rows = 3, $size = 12)
            {
                global $book;
                $value = htmlspecialchars($book[$name] ?? '');
                echo "<div class='col-md-$size'>
                        <label class='form-label'>$label</label>
                        <textarea name='$name' class='form-control' rows='$rows'>$value</textarea>
                      </div>";
            }

            function selectOuiNon($label, $name, $size = 6)
            {
                global $book;
                $value = $book[$name] ?? '';
                echo "<div class='col-md-$size'>
                        <label class='form-label'>$label</label>
                        <select name='$name' class='form-select'>
                            <option value=''>--</option>
                            <option value='Oui'" . ($value === 'Oui' ? ' selected' : '') . ">Oui</option>
                            <option value='Non'" . ($value === 'Non' ? ' selected' : '') . ">Non</option>
                        </select>
                      </div>";
            }

            input('Titre', 'Titre');
            input('Auteur', 'Auteur');
            input('ISBN', 'ISBN', 'text', 4);
            selectOuiNon('Dédicace', 'Dedicace', 4);
            selectOuiNon('Marque-pages', 'Marquepages', 4);
            selectOuiNon('Goodies', 'Goodies', 6);
            input('Format', 'Format', 'text', 4, 'format-list');
            input('Prix (€)', 'Prix', 'text', 4);
            input("Date d'achat", 'Date_achat', 'date', 6);
            input("Date de lecture", 'Date_lecture', 'date', 6);
            input("Relecture", 'Relecture', 'date', 6);
            selectOuiNon('Chronique écrite', 'Chronique_ecrite', 6);
            selectOuiNon('Chronique publiée', 'Chronique_publiee', 6);
            input("Maison d'édition", 'Maison_edition', 'text', 6);
            input("Nombre de pages", 'Nombre_pages', 'number', 3);
            input("Genre", 'Genre', 'text', 3, 'genre-list');
            input("localisation", 'localisation', 'text', 3, 'localisation-list');

            echo "<div class='col-md-3'>
                    <label class='form-label'>Notation</label>
                    <input type='text' name='Notation' class='form-control' value=\"" . htmlspecialchars($book['Notation'] ?? '') . "\" list='notation-list'>
                  </div>";

            input("Couple", 'Couple', 'text', 3);
            input("Themes", 'Themes', 'text', 3);
            input("Image (URL de couverture)", 'Couverture', 'text', 6);
            textarea("Résumé", 'Details');
            textarea("Chronique", 'Chronique');
            ?>
            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-success mb-3">💾 Enregistrer</button>
                <a href="book.php?id=<?= htmlspecialchars($id) ?>" class="btn btn-primary mb-3">📖 Retour sur le livre</a>
            </div>

            <!-- DATALISTS -->
            <datalist id="notation-list">
                <?php foreach ($notations as $val): ?>
                    <option value="<?= htmlspecialchars($val) ?>">
                <?php endforeach; ?>
            </datalist>

            <datalist id="localisation-list">
                <?php foreach ($localisations as $val): ?>
                    <option value="<?= htmlspecialchars($val) ?>">
                <?php endforeach; ?>
            </datalist>

            <datalist id="genre-list">
                <?php foreach ($genres as $val): ?>
                    <option value="<?= htmlspecialchars($val) ?>">
                <?php endforeach; ?>
            </datalist>

            <datalist id="format-list">
                <?php foreach ($formats as $val): ?>
                    <option value="<?= htmlspecialchars($val) ?>">
                <?php endforeach; ?>
            </datalist>
        </form>
    </div>
</body>

</html>
