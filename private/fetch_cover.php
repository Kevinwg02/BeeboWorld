<?php
include '../php/connexion.php';

$targetDir = __DIR__ . '/covers';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$sql = "SELECT ID, ISBN, Couverture FROM library WHERE (Couverture IS NULL OR Couverture = '') AND ISBN IS NOT NULL";
$stmt = $pdo->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Empiriquement, les images vides ont souvent ce hash (à vérifier sur ton système)
$knownEmptyHash = 'd41d8cd98f00b204e9800998ecf8427e';  // hash vide

foreach ($books as $book) {
    $isbn = preg_replace('/[^0-9Xx]/', '', $book['ISBN']);
    $imgUrl = "https://greenhousescribes.com/wp-content/uploads/2020/10/book-cover-generic.jpg";
    $localPath = "covers/{$isbn}.jpg";
    $savePath = __DIR__ . '/' . $localPath;

    // Vérifie si l’image existe
    $headers = @get_headers($imgUrl);
    if ($headers && strpos($headers[0], '200') !== false) {
        $imgData = file_get_contents($imgUrl);
        $hash = md5($imgData);

        // Vérifie que ce n’est pas une image vide ou générique
        if (strlen($imgData) > 500 && $hash !== $knownEmptyHash) {
            file_put_contents($savePath, $imgData);

            // Mise à jour DB
            $update = $pdo->prepare("UPDATE library SET Couverture = :path WHERE ID = :id");
            $update->execute([
                'path' => $localPath,
                'id' => $book['ID']
            ]);

            echo "✅ Image pour ISBN {$isbn} enregistrée.\n";
        } else {
            echo "⚠️ Image générique ignorée pour ISBN {$isbn}.\n";
        }
    } else {
        echo "❌ Aucune image trouvée pour ISBN {$isbn}.\n";
    }
}
