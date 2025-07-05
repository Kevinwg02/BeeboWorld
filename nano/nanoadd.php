<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /index.php');  // ← corrige bien le chemin
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

$message = null;

// Récupère les projets existants
$existingProjects = $pdo->query("SELECT id, nom FROM projets ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projet_id = null;

    // Nouveau projet
    if (!empty($_POST['projet_new'])) {
        $projet_nom = trim($_POST['projet_new']);
        $couverture = trim($_POST['couverture'] ?? '');
        $themes_input = trim($_POST['themes'] ?? '');
        $themes_array = array_filter(array_map('trim', explode(';', $themes_input)));
        $date_debut = $_POST['date_debut'] ?: null;
        $date_fin = $_POST['date_fin'] ?: null;
        $etat = trim($_POST['etat'] ?? '');
        $resume = trim($_POST['resume'] ?? '');

        // Vérifie si le projet existe
        $stmt = $pdo->prepare("SELECT id FROM projets WHERE nom = ?");
        $stmt->execute([$projet_nom]);
        $existing = $stmt->fetch();

        if ($existing) {
            $projet_id = $existing['id'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO projets (nom, couverture, date_debut, date_fin, etat, resume) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$projet_nom, $couverture, $date_debut, $date_fin, $etat, $resume]);
            $projet_id = $pdo->lastInsertId();
        }

        // Ajout des thèmes
        if ($projet_id && count($themes_array) > 0) {
            foreach ($themes_array as $theme) {
                $stmt = $pdo->prepare("SELECT id FROM themes WHERE nom = ?");
                $stmt->execute([$theme]);
                $theme_data = $stmt->fetch();

                if ($theme_data) {
                    $theme_id = $theme_data['id'];
                } else {
                    $stmt = $pdo->prepare("INSERT INTO themes (nom) VALUES (?)");
                    $stmt->execute([$theme]);
                    $theme_id = $pdo->lastInsertId();
                }

                // Associer projet <-> thème
                $stmt = $pdo->prepare("INSERT IGNORE INTO projets_themes (projet_id, theme_id) VALUES (?, ?)");
                $stmt->execute([$projet_id, $theme_id]);
            }
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
<div class="container mt-4">

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

        <!-- Champs supplémentaires si nouveau projet -->
        <div id="newProjectFields" class="d-none">
            <div class="mb-3">
                <label class="form-label">Couverture (URL)</label>
                <input type="text" name="couverture" class="form-control" placeholder="https://...">
            </div>
            <div class="mb-3">
                <label class="form-label">Thèmes</label>
                <input type="text" name="themes" class="form-control" placeholder="fantasy ; action ; etc.">
                <small class="text-muted">Sépare les thèmes par des points-virgules (;)</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Date de début</label>
                <input type="date" name="date_debut" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Date de fin</label>
                <input type="date" name="date_fin" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">État</label>
                <input type="text" name="etat" class="form-control" placeholder="En cours, Terminé, etc.">
            </div>
            <div class="mb-3">
                <label class="form-label">Résumé</label>
                <textarea name="resume" class="form-control" rows="3"></textarea>
            </div>
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
    const newFields = document.getElementById('newProjectFields');

    if (select.value === '__new__') {
        input.classList.remove('d-none');
        input.setAttribute('name', 'projet_new');
        input.setAttribute('required', 'required');
        newFields.classList.remove('d-none');
        select.setAttribute('disabled', 'disabled');
    } else {
        input.classList.add('d-none');
        input.removeAttribute('required');
        input.removeAttribute('name');
        input.value = '';
        newFields.classList.add('d-none');
        select.removeAttribute('disabled');
    }
}

</script>

</body>
</html>
