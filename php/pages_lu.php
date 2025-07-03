<?php
include 'connexion.php';

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
