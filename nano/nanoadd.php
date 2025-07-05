<?php
include '../php/connexion.php';

$message = null;

// Récupère les projets existants (id + nom)
$existingProjects = $pdo->query("SELECT id, nom FROM projets ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projet_id = null;

    // Nouveau projet
    if (!empty($_POST['projet_new'])) {
        $projet_nom = trim($_POST['projet_new']);
        $stmt = $pdo->prepare("SELECT id FROM projets WHERE nom = ?");
        $stmt->execute([$projet_nom]);
        $existing = $stmt->fetch();

        if ($existing) {
            $projet_id = $existing['id'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO projets (nom) VALUES (?)");
            $stmt->execute([$projet_nom]);
            $projet_id = $pdo->lastInsertId();
        }
    }
    // Projet existant
    elseif (!empty($_POST['projet_select'])) {
        $projet_id = (int) $_POST['projet_select'];
    }

    $chapitre = trim($_POST['chapitre']);
    $date = $_POST['date'] ?: date('Y-m-d');
    $contenu = trim($_POST['contenu']);
    $nb_mots = str_word_count(strip_tags($contenu));

    if ($projet_id && $chapitre && $nb_mots > 0) {
        $stmt = $pdo->prepare("INSERT INTO nano (projet_id, chapitre, date_ajout, nb_mots, contenu) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$projet_id, $chapitre, $date, $nb_mots, $contenu]);
        $message = "Ajout effectué avec succès 🎉";
    } else {
        $message = "Merci de remplir tous les champs obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un contenu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">📚 Beeboworld</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Section Nano -->
                <li class="nav-item">
                    <a class="nav-link" href="/nano/nano.php">✍️ Nano Projets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/nano/nanoadd.php">➕ Ajouter Nano</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- Section Admin -->
                <li class="nav-item">
                    <a class="nav-link" href="/private/admin_book.php">🛠️ Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/stats.php">📊 Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/library.php">📚 Library</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/private/add_manual.php">➕ Ajout manuel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn" data-bs-toggle="modal" data-bs-target="#pagesModal" href="#">📖 Pages lues</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <h1 class="mb-4 text-center">✍️ Ajouter du contenu</h1>

    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Projet</label>
            <select id="projetSelect" name="projet_select" class="form-select" required onchange="toggleNewProject(this)">
                <option value="">-- Sélectionner un projet --</option>
                <?php foreach ($existingProjects as $proj): ?>
                    <option value="<?= $proj['id'] ?>"><?= htmlspecialchars($proj['nom']) ?></option>
                <?php endforeach; ?>
                <option value="__new__">➕ Nouveau projet</option>
            </select>

            <input type="text" id="newProjectInput" name="projet_new" class="form-control mt-2 d-none" placeholder="Nom du nouveau projet">
        </div>

        <div class="mb-3">
            <label class="form-label">Chapitre</label>
            <input type="text" name="chapitre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenu</label>
            <textarea name="contenu" class="form-control" rows="6" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="nano.php" class="btn btn-secondary ms-2">Retour</a>
    </form>
</div>

<script>
function toggleNewProject(select) {
    const input = document.getElementById('newProjectInput');
    if (select.value === '__new__') {
        input.classList.remove('d-none');
        input.setAttribute('required', 'required');
        select.removeAttribute('name');
    } else {
        input.classList.add('d-none');
        input.removeAttribute('required');
        input.value = '';
        select.setAttribute('name', 'projet_select');
    }
}
</script>
</body>
</html>
