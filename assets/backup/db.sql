-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 07 juin 2025 à 22:58
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
  `Dedicace` varchar(1) DEFAULT NULL,
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
  `Details` varchar(16) DEFAULT NULL,
  `Maison_edition` varchar(39) DEFAULT NULL,
  `Nombre_pages` varchar(4) DEFAULT NULL,
  `Notation` varchar(13) DEFAULT NULL,
  `Genre` varchar(28) DEFAULT NULL,
  `Couverture` varchar(255) DEFAULT NULL,
  `Couple` varchar(37) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`ID`, `Auteur`, `Titre`, `Dedicace`, `Marquepages`, `Goodies`, `ISBN`, `Format`, `Prix`, `Date_achat`, `Date_lecture`, `Relecture`, `Chronique_ecrite`, `Chronique_publiee`, `Details`, `Maison_edition`, `Nombre_pages`, `Notation`, `Genre`, `Couverture`, `Couple`) VALUES
(1, '12 mains', 'L\'amour s\'invite... noël', NULL, NULL, NULL, '978-2-298-16712-2', 'Papier', 5.00, '2021-10-12', '2022-05-31', '0000-00-00', 'Non', NULL, NULL, 'Editions France Loisirs', '273', 'Bronze', 'Romances de noël', NULL, 'Multiples'),
(2, 'A.J. Broochmitt', 'Ces maux que nous taisons', NULL, NULL, NULL, '978-2-755-67830-7', 'Papier', 17.00, '2025-03-08', NULL, NULL, NULL, NULL, NULL, 'Hugo Romans', '442', NULL, 'Romance contemporaine', NULL, NULL),
(3, 'Acacia Black', 'Midnight kiss', NULL, NULL, NULL, '979-1-042-90092-2', 'Papier', 18.00, '2025-05-26', NULL, NULL, NULL, NULL, NULL, 'Hugo Romans', '689', NULL, 'Campus Romance', NULL, 'Nova & Cassius'),
(4, 'Adriana Dreux', 'Mysterious R', NULL, NULL, NULL, '978-2-755-69193-1', 'Papier', 7.00, '2023-05-27', '2024-01-07', NULL, NULL, NULL, NULL, 'Hugo Poche', '391', 'Bronze', 'Comédie romantique', NULL, 'Angela & Andrea'),
(5, 'AG Nevro', 'Not this time', NULL, NULL, NULL, '978-2-380-15655-3', 'E-book', 7.00, '2023-06-23', NULL, NULL, NULL, NULL, NULL, 'Nisha & Caetera', '528', NULL, 'Fantastic', NULL, NULL),
(6, 'Alex Aster', 'Lightlark T1', '', '', '', '978-2-371-02370-3', 'Papier', NULL, '2023-04-01', '0000-00-00', '0000-00-00', '', '', '', 'Lumen', '600', '', 'Fantasy', NULL, ''),
(7, 'Alex Flinn', 'Kendra Chronicles T1 VO - Beasty', NULL, NULL, NULL, '978-0-061-99866-9', 'Papier', 11.00, '2022-08-07', NULL, NULL, NULL, NULL, NULL, 'Harper Teen', '300', NULL, NULL, NULL, NULL),
(8, 'Alexandra Ivy', 'Les Guardiens de l\'éternité T5', NULL, NULL, NULL, '978-2-811-20657-4', 'Papier', 8.00, '2019-09-15', NULL, NULL, NULL, NULL, NULL, 'Editions Milady', '465', NULL, NULL, NULL, NULL),
(9, 'Alexandra Ivy', 'Les Gardiens de l\'éternité T1', NULL, NULL, NULL, '978-2-811-20512-6', 'Papier', 7.00, NULL, NULL, NULL, NULL, NULL, NULL, 'Editions Milady', '371', NULL, NULL, NULL, NULL),
(10, 'Alexiane De Lys', 'De sang, d\'écume et de glace T1', NULL, NULL, NULL, '979-1-022-40577-5', 'Papier', 7.00, '2024-04-13', NULL, NULL, NULL, NULL, 'Amélie', 'Michel Lafon Poche', '624', NULL, NULL, NULL, NULL),
(11, 'Ali Hazelwood', 'Bride', NULL, NULL, NULL, '978-2-811-22683-1', 'Hard back', 24.00, '2025-02-17', NULL, NULL, NULL, NULL, 'Kevin', 'Editions Milady', '442', NULL, NULL, NULL, NULL),
(12, 'Alice Oseman', 'Solitaire T1', '', '', '', '978-2-095-02718-6', 'Hard back', 7.00, '2024-02-07', '0000-00-00', '2025-06-06', '', '', '', 'Nathan Romans', '395', 'or', '', '', ''),
(13, 'Alice Oseman', 'Heartstopper T1', NULL, NULL, NULL, '978-2-017-10831-3', 'BD', 12.00, '2025-03-22', '2025-03-25', NULL, NULL, NULL, NULL, 'Hachette Romans', '269', 'Argent', 'Romance contemporaine', NULL, 'Charle & Ben'),
(14, 'Alice Oseman', 'Deux garçons. Une rencontre', 'o', 'non', 'oui', '978-2-017-10831-3', 'Poche', 6.20, '2025-06-06', '2025-06-07', '0000-00-00', 'non', 'non', 'Vol. 1: Deux gar', 'Hachette Romans', '250', '', '', 'https://images.isbndb.com/covers/4577393482906.jpg', ''),
(15, 'A.G. Nevro', 'Not this time - Tome 1', '', '', '', '9782380156553', 'ebook', 12.50, '2025-06-05', '2025-06-07', '0000-00-00', 'non', 'non', 'La série phénomè', 'Nisha et caetera', '327', '', 'romance', 'https://cdn.cultura.com/cdn-cgi/image/width=830/media/pim/TITELIVE/40_9782380156546_1_75.jpg', '');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
