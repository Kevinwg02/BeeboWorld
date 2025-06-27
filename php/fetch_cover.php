<?php
include 'connexion.php';

$targetDir = __DIR__ . '/covers';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$sql = "SELECT ID, ISBN, Couverture FROM library WHERE (Couverture IS NULL OR Couverture = '') AND ISBN IS NOT NULL";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($books as $book) {
    $isbn = preg_replace('/[^0-9Xx]/', '', $book['ISBN']);
    $imgUrl = "https://covers.openlibrary.org/b/isbn/{$isbn}-L.jpg";
    $localPath = "covers/{$isbn}.jpg";
    $savePath = __DIR__ . '/' . $localPath;

    // Check if image exists on Open Library
    $headers = @get_headers($imgUrl);
    if ($headers && strpos($headers[0], '200') !== false) {
        // Download and save locally
        file_put_contents($savePath, file_get_contents($imgUrl));

        // Update DB with local path
        $update = $pdo->prepare("UPDATE library SET Couverture = :path WHERE ID = :id");
        $update->execute([
            'path' => $localPath,
            'id' => $book['ID']
        ]);

        echo "✅ Image for ISBN {$isbn} saved and updated.\n";
    } else {
        echo "❌ No image found for ISBN {$isbn}.\n";
    }
}
?>
