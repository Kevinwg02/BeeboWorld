-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 03 juil. 2025 à 09:18
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
-- Structure de la table `lecture`
--

CREATE TABLE `lecture` (
  `id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `date_lecture` date NOT NULL,
  `date_relecture` date DEFAULT NULL,
  `chronique_ecrite` enum('oui','non') DEFAULT NULL,
  `chronique_publiee` enum('oui','non') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `Format` varchar(50) DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  `Date_achat` date DEFAULT NULL,
  `Date_lecture` date DEFAULT NULL,
  `Relecture` date DEFAULT NULL,
  `Chronique_ecrite` varchar(30) DEFAULT NULL,
  `Chronique_publiee` varchar(30) DEFAULT NULL,
  `Details` text DEFAULT NULL,
  `Chronique` text DEFAULT NULL,
  `Maison_edition` varchar(39) DEFAULT NULL,
  `Nombre_pages` varchar(4) DEFAULT NULL,
  `Notation` varchar(13) DEFAULT NULL,
  `Genre` varchar(28) DEFAULT NULL,
  `Couverture` varchar(255) DEFAULT '../assets/covers/TheAdventureOfBeebo.jpg',
  `Couple` varchar(255) DEFAULT NULL,
  `Themes` varchar(255) DEFAULT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`ID`, `Auteur`, `Titre`, `Dedicace`, `Marquepages`, `Goodies`, `ISBN`, `Format`, `Prix`, `Date_achat`, `Date_lecture`, `Relecture`, `Chronique_ecrite`, `Chronique_publiee`, `Details`, `Chronique`, `Maison_edition`, `Nombre_pages`, `Notation`, `Genre`, `Couverture`, `Couple`, `Themes`, `localisation`) VALUES
(38, 'Eugénie Dielens', 'Off Limits', 'Non', 'Non', 'Non', '9782017246541', 'Poche', 6.90, '2025-06-27', '2025-06-30', '0000-00-00', 'Oui', 'Non', 'Lorsque Diana se retrouve placée en famille d\'accueil, elle débarque, dépitée, chez les Williams, de riches new-yorkais. Les parents font tout pour la mettre à l\'aise, mais Diana ne supporte pas leur fils, Corey, un des garçons les plus populaires du lycée. Surtout depuis une certaine soirée passée ensemble quelques temps auparavant... Leurs échanges ne sont désormais que moqueries et réparties cinglantes.\r\n\r\nAux yeux de Corey, Diana représente tout ce qu\'il déteste et désire à la fois. Il voit dans cette colocation forcée une opportunité pour enfin réussir à séduire la jolie blonde... si Diana ne le repoussait pas. Corey le sait : Diana est inaccessible, hors limite. Mais maintenant qu\'ils sont obligés et vivre sous le même toit, la tentation est plus forte que jamais...', 'Une romance toute douce, sans prise de tête.\r\nProximité forcée, seconde chance, vie lycéenne. De quoi faire une très bonne romance pour cet été.\r\n\r\nDiana est un personnage en apparence sure d\'elle, mais qui cache en réalité énormément d\'incertitudes. Elle se donne les moyens de réussir, même si pour cela elle doit se tenir éloignée des autres. Et dans un lycée de riches, venir d\'une famille sans beaucoup de moyens peut créer certains préjugés.\r\n\r\nCorey est un personnage à qui tout semble réussir. Ou au moins en apparence : capitaine de l\'équipe de Lacrosse, une famille qui a les moyens, des recruteurs pour l\'université. Mais la réalité est toute autre : personne ne le connait vraiment.\r\n\r\nQuand ces deux ados se retrouvent sous le même toit, après avoir failli passer à l\'acte, les choses se compliquent. \r\nVont-ils réussir à cohabiter les quelques mois les séparant de l\'université ?\r\n\r\nSi j\'ai une chose à reprocher à ce roman, c\'est le nombre considérable de coquilles de fautes d\'accord et de mots manquants qui m\'ont coupé dans ma lecture à de trop nombreuses reprises.', 'Hachette - Ito', '275', 'Bronze', 'Romance contemporaine', 'https://media.hachette.fr/fit-in/780x1280/imgArticle/HACHETTELAB/2023/9782017246541-001-X.jpeg?source=web', 'Diana Cooper & Corey Williams', 'Seconde chance,  Désintoxication, Proximité forcée, Addiction, Famille d\'accueil, Lycée, Avenir', 'Bibliothèque physique'),
(39, 'Phoenix B Asher', 'Hotshot', 'Oui', 'Oui', 'Oui', '9782755679649', 'Grand Format', 17.50, '2025-04-12', '2025-07-02', '0000-00-00', '', '', 'Certains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...', '', 'Hugo Romans', '371', 'Or', 'Romance contemporaine', 'https://www.hugopublishing.fr/wp-content/uploads/yonix/9791042900120-649x1024.jpg', 'Salem O\'Connell & Jericho McKenna', 'Deuil, Seconde chance, Pompiers, Hotshot', 'Bibliothèque physique'),
(44, 'Aurore Payelle', 'Hockey Seattle T1 - Red Falcon', 'Non', 'Non', 'Non', '9782755678994', '', 8.90, '2025-06-27', '0000-00-00', '0000-00-00', '', '', 'Weston Parker, attaquant de l\'équipe de hockey de son université, est un paria parmi les étudiants. Depuis qu\'il a été mis en cause pour l\'agression de l\'un de ses coéquipiers, plus personne n\'ose l\'approcher, sa réputation le précède.\r\n\r\nCharlie, la petite sœur du capitaine des Huskies, vient rejoindre son frère Bill à Seattle pour sa troisième année d\'école d\'infirmière. Il est temps pour elle de faire table rase du passé, et de se reconstruire dans cette nouvelle ville. Pour Bill, une seule condition : qu\'elle reste loin de Weston. Mais la curiosité, ce vilain défaut, pousse Charlie à braver tous les interdits pour découvrir ce que cache le hockeyeur.\r\n\r\nWeston, impulsif et secret ? Charlie n\'y croit pas un instant. Attirée par lui comme un papillon par une flamme, elle ignore les mises en garde. Pourtant, fréquenter Weston pourrait s\'avérer plus dangereux qu\'il n\'y parait.\r\n\r\nAutant pour son cœur que pour sa sécurité...', '', 'Hugo Romans', '507', '', 'Campus Romance', 'https://www.hugopublishing.fr/wp-content/uploads/yonix/9782755678994-625x1024.jpg', '', '', 'Bibliothèque physique');

-- --------------------------------------------------------

--
-- Structure de la table `nb_page_lu`
--

CREATE TABLE `nb_page_lu` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pages` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nb_page_lu`
--

INSERT INTO `nb_page_lu` (`id`, `date`, `pages`) VALUES
(8, '2025-01-01', 372),
(9, '2025-01-02', 89),
(10, '2025-01-03', 58),
(11, '2025-01-04', 326),
(12, '2025-01-05', 66),
(13, '2025-01-06', 25),
(14, '2025-01-08', 15),
(15, '2025-01-09', 187),
(16, '2025-01-23', 72),
(17, '2025-01-24', 132),
(18, '2025-01-25', 94),
(19, '2025-01-27', 52),
(20, '2025-01-28', 124),
(21, '2025-01-29', 177),
(22, '2025-01-30', 51),
(23, '2025-01-31', 82),
(24, '2025-02-01', 248),
(25, '2025-02-02', 95),
(26, '2025-02-03', 38),
(27, '2025-02-04', 38),
(28, '2025-02-05', 14),
(29, '2025-02-06', 56),
(30, '2025-02-07', 74),
(31, '2025-02-11', 69),
(32, '2025-02-12', 80),
(33, '2025-02-13', 73),
(34, '2025-02-14', 78),
(35, '2025-02-15', 149),
(36, '2025-02-18', 138),
(37, '2025-02-19', 370),
(38, '2025-02-20', 74),
(39, '2025-02-27', 176),
(40, '2025-02-28', 432),
(41, '2025-03-01', 38),
(42, '2025-03-04', 274),
(43, '2025-03-05', 145),
(44, '2025-03-11', 126),
(45, '2025-03-12', 162),
(46, '2025-03-13', 220),
(47, '2025-03-14', 57),
(48, '2025-03-16', 23),
(49, '2025-03-17', 70),
(50, '2025-03-18', 143),
(51, '2025-03-19', 74),
(52, '2025-03-20', 54),
(53, '2025-03-21', 61),
(54, '2025-03-25', 269),
(55, '2025-03-26', 57),
(56, '2025-03-27', 60),
(57, '2025-03-28', 73),
(58, '2025-03-29', 78),
(59, '2025-03-30', 67),
(60, '2025-03-31', 42),
(61, '2025-04-01', 54),
(62, '2025-04-02', 80),
(63, '2025-04-04', 80),
(64, '2025-04-15', 110),
(65, '2025-04-16', 97),
(66, '2025-04-17', 107),
(67, '2025-04-18', 160),
(68, '2025-04-19', 102),
(69, '2025-04-22', 95),
(70, '2025-04-23', 180),
(71, '2025-04-24', 106),
(72, '2025-04-25', 190),
(73, '2025-04-29', 189),
(74, '2025-04-30', 130),
(75, '2025-05-06', 76),
(76, '2025-05-07', 123),
(77, '2025-05-13', 91),
(78, '2025-05-14', 48),
(79, '2025-05-15', 125),
(80, '2025-05-16', 56),
(81, '2025-05-20', 148),
(82, '2025-05-22', 78),
(83, '2025-05-27', 188),
(84, '2025-05-28', 180),
(85, '2025-05-30', 125),
(86, '2025-06-03', 111),
(87, '2025-06-04', 299),
(88, '2025-06-05', 305),
(89, '2025-06-06', 721),
(90, '2025-06-09', 324),
(91, '2025-06-10', 345),
(92, '2025-06-11', 195),
(93, '2025-06-12', 198),
(94, '2025-06-13', 214),
(95, '2025-06-15', 115),
(96, '2025-06-16', 104),
(97, '2025-06-17', 56),
(98, '2025-06-19', 53),
(99, '2025-06-20', 55),
(100, '2025-06-28', 98),
(101, '2025-06-29', 172),
(102, '2025-06-30', 5),
(108, '2025-07-02', 200);

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `admin_password`) VALUES
(1, '$2y$10$kxZjtBDtMhAjYRu7VCpKPeXkOBTIM2w92AP1HudCU1gSjVP3RWqMa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lecture`
--
ALTER TABLE `lecture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `livre_id` (`livre_id`);

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `nb_page_lu`
--
ALTER TABLE `nb_page_lu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lecture`
--
ALTER TABLE `lecture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `library`
--
ALTER TABLE `library`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `nb_page_lu`
--
ALTER TABLE `nb_page_lu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`livre_id`) REFERENCES `library` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
