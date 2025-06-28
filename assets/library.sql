-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 28 juin 2025 à 22:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbbeeboworld`
--

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
  `ID` int(11) NOT NULL,
  `Auteur` varchar(50) NOT NULL,
  `Titre` varchar(62) NOT NULL,
  `Dedicace` varchar(3) NOT NULL,
  `Marquepages` varchar(30) DEFAULT NULL,
  `Goodies` varchar(30) DEFAULT NULL,
  `ISBN` varchar(17) DEFAULT NULL,
  `Format` varchar(14) DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  `Date_achat` varchar(10) DEFAULT NULL,
  `Date_lecture` date DEFAULT NULL,
  `Relecture` date DEFAULT NULL,
  `Chronique_ecrite` varchar(30) DEFAULT NULL,
  `Chronique_publiee` varchar(30) DEFAULT NULL,
  `Details` varchar(255) DEFAULT NULL,
  `Chronique` varchar(255) DEFAULT NULL,
  `Maison_edition` varchar(39) DEFAULT NULL,
  `Nombre_pages` varchar(4) DEFAULT NULL,
  `Notation` varchar(13) DEFAULT NULL,
  `Genre` varchar(28) DEFAULT NULL,
  `Couverture` varchar(255) DEFAULT NULL,
  `Couple` varchar(37) DEFAULT NULL,
  `Themes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`ID`, `Auteur`, `Titre`, `Dedicace`, `Marquepages`, `Goodies`, `ISBN`, `Format`, `Prix`, `Date_achat`, `Date_lecture`, `Relecture`, `Chronique_ecrite`, `Chronique_publiee`, `Details`, `Chronique`, `Maison_edition`, `Nombre_pages`, `Notation`, `Genre`, `Couverture`, `Couple`, `Themes`) VALUES
