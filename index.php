<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'php/connexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère le hash en base
    $stmt = $pdo->query("SELECT admin_password FROM settings LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = $row['admin_password'];

    if (isset($_POST['password']) && password_verify($_POST['password'], $hash)) {
        $_SESSION['authenticated'] = true;
        header('Location: php/library.php'); // Redirige vers la page protégée
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <title>BeeboWorld</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <section class="LoginBox" action="" method="post">
        <span> <i class="fas fa-user-shield"></i></span>
        <h1>BeeboWorld</h1> <br>
        <form method="post" action="">
            <input class="password" type="password" placeholder="password" name="password" required> </input>
            <br>
            <button class="loginbtn" name="valider" type="submit">Login </button>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        </form>
    </section>
</body>

</html>