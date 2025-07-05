<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: /php/login.php.php');  // ← corrige bien le chemin
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? null;
    $pages = $_POST['pages'] ?? null;

    if ($date && $pages) {
        $stmt = $pdo->prepare("INSERT INTO nb_page_lu (date, pages) VALUES (?, ?)");
        $stmt->execute([$date, $pages]);
    }

    header("Location: stats.php");
    exit;
}
?>
