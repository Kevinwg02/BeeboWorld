<?php
include 'connexion.php';

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    die("ID de livre manquant.");
}

// Récupérer le livre
$stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Livre introuvable.");
}

// Champs à gérer
$fields = [
    'Auteur', 'Titre', 'Dedicace', 'Marquepages', 'Goodies', 'ISBN',
    'Format', 'Prix', 'Date_achat', 'Date_lecture', 'Relecture',
    'Chronique_ecrite', 'Chronique_publiee', 'Details', 'Maison_edition',
    'Nombre_pages', 'Notation', 'Genre', 'Couple', 'Couverture'
];

// Charger notations existantes
try {
    $stmt = $pdo->query("SELECT DISTINCT Notation FROM library WHERE Notation IS NOT NULL AND Notation != '' ORDER BY Notation ASC");
    $notations = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $notations = [];
}

// Traitement formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [];
    foreach ($fields as $field) {
        $value = $_POST[$field] ?? null;
        if (in_array($field, ['Nombre_pages'])) {
            $value = $value === '' ? null : (int)$value;
        }
        if (in_array($field, ['Prix'])) {
            $value = $value === '' ? null : (float)$value;
        }
        $data[$field] = $value;
    }

    $setParts = array_map(fn($f) => "`$f` = ?", $fields);
    $sql = "UPDATE library SET " . implode(', ', $setParts) . " WHERE ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([...array_values($data), $id]);

    $message = "Livre mis à jour avec succès.";

    // Recharger les données
    $stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonctions input
function input($label, $name, $type = 'text', $size = 6) {
    global $book;
    $value = htmlspecialchars($book[$name] ?? '');
    echo "<div class='col-md-$size'>
        <label class='form-label'>$label</label>
        <input type='$type' name='$name' class='form-control' value=\"$value\">
    </div>";
}

function textarea($label, $name, $rows = 3, $size = 12) {
    global $book;
    $value = htmlspecialchars($book[$name] ?? '');
    echo "<div class='col-md-$size'>
        <label class='form-label'>$label</label>
        <textarea name='$name' class='form-control' rows='$rows'>$value</textarea>
    </div>";
}

function selectOuiNon($label, $name, $size = 6) {
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

function selectNotation($label, $name, $notations, $size = 6) {
    global $book;
    $value = $book[$name] ?? '';
    echo "<div class='col-md-$size'>
        <label class='form-label'>$label</label>
        <select name='$name' class='form-select'>
            <option value=''>-- Choisir une médaille --</option>";
    foreach ($notations as $note) {
        $selected = ($note === $value) ? 'selected' : '';
        echo "<option value=\"" . htmlspecialchars($note) . "\" $selected>" . htmlspecialchars($note) . "</option>";
    }
    echo "</select></div>";
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

    <a href="/php/admin_book.php" class="btn btn-success mb-4">📚 Voir la bibliothèque (admin)</a>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <?php
        input('Titre', 'Titre');
        input('Auteur', 'Auteur');
        input('ISBN', 'ISBN', 'text', 4);
        selectOuiNon('Dédicace', 'Dedicace', 4);
        selectOuiNon('Marque-pages', 'Marquepages', 4);
        selectOuiNon('Goodies', 'Goodies', 6);
        input('Format', 'Format', 'text', 4);
        input('Prix (€)', 'Prix', 'text', 4);
        input("Date d'achat", 'Date_achat', 'date', 6);
        input("Date de lecture", 'Date_lecture', 'date', 6);
        input("Relecture", 'Relecture', 'date', 6);
        selectOuiNon('Chronique écrite', 'Chronique_ecrite', 6);
        selectOuiNon('Chronique publiée', 'Chronique_publiee', 6);
        input("Maison d'édition", 'Maison_edition', 'text', 6);
        input("Nombre de pages", 'Nombre_pages', 'number', 3);
        input("Genre", 'Genre', 'text', 3);
        selectNotation("Notation", 'Notation', $notations, 4);
        input("Couple", 'Couple', 'text', 4);
        input("Image (URL de couverture)", 'Couverture', 'text', 4);
        textarea("Description", 'Details');
        textarea("Chronique", 'Chronique');
        textarea("Themes", 'Themes');
        ?>
        <div class="col-12 text-end mt-4">
            <button type="submit" class="btn btn-success mb-3">💾 Enregistrer</button>
            <a href="library.php" class="btn btn-primary mb-3">📚 Library</a>
        </div>
    </form>
</div>
</body>
</html>
