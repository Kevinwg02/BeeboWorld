<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /index.php');  // ← corrige bien le chemin
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID invalide.");
}

// Traitement formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contenu = $_POST['contenu'] ?? '';
    $nb_mots = (int)($_POST['nb_mots'] ?? 0);
    $chapitre = trim($_POST['chapitre'] ?? '');
    $date_ajout = $_POST['date_ajout'] ?? '';

    // Validation simple
    if ($chapitre === '' || $contenu === '' || !$date_ajout) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("UPDATE nano SET contenu = ?, nb_mots = ?, chapitre = ?, date_ajout = ? WHERE id = ?");
        $stmt->execute([$contenu, $nb_mots, $chapitre, $date_ajout, $id]);

        // Récupérer projet_id pour redirection
        $stmt2 = $pdo->prepare("SELECT projet_id FROM nano WHERE id = ?");
        $stmt2->execute([$id]);
        $projet_id = $stmt2->fetchColumn();

        header("Location: nanoedit.php?id=$id&success=1");
        exit;
    }
}

// Récupérer l'entrée
$stmt = $pdo->prepare("SELECT * FROM nano WHERE id = ?");
$stmt->execute([$id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entry) {
    die("Entrée introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier l'entrée Nano #<?= htmlspecialchars($id) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Modifier l'entrée Nano #<?= htmlspecialchars($id) ?></h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success">Modification enregistrée avec succès.</div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="chapitre" class="form-label">Chapitre</label>
            <input type="text" name="chapitre" id="chapitre" class="form-control" required
                value="<?= htmlspecialchars($entry['chapitre']) ?>" />
        </div>
        <div class="mb-3">
            <label for="date_ajout" class="form-label">Date d'ajout</label>
            <input type="date" name="date_ajout" id="date_ajout" class="form-control" required
                value="<?= htmlspecialchars($entry['date_ajout']) ?>" />
        </div>
        <div class="mb-3">
            <label for="nb_mots" class="form-label">Nombre de mots</label>
            <input type="number" name="nb_mots" id="nb_mots" class="form-control" min="0" required
                value="<?= (int)$entry['nb_mots'] ?>" />
        </div>
        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea name="contenu" id="contenu" rows="10" class="form-control" required><?= htmlspecialchars($entry['contenu']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="nanoproject.php?projet_id=<?= (int)$entry['projet_id'] ?>" class="btn btn-secondary ms-2">Retour au projet</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
