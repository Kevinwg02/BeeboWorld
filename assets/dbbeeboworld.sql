-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 juil. 2025 à 10:58
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
(38, 'Eugénie Dielens', 'Off Limits', 'Non', 'Non', 'Non', '9782017246541', 'Poche', 6.50, '2025-06-27', '2025-06-30', '0000-00-00', 'Oui', 'Non', 'Lorsque Diana se retrouve placée en famille d\'accueil, elle débarque, dépitée, chez les Williams, de riches new-yorkais. Les parents font tout pour la mettre à l\'aise, mais Diana ne supporte pas leur fils, Corey, un des garçons les plus populaires du lycée. Surtout depuis une certaine soirée passée ensemble quelques temps auparavant... Leurs échanges ne sont désormais que moqueries et réparties cinglantes.\r\n\r\nAux yeux de Corey, Diana représente tout ce qu\'il déteste et désire à la fois. Il voit dans cette colocation forcée une opportunité pour enfin réussir à séduire la jolie blonde... si Diana ne le repoussait pas. Corey le sait : Diana est inaccessible, hors limite. Mais maintenant qu\'ils sont obligés et vivre sous le même toit, la tentation est plus forte que jamais...', 'Une romance toute douce, sans prise de tête.\r\nProximité forcée, seconde chance, vie lycéenne. De quoi faire une très bonne romance pour cet été.\r\n\r\nDiana est un personnage en apparence sure d\'elle, mais qui cache en réalité énormément d\'incertitudes. Elle se donne les moyens de réussir, même si pour cela elle doit se tenir éloignée des autres. Et dans un lycée de riches, venir d\'une famille sans beaucoup de moyens peut créer certains préjugés.\r\n\r\nCorey est un personnage à qui tout semble réussir. Ou au moins en apparence : capitaine de l\'équipe de Lacrosse, une famille qui a les moyens, des recruteurs pour l\'université. Mais la réalité est toute autre : personne ne le connait vraiment.\r\n\r\nQuand ces deux ados se retrouvent sous le même toit, après avoir failli passer à l\'acte, les choses se compliquent. \r\nVont-ils réussir à cohabiter les quelques mois les séparant de l\'université ?\r\n\r\nSi j\'ai une chose à reprocher à ce roman, c\'est le nombre considérable de coquilles de fautes d\'accord et de mots manquants qui m\'ont coupé dans ma lecture à de trop nombreuses reprises.', 'Hachette - Ito', '275', 'Or', 'Romance contemporaine', 'https://media.hachette.fr/fit-in/780x1280/imgArticle/HACHETTELAB/2023/9782017246541-001-X.jpeg?source=web', 'Diana Cooper & Corey Williams', 'Seconde chance,  Désintoxication, Proximité forcée, Addiction, Famille d\'accueil, Lycée, Avenir', 'Bibliothèque physique'),
(39, 'Phoenix B Asher', 'Hotshot', 'Oui', 'Oui', 'Oui', '9782755679649', 'Grand Format', 17.50, '2025-04-12', '0000-00-00', '0000-00-00', '', '', 'Certains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...', 'Certains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...\r\n\r\nCertains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...', 'Hugo Romans', '371', 'Bronze', 'Romance contemporaine', 'https://cdn1.booknode.com/book_cover/5604/hotshot-5604201-264-432.webp', 'Salem O\'Connell & Jericho McKenna', 'Romance', 'Bibliothèque physique');

-- --------------------------------------------------------

--
-- Structure de la table `nb_page_lu`
--

CREATE TABLE `nb_page_lu` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `pages` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `nb_page_lu`
--
ALTER TABLE `nb_page_lu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
