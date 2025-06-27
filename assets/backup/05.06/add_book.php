<?php
require 'connexion.php';

if (!isset($_POST['isbn']) || empty($_POST['isbn'])) {
  header('Location: ../index.php?error=ISBN manquant');
  exit;
}

$isbn = trim($_POST['isbn']);
$api_url = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";

// Appel API
$response = file_get_contents($api_url);
$data = json_decode($response, true);

if (!isset($data['items'][0])) {
  header('Location: ../index.php?error=Livre non trouvé');
  exit;
}

$book = $data['items'][0]['volumeInfo'];

// Extraction sécurisée
$titre = $book['title'] ?? '';
$auteur = $book['authors'][0] ?? '';
$description = $book['description'] ?? '';
$editeur = $book['publisher'] ?? '';
$date_pub = $book['publishedDate'] ?? '';
$categories = isset($book['categories']) ? implode(', ', $book['categories']) : '';
$langue = $book['language'] ?? '';
$nb_pages = $book['pageCount'] ?? 0;
$couverture = $book['imageLinks']['thumbnail'] ?? '';
$isbn_final = $isbn;

// Insertion dans la base
try {
  $stmt = $pdo->prepare("INSERT INTO Books 
    (titre, auteur, isbn, description, couverture, editeur, date_publication, categories, langue, nb_pages)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([
    $titre, $auteur, $isbn_final, $description, $couverture, $editeur,
    $date_pub, $categories, $langue, $nb_pages
  ]);
  header('Location: ../index.php?success=1');
} catch (PDOException $e) {
  header('Location: ../index.php?error=' . urlencode("Erreur BDD : " . $e->getMessage()));
}