(1, '12 mains', 'L\'amour s\'invite... noël', 'Non', 'Non', 'Non', '978-2-298-16712-2', 'Papier', 5.00, '2021-10-12', '2022-05-31', '0000-00-00', 'Non', NULL, NULL, '', 'Editions France Loisirs', '273', 'Bronze', 'Romances de noël', NULL, 'Multiples', NULL),
(2, 'A.J. Broochmitt', 'Ces maux que nous taisons', 'Non', 'Non', 'Non', '978-2-755-67830-7', 'Papier', 17.00, '2025-03-08', '2024-11-05', '2025-06-16', 'Non', 'Non', '\"La vie est comme ça. Elle ne tient qu’à un fil.\"\r\n\r\nJeune et talentueuse, Erine Peters se prépare à débuter sa deuxième année d\'internat en chirurgie. Mais un drame vient chambouler sa vie, la conduisant à quitter sa région pour le nouvel hôpital de Twin', '', 'Hugo Romans', '442', 'Bronze', 'Romance contemporaine', 'https://cdn.cultura.com/cdn-cgi/image/width=830/media/pim/TITELIVE/3_9782755678307_1_75.jpg', '', NULL),
(3, 'Acacia Black', 'Midnight Kiss', 'Non', 'Non', 'Non', '979-1-042-90092-2', 'Papier', 18.00, '2025-05-26', '2016-02-08', '0000-00-00', 'Non', 'Non', 'Une vidéo, un mensonge, une chance de tout sauver… mais à quel prix ?\r\n\r\nÀ Golden Hills University, où les relations entre athlètes sont strictement interdites, Nova et Cassius, basketteurs prometteurs que tout semble opposer, partagent un lien inattendu ', '', 'Hugo Romans', '689', 'Bronze', 'Campus Romance', 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/78/8f/1a/18517880/1540-1/tsp20250522080110/Midnight-Ki.jpg', 'Nova & Cassius', NULL),
(4, 'Adriana Dreux', 'Mysterious R', 'Non', 'Non', 'Non', '978-2-755-69193-1', 'Papier', 7.00, '2023-05-27', '2024-01-07', '2025-06-17', 'Non', 'Non', 'Angela en a marre. Les relations barbantes, elle en a fait le tour : elle veut un homme qui la fasse vibrer. Entre son goinfre de chat, sa meilleure amie un peu trop curieuse et son apollon de patron qui ne la regarde que pour critiquer son travail, elle ', '', 'Hugo Poche', '391', 'Bronze', 'Comédie romantique', 'https://cdn1.booknode.com/book_cover/4920/mysterious_r-4919900-264-432.webp', 'Angela & Andrea', NULL),
(5, 'AG Nevro', 'Not this time', 'Non', 'Non', 'Non', '978-2-380-15655-3', 'E-book', 7.00, '2023-06-23', '2025-02-02', '2025-06-17', 'Non', 'Non', 'De la haine à l\'amour, il n\'y a qu\'un pas\r\n\r\nAprès avoir sillonné les routes américaines, Ella et sa mère sont de retour à Ocean Bay, ville côtière de Californie qu’elles ont quittée un an plus tôt pour tenter d’oublier les problèmes auxquels toutes deux ', '', 'Nisha & Caetera', '528', 'Argent', 'Fantastic', 'https://cdn.cultura.com/cdn-cgi/image/width=450/media/pim/22_metadata-image-66441037.jpeg', '', NULL),
(6, 'Alex Aster', 'Lightlark T1', 'Non', 'Non', 'Non', '978-2-371-02370-3', 'Papier', NULL, '2023-04-01', '2015-06-16', '0000-00-00', '', '', '', '', 'Lumen', '600', 'Platinum', 'Fantasy', NULL, '', NULL),
(8, 'Alexandra Ivy', 'Les Guardiens de l\'éternité T5', 'Non', 'Non', 'Non', '978-2-811-20657-4', 'Papier', 8.00, '2019-09-15', '2025-03-03', '2025-06-16', 'Non', 'Non', 'Jagr est un solitaire. Mais en tant que membre du puissant clan de vampires de Chicago, certaines obligations lui incombent. La dernière : retrouver une sang-pur et la conduire auprès de sa soeur. Le problème : Regan Garrett n\'a nullement l\'intention de s', '', 'Editions Milady', '465', 'Bronze', '', 'https://m.media-amazon.com/images/I/816r9yuM0DL._AC_UF1000,1000_QL80_.jpg', '', NULL),
(9, 'Alexandra Ivy', 'Les Gardiens de l\'éternité T1', 'Non', 'Non', 'Non', '978-2-811-20512-6', 'Papier', 7.00, NULL, '2017-05-30', NULL, NULL, NULL, NULL, '', 'Editions Milady', '371', NULL, NULL, NULL, NULL, NULL),
(10, 'Alexiane De Lys', 'De sang, d\'écume et de glace T1', 'Non', 'Non', 'Non', '979-1-022-40577-5', 'Papier', 7.00, '2024-04-13', '2025-08-09', '2025-06-16', 'Non', 'Non', 'La perspective de passer ce qui pourrait être son dernier été loin de chez elle n\'enchante pas vraiment Perséphone. La jeune fille atteinte d\'une mystérieuse maladie qui l\'affaiblit de jour en jour se retrouve coincée dans le Finistère, chez une tante exc', '', 'Michel Lafon Poche', '624', 'Bronze', 'Romance', 'https://cdn1.booknode.com/book_cover/1483/full/de-sang-decume-et-de-glace-tome-1-metamorphose-1482868.jpg', '', NULL),
(11, 'Ali Hazelwood', 'Bride', 'Non', 'Non', 'Non', '978-2-811-22683-1', 'Hard back', 24.00, '2025-02-17', '2025-04-08', '2025-07-19', 'Non', 'Non', 'Misery Lark, la fille unique du conseiller vampyre le plus puissant du Sud-Ouest, est une paria... de nouveau. Les jours où elle vivait dans l\'anonymat parmi les humains sont désormais derrière elle : on a fait appel à elle pour renforcer une alliance his', '', 'Editions Milady', '442', 'Argent', '', 'https://cdn.cultura.com/cdn-cgi/image/width=830/media/pim/TITELIVE/30_9782811226831_1_75.jpg', '', NULL),
(12, 'Alice Oseman', 'Solitaire T1', 'Non', 'Non', 'Non', '978-2-095-02718-6', 'Hard back', 7.00, '2024-02-07', '2016-03-09', '2025-06-06', 'Oui', 'Non', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '', 'Nathan Romans', '395', 'Or', '', 'https://static.fnac-static.com/multimedia/PE/Images/FR/NR/0f/5a/00/16800271/1540-1/tsp20250412072704/SOLITAIRE.jpg', '', NULL),
(13, 'Alice Oseman', 'Heartstopper T1', 'Non', 'Non', 'Non', '978-2-017-10831-3', 'BD', 12.00, '2025-03-22', '2025-03-25', '2025-06-27', 'Non', 'Non', 'description heartstopperdescription heartstopperdescription heartstopperdescription heartstopper', '', 'Hachette Romans', '269', 'Argent', 'Romance contemporaine', 'https://img.chasse-aux-livres.fr/v7/_zmx1_/51OCz3XzlVL.jpg?w=230&h=250&func=fit&bg_opacity=0', 'Charle & Ben', NULL),
(15, 'A.G. Nevro', 'Not this time - Tome 1', 'Non', 'Non', 'Non', '9782380156553', 'E-book', 12.50, '2025-01-05', '2025-01-07', '2025-06-28', '', '', 'La série phénomè', '', 'Nisha et caetera', '327', 'Platinum', 'romance', 'https://cdn.cultura.com/cdn-cgi/image/width=830/media/pim/TITELIVE/40_9782380156546_1_75.jpg', '', NULL),
(20, 'Brigitte Gandiol-Coppin', 'Pierre après pierre, la cathédrale', 'Non', 'Non', 'Non', '9782075112545', 'Papier', 0.00, '2025-04-02', '2025-06-03', '2025-04-09', '', '', 'Quand les cathéd', '', 'FeniXX', '41', 'Platinum', 'Juvenile Nonfiction', 'http://books.google.com/books/content?id=bZ7_EAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', '', NULL),
(22, 'Stephenie Meyer', 'The Chemist', 'Non', 'Non', 'Non', '9780751567663', 'Papier', 5.00, '2025-06-09', '2024-03-12', '2025-06-29', 'Non', 'Non', 'In this gripping page-turner, an ex-agent on the run from her former employers must take one more case to clear her name and save her life. The brand-new thriller from international number one bestseller Stephenie Meyer. She used to work for the U.S. gove', '', 'Hachette UK', '582', 'Argent', 'Fiction', 'http://books.google.com/books/content?id=DNmxDAAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', '', NULL),
(28, 'Alex Flinn', 'Beastly', 'Non', 'Non', 'Non', '978-0-061-99866-9', 'Hardback', 0.00, '2025-01-09', '2021-01-13', '2019-04-01', '', '', 'A beast. Not quite wolf or bear, gorilla or dog but a horrible new creature who walks upright—a creature with fangs and claws and hair springing from every pore. I am a monster. You think I\'m talking fairy tales? No way. The place is New York City. The ti', '', 'Harper Collins', '343', 'Platinum', 'Juvenile Fiction', 'http://books.google.com/books/content?id=7xJKxbP5pL0C&printsec=frontcover&img=1&zoom=1&source=gbs_api', '', NULL),
(29, 'Rebecca Yarros', 'Onyx Storm - Version française', 'Non', 'Non', 'Non', '9782755673104', 'Hardback', 0.00, '2024-01-18', '2025-06-27', '2022-05-10', 'Oui', 'Non', 'AFFRONTER LES TÉNÈBRES La guerre prend un tournant massif mais le plus grand risque vient désormais de l\'intérieur. Plus amoureuse que jamais, Violet est bien décidée à affronter les ténèbres.', 'Chronique: AFFRONTER LES TÉNÈBRES La guerre prend un tournant massif mais le plus grand risque vient désormais de l\'intérieur. Plus amoureuse que jamais, Violet est bien décidée à affronter les ténèbres.', 'Hugo Roman', '766', 'Platinum', 'Fiction', 'http://books.google.com/books/content?id=-yU9EQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', 'Xaden & Violet', NULL),
(30, 'Rebecca Yarros', 'Onyx Storm', 'Non', 'Non', 'Non', '9789510514993', 'Hardback', 0.00, '2022-06-09', '2025-02-10', '2017-04-02', '', '', 'Brave the dark. Get ready to fly or die in the breathtaking follow-up to Fourth Wing and Iron Flame from the no. 1 Sunday Times and New York Times bestselling author Rebecca Yarros. Returning to the richly imagined world of Fourth Wing and Iron Flame, the', '', 'WSOY', '626', 'Platinum', 'Fiction', 'http://books.google.com/books/content?id=cYwdEQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api', '', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
