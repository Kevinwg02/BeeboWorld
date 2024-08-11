<?php
  include 'php/connexion.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeboWorld</title>

    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="book">
            <div class="img">
                <img src="<?php echo htmlspecialchars($row['couverture']); ?>" alt="Cover Image">
            </div>
            <div class="all">
                <h2 class="titre"><?php echo htmlspecialchars($row['titre']); ?></h2>
                <p class="auteur">Author: <?php echo htmlspecialchars($row['auteur']); ?></p>
                <p class="saga">Saga: <?php echo htmlspecialchars($row['saga']); ?></p>
                <p class="isbn">ISBN: <?php echo htmlspecialchars($row['isbn']); ?></p>
                <p class="prix">Price: $<?php echo htmlspecialchars($row['prix']); ?></p>
                <p class="maisonEdition">Publishing House: <?php echo htmlspecialchars($row['maisonEdition']); ?></p>
                <p class="classe">Class: <?php echo htmlspecialchars($row['classe']); ?></p>
                <p class="theme">Theme: <?php echo htmlspecialchars($row['theme']); ?></p>
                <p class="datePublication">Publication Date: <?php echo htmlspecialchars($row['datePublication']); ?></p>
                <p class="dateLecture">Date of Reading: <?php echo htmlspecialchars($row['dateLecture']); ?></p>
                <p class="typeLivre">Type: <?php echo htmlspecialchars($row['typeLivre']); ?></p>
                <p class="nbPage">Pages: <?php echo htmlspecialchars($row['nbPage']); ?></p>
            </div>
        </div>
  <?php endwhile; ?>
  </tbody>
  </table>
</body>
</html>

