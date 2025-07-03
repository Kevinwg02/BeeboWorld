<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../php/connexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->query("SELECT admin_password FROM settings LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $row['admin_password'];

    if (isset($_POST['password']) && password_verify($_POST['password'], $hash)) {
        $_SESSION['authenticated'] = true;
        header('Location: ../private/library.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>beeboworld</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      
    }
    .cover-img {
      background-image: url('../assets/images/lea.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row vh-100">
    <!-- Image de couverture -->
    <div class="col-md-6 d-none d-md-block cover-img"></div>

    <!-- Formulaire -->
    <div class="col-md-6 d-flex align-items-center justify-content-center bg-dark text-white">
      <div class="w-75">
        <h2 class="mb-4 text-center">Connexion à la beeboworld</h2>
        <form method="POST" action="">
          <div class="mb-4">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
              <?= htmlspecialchars($error) ?>
            </div>
          <?php endif; ?>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Se connecter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
