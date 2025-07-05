<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /php/login.php');
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

// Suppression projet
if (isset($_GET['delete'])) {
    $deleteId = (int) $_GET['delete'];
    $pdo->prepare("DELETE FROM projets WHERE id = ?")->execute([$deleteId]);
    header("Location: adminnano.php?success=1");
    exit;
}

// Filtres
$search = $_GET['search'] ?? '';
$etatFilter = $_GET['etat'] ?? '';

$whereClauses = [];
$params = [];

if ($search) {
    $whereClauses[] = "(nom LIKE :search OR resume LIKE :search)";
    $params[':search'] = "%$search%";
}

if ($etatFilter) {
    $whereClauses[] = "etat = :etat";
    $params[':etat'] = $etatFilter;
}

$whereSQL = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Pagination
$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// Comptage total
$countSql = "SELECT COUNT(*) FROM projets $whereSQL";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalProjets = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalProjets / $limit);

// Récupération projets
$sql = "SELECT * FROM projets $whereSQL ORDER BY id DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);

// Lier les filtres
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
// Lier pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// États disponibles
$etats = ['En cours', 'Terminé', 'En pause'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Projets Nano</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/themes.css" />
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">📚 Beeboworld</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/nano/nano.php">✍️ Nano Projets</a></li>
        <li class="nav-item"><a class="nav-link" href="/nano/nanoadd.php">➕ Ajouter Nano</a></li>
        <li class="nav-item"><a class="nav-link" href="/nano/nanostats.php">📊 Nano Stats</a></li>
        <li class="nav-item"><a class="nav-link" href="/nano/nanostats.php">🛠️ Admin Nano</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="/private/admin_book.php">🛠️ Admin</a></li>
        <li class="nav-item"><a class="nav-link" href="/private/stats.php">📊 Stats</a></li>
        <li class="nav-item"><a class="nav-link" href="/private/library.php">📚 Library</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid py-4">
  <h1 class="mb-4">🛠️ Administration des projets Nano</h1>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Projet supprimé avec succès.</div>
  <?php endif; ?>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Recherche par nom ou résumé..." value="<?= htmlspecialchars($search) ?>" />
    </div>
    <div class="col-md-3">
      <select name="etat" class="form-select">
        <option value="">Tous les états</option>
        <?php foreach ($etats as $etat): ?>
          <option value="<?= htmlspecialchars($etat) ?>" <?= $etat === $etatFilter ? 'selected' : '' ?>><?= htmlspecialchars($etat) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary">Filtrer</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered table-hover bg-white table-sm align-middle">
      <thead class="table-light text-center">
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Couverture</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>État</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($projets) === 0): ?>
          <tr><td colspan="7" class="text-center">Aucun projet trouvé.</td></tr>
        <?php else: ?>
          <?php foreach ($projets as $projet): ?>
            <tr>
              <td class="text-center"><?= $projet['id'] ?></td>
              <td><?= htmlspecialchars($projet['nom']) ?></td>
              <td class="text-center">
                <?php if ($projet['couverture']): ?>
                  <img src="<?= htmlspecialchars($projet['couverture']) ?>" alt="Couverture" style="height:50px; object-fit:contain;" />
                <?php else: ?>
                  —
                <?php endif; ?>
              </td>
              <td class="text-center"><?= $projet['date_debut'] ?? '—' ?></td>
              <td class="text-center"><?= $projet['date_fin'] ?? '—' ?></td>
              <td class="text-center"><?= htmlspecialchars($projet['etat']) ?></td>
              <td class="text-center">
                <a href="?delete=<?= $projet['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce projet ?')">Supprimer</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Pagination">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" tabindex="-1">Précédent</a>
        </li>
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
          <li class="page-item <?= $p === $page ? 'active' : '' ?>">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"><?= $p ?></a>
          </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Suivant</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
