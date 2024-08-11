<?php
$host = 'localhost';
$dbname = 'DbBeeboWorld';
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbname";
$sql = "SELECT * FROM Books";

try {
  $pdo = new PDO($dsn, $username, $password);
  $stmt = $pdo->query($sql);

  if ($stmt === false) {
    die("Erreur");
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>