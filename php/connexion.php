<?php
$host = 'localhost';
$dbname = 'DbBeeboWorld';
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbname";
// $sql = "SELECT * FROM Books";
  $sql = "SELECT 
    Books.*, 
    Medaille.nom AS medaille_nom, 
    Genre.nom AS genre_nom, 
    typeLivre.nom AS typeLivre_nom
FROM 
    Books 
LEFT JOIN 
    Medaille 
ON 
    Books.medaille_id = Medaille.id
LEFT JOIN 
    Genre 
ON 
    Books.genre_id = Genre.id
LEFT JOIN 
    typeLivre 
ON 
    Books.typeLivre_id = typeLivre.id;
";

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
