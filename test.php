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
                <p class="auteur">Auteur: <?php echo htmlspecialchars($row['auteur']); ?></p>
                <p class="saga">Saga: <?php echo htmlspecialchars($row['saga']); ?></p>
                <p class="isbn">ISBN: <?php echo htmlspecialchars($row['isbn']); ?></p>
                <p class="prix">Prix: €<?php echo htmlspecialchars($row['prix']); ?></p>
                <p class="maisonEdition">Maison d'édition: <?php echo htmlspecialchars($row['maisonEdition']); ?></p>
                <p class="medaille">Medaille: <?php echo htmlspecialchars($row['medaille_nom']); ?></p>
                <p class="theme">Theme: <?php echo htmlspecialchars($row['genre_nom']); ?></p>
                <p class="datePublication">Date d'achat: <?php echo htmlspecialchars($row['dateAchat']); ?></p>
                <p class="dateLecture">Date de lecture: <?php echo htmlspecialchars($row['dateLecture']); ?></p>
                <p class="typeLivre">Type de livre: <?php echo htmlspecialchars($row['typeLivre_nom']); ?></p>
                <p class="nbPage">Nombre de Pages: <?php echo htmlspecialchars($row['nbPage']); ?></p>
            </div>
        </div>
  <?php endwhile; ?>
  </tbody>
  </table>
</body>
</html>

