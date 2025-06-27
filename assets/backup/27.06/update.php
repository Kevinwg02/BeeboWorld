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

// Champs de la table library + ajout Couverture
$fields = [
  'Auteur',
  'Titre',
  'Dedicace',
  'Marquepages',
  'Goodies',
  'ISBN',
  'Format',
  'Prix',
  'Date_achat',
  'Date_lecture',
  'Relecture',
  'Chronique_ecrite',
  'Chronique_publiee',
  'Details',
  'Maison_edition',
  'Nombre_pages',
  'Notation',
  'Genre',
  'Couple',
  'Couverture'  // <-- ajout ici
];

// Traitement du formulaire
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

  $setParts = [];
  foreach ($fields as $field) {
    $setParts[] = "`$field` = ?";
  }

  $sql = "UPDATE library SET " . implode(', ', $setParts) . " WHERE ID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([...array_values($data), $id]);

  $message = "Livre mis à jour avec succès.";

  // Recharger les données modifiées
  $stmt = $pdo->prepare("SELECT * FROM library WHERE ID = ?");
  $stmt->execute([$id]);
  $book = $stmt->fetch(PDO::FETCH_ASSOC);
}

function input($label, $name, $type = 'text', $size = 6)
{
  global $book;
  $value = htmlspecialchars($book[$name] ?? '');
  echo "<div class='col-md-$size'>
            <label class='form-label'>$label</label>
            <input type='$type' name='$name' class='form-control' value=\"$value\">
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
          <select name='$name' class='form-control'>
            <option value=''>--</option>
            <option value='Oui'" . ($value === 'Oui' ? ' selected' : '') . ">Oui</option>
            <option value='Non'" . ($value === 'Non' ? ' selected' : '') . ">Non</option>
          </select>
        </div>";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Modifier un livre</title>
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
      input('Auteur', 'Auteur');
      input('Titre', 'Titre');
      selectOuiNon('Dédicace', 'Dedicace');
      selectOuiNon('Marque-pages', 'Marquepages');
      selectOuiNon('Goodies', 'Goodies');
      input('ISBN', 'ISBN');
      input('Format', 'Format');
      input('Prix (€)', 'Prix', 'decimal');
      input('Date d\'achat', 'Date_achat', 'date');
      input('Date de lecture', 'Date_lecture', 'date');
      input('Relecture', 'Relecture', 'date');
      input('Chronique écrite', 'Chronique_ecrite');
      input('Chronique publiée', 'Chronique_publiee');
      input('Détails', 'Details');
      input('Maison d\'édition', 'Maison_edition');
      input('Nombre de pages', 'Nombre_pages', 'number');
      input('Notation', 'Notation');
      input('Genre', 'Genre');
      input('Couple', 'Couple');
      input('Chemin / URL de la couverture', 'Couverture'); // <-- ajout champ image
      ?>

      <div class="col-12 mt-4">
        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="admin_book.php" class="btn btn-secondary">Retour</a>
      </div>
    </form>
  </div>
</body>

</html>