-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 05 juil. 2025 à 16:54
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
CREATE DATABASE IF NOT EXISTS `dbbeeboworld` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `dbbeeboworld`;

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
  `Format` varchar(14) DEFAULT NULL,
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
  `Couverture` varchar(255) DEFAULT NULL,
  `Couple` varchar(255) DEFAULT NULL,
  `Themes` varchar(255) DEFAULT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`ID`, `Auteur`, `Titre`, `Dedicace`, `Marquepages`, `Goodies`, `ISBN`, `Format`, `Prix`, `Date_achat`, `Date_lecture`, `Relecture`, `Chronique_ecrite`, `Chronique_publiee`, `Details`, `Chronique`, `Maison_edition`, `Nombre_pages`, `Notation`, `Genre`, `Couverture`, `Couple`, `Themes`, `localisation`) VALUES
(38, 'Eugénie Dielens', 'Off Limits', 'Non', 'Non', 'Non', '9782017246541', 'Poche', 6.00, '2025-06-27', '2025-06-30', '0000-00-00', 'Oui', '', 'Lorsque Diana se retrouve placée en famille d\'accueil, elle débarque, dépitée, chez les Williams, de riches new-yorkais. Les parents font tout pour la mettre à l\'aise, mais Diana ne supporte pas leur fils, Corey, un des garçons les plus populaires du lycée. Surtout depuis une certaine soirée passée ensemble quelques temps auparavant... Leurs échanges ne sont désormais que moqueries et réparties cinglantes.\r\n\r\nAux yeux de Corey, Diana représente tout ce qu\'il déteste et désire à la fois. Il voit dans cette colocation forcée une opportunité pour enfin réussir à séduire la jolie blonde... si Diana ne le repoussait pas. Corey le sait : Diana est inaccessible, hors limite. Mais maintenant qu\'ils sont obligés et vivre sous le même toit, la tentation est plus forte que jamais...', 'Une romance toute douce, sans prise de tête.\r\nProximité forcée, seconde chance, vie lycéenne. De quoi faire une très bonne romance pour cet été.\r\n\r\nDiana est un personnage en apparence sure d\'elle, mais qui cache en réalité énormément d\'incertitudes. Elle se donne les moyens de réussir, même si pour cela elle doit se tenir éloignée des autres. Et dans un lycée de riches, venir d\'une famille sans beaucoup de moyens peut créer certains préjugés.\r\n\r\nCorey est un personnage à qui tout semble réussir. Ou au moins en apparence : capitaine de l\'équipe de Lacrosse, une famille qui a les moyens, des recruteurs pour l\'université. Mais la réalité est toute autre : personne ne le connait vraiment.\r\n\r\nQuand ces deux ados se retrouvent sous le même toit, après avoir failli passer à l\'acte, les choses se compliquent. \r\nVont-ils réussir à cohabiter les quelques mois les séparant de l\'université ?\r\n\r\nSi j\'ai une chose à reprocher à ce roman, c\'est le nombre considérable de coquilles de fautes d\'accord et de mots manquants qui m\'ont coupé dans ma lecture à de trop nombreuses reprises.', 'Hachette - Ito', '275', '', 'Romance contemporaine', 'https://media.hachette.fr/fit-in/780x1280/imgArticle/HACHETTELAB/2023/9782017246541-001-X.jpeg?source=web', 'Diana Cooper & Corey Williams', 'Seconde chance,  Désintoxication, Proximité forcée, Addiction, Famille d\'accueil, Lycée, Avenir', 'Bibliothèque physique'),
(39, 'Phoenix B Asher', 'Hotshot', 'Oui', 'Oui', 'Oui', '9782755679649', 'Grand Format', 17.50, '2025-04-12', '0000-00-00', '0000-00-00', '', '', 'Certains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...', 'Certains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...\r\n\r\nCertains feux ne s\'éteignent jamais... ils dorment dans les cendres du passé, prêts à se raviver au moindre souffle.\r\n\r\nDepuis leur enfance, Salem, Boston et Jericho forment un trio inséparable, soudé par une amitié indéfectible.\r\n\r\nA mesure qu\'ils grandissent, tout se complique. Non seulement Boston et Jericho veulent devenir pompiers de l\'extrême, mais en plus les sentiments de Salem envers Jericho évoluent, mêlant l\'amitié à quelque chose de plus fort. Jericho, lui, n\'est pas prêt à franchir cette ligne. Quand la maladie emporte sa mère, il préfère fuir plutôt que d\'affronter ses émotions, et part s\'exiler en Irlande en laissant Salem derrière lui, le cœur brisé. \r\n\r\nCinq ans plus tard, à l\'occasion du mariage de Boston, Jericho revient. Salem devra alors affronter les blessures du passé et les sentiments qu\'elle croyait oubliés...', 'Hugo Romans', '371', '', 'Romance contemporaine', 'https://cdn1.booknode.com/book_cover/5604/hotshot-5604201-264-432.webp', 'Salem O\'Connell & Jericho McKenna', 'Romance', 'Bibliothèque physique');

-- --------------------------------------------------------

--
-- Structure de la table `nano`
--

CREATE TABLE `nano` (
  `id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL,
  `chapitre` varchar(255) DEFAULT NULL,
  `date_ajout` date DEFAULT NULL,
  `nb_mots` int(11) DEFAULT NULL,
  `contenu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nano`
--

INSERT INTO `nano` (`id`, `projet_id`, `chapitre`, `date_ajout`, `nb_mots`, `contenu`) VALUES
(1, 1, 'Chapitre 1', '2025-07-05', 945, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eleifend quis sapien ut varius. Maecenas quis ante lacus. Sed elementum purus sit amet erat gravida aliquam. Aliquam efficitur orci rutrum pellentesque mattis. Sed cursus magna vitae tortor luctus tincidunt. Sed erat est, egestas vitae accumsan a, tincidunt in nisi. Mauris non risus eget sem laoreet placerat nec non libero. Integer non enim in felis lobortis facilisis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed porttitor velit risus, ultrices bibendum est gravida eget. Fusce sed auctor risus, at egestas nunc. Curabitur aliquet erat ante, non lacinia turpis dignissim ac.\r\n\r\nCras eu feugiat felis, ac mattis neque. Integer augue ipsum, dignissim at porta non, molestie ac urna. Ut dictum tincidunt orci, ac tempus justo efficitur in. Suspendisse sodales sapien tellus, at finibus risus pharetra et. Suspendisse imperdiet quam et sapien commodo, pharetra pellentesque diam faucibus. Curabitur sodales pretium eros, eu elementum massa ultricies laoreet. Donec quis ligula tristique, scelerisque libero id, consequat nibh. Sed auctor, mauris ut vehicula facilisis, neque dui placerat magna, vitae aliquet orci lacus vel est. Sed in efficitur diam, in viverra tellus. Donec augue arcu, efficitur congue pretium vitae, pretium vel nisl. Donec dapibus viverra tellus, a laoreet tortor interdum sed. Quisque ullamcorper non diam at dictum. Etiam ut rhoncus odio, ac mollis odio.\r\n\r\nSed gravida neque bibendum arcu convallis consequat. Praesent non lectus laoreet, dignissim mauris sed, dignissim justo. Duis euismod ex ut nunc consequat accumsan. Nunc imperdiet nunc nec ipsum mattis commodo pharetra eu risus. Mauris fermentum ex eu nisl consectetur tincidunt. Nunc interdum mollis vulputate. Etiam facilisis lectus vitae arcu lacinia, eu tempus mauris pulvinar. Nunc sit amet arcu arcu. Nunc sit amet felis ultricies, ultricies leo in, elementum eros. Integer sed nisl malesuada, porttitor arcu lacinia, feugiat mauris. Duis maximus neque non est vulputate aliquet. Morbi luctus molestie turpis pharetra fringilla. In congue nibh ipsum, at elementum neque posuere quis.\r\n\r\nDuis elit neque, ullamcorper ut sem a, bibendum lacinia ipsum. Morbi eu posuere purus, vitae iaculis lorem. Praesent non sollicitudin massa, at malesuada elit. Pellentesque cursus sapien lorem, ut sodales tellus lobortis efficitur. Aliquam id lectus feugiat orci egestas posuere a id sapien. Morbi a vehicula elit. Vivamus nisi risus, molestie eu magna at, vehicula mattis mi. Maecenas sollicitudin erat vel diam sagittis consectetur. Integer feugiat sapien in massa imperdiet, eu mattis est lacinia. Mauris felis eros, vehicula quis lorem eu, interdum pharetra lectus. Suspendisse ac viverra risus. Maecenas suscipit leo est, sit amet consequat quam lacinia sed. Maecenas egestas ipsum nisi, vel vehicula nisl interdum at. Nulla elementum porttitor venenatis.\r\n\r\nVivamus nec condimentum nulla. Aliquam sagittis leo interdum dui elementum molestie. Praesent efficitur in turpis sit amet ullamcorper. Mauris erat lorem, posuere in mi et, cursus convallis eros. Pellentesque ornare tortor at sodales ullamcorper. Donec convallis massa at sem molestie, sed condimentum sapien sodales. Mauris vitae dapibus lectus. Nullam quis lectus ut magna tempor finibus. Phasellus non quam a libero suscipit varius et eleifend arcu. Fusce dignissim odio auctor, porta eros consectetur, faucibus nunc.\r\n\r\nNulla at nunc lobortis, placerat dolor ac, placerat nibh. Morbi et tempus elit. Nulla odio nibh, sollicitudin sit amet purus et, iaculis gravida tortor. Integer blandit auctor magna, nec ullamcorper lorem eleifend sit amet. Donec aliquam commodo nisl et euismod. Sed libero libero, vehicula ut ipsum eu, pretium congue eros. Morbi consectetur placerat ex et mollis.\r\n\r\nAliquam in orci vitae erat fringilla ultricies eu a arcu. Nullam nec imperdiet leo. Vestibulum fringilla malesuada ante non malesuada. Nullam in interdum purus, quis fermentum libero. Aenean rhoncus libero non viverra molestie. Vivamus blandit ligula eget leo maximus, in tempus mauris ultrices. Integer velit felis, facilisis ut velit ut, pellentesque lacinia arcu. Etiam congue ante non enim luctus, vitae dapibus odio commodo. Nullam ultrices, urna vitae cursus posuere, lectus enim pharetra diam, consectetur pretium lacus ante ac dui. Aliquam felis ante, sagittis ac erat eu, cursus maximus urna. Nullam quis risus est. Nullam id porttitor urna. Nam et faucibus mi, sit amet ultrices ligula. Donec fermentum nibh vel arcu feugiat, nec vestibulum arcu condimentum. Duis mattis purus lacus, at pharetra orci volutpat nec. Aliquam iaculis imperdiet semper.\r\n\r\nDuis ac elit urna. Sed ac elit et augue placerat tristique vel nec orci. Sed ornare ornare lacus, at sagittis dolor tempor sit amet. Donec eu augue accumsan, aliquet erat vel, luctus tellus. Vestibulum eu nunc quis tortor fringilla iaculis. Etiam rutrum tincidunt vehicula. Aenean lobortis justo justo, non sagittis ligula varius quis. Vivamus faucibus tellus felis, quis sagittis quam blandit at. Quisque ultrices suscipit ipsum a dapibus. Nunc malesuada, ligula ac faucibus pretium, arcu ligula tincidunt odio, nec viverra ligula arcu eu purus. Cras feugiat, nisl id sodales congue, erat tortor elementum felis, vel tempus leo nisl sed ligula. Donec eu scelerisque magna, vitae ornare justo. Duis aliquet at nulla nec ultricies. Morbi aliquam at metus quis convallis. Etiam laoreet placerat est quis porttitor. Nunc sodales orci vel odio dapibus ornare.\r\n\r\nDonec semper lectus leo, at tempus felis commodo et. Vivamus nec ipsum vehicula, tristique lectus vitae, ornare odio. Cras vehicula tellus eu magna porta gravida. Vivamus vitae euismod nisl. Nullam ac interdum tortor, sed blandit libero. In sit amet leo sit amet lorem fermentum tincidunt. Vivamus ultrices justo ac erat ultricies varius posuere in ex. Nullam interdum nisi diam, non tincidunt leo tristique non. Aliquam erat volutpat. Etiam sed porta massa. Phasellus consequat orci sed rhoncus lobortis. Sed scelerisque lectus dictum purus iaculis condimentum. Proin ornare, ipsum at gravida venenatis, nisi lacus condimentum nulla, elementum hendrerit leo nibh ut ante. Vestibulum placerat blandit interdum. Cras at eros id est rhoncus molestie pellentesque ac augue. Nullam hendrerit nibh vitae nulla tempor feugiat.'),
(2, 1, 'Chapitre 2', '2025-07-15', 562, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eleifend quis sapien ut varius. Maecenas quis ante lacus. Sed elementum purus sit amet erat gravida aliquam. Aliquam efficitur orci rutrum pellentesque mattis. Sed cursus magna vitae tortor luctus tincidunt. Sed erat est, egestas vitae accumsan a, tincidunt in nisi. Mauris non risus eget sem laoreet placerat nec non libero. Integer non enim in felis lobortis facilisis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed porttitor velit risus, ultrices bibendum est gravida eget. Fusce sed auctor risus, at egestas nunc. Curabitur aliquet erat ante, non lacinia turpis dignissim ac.\r\n\r\nCras eu feugiat felis, ac mattis neque. Integer augue ipsum, dignissim at porta non, molestie ac urna. Ut dictum tincidunt orci, ac tempus justo efficitur in. Suspendisse sodales sapien tellus, at finibus risus pharetra et. Suspendisse imperdiet quam et sapien commodo, pharetra pellentesque diam faucibus. Curabitur sodales pretium eros, eu elementum massa ultricies laoreet. Donec quis ligula tristique, scelerisque libero id, consequat nibh. Sed auctor, mauris ut vehicula facilisis, neque dui placerat magna, vitae aliquet orci lacus vel est. Sed in efficitur diam, in viverra tellus. Donec augue arcu, efficitur congue pretium vitae, pretium vel nisl. Donec dapibus viverra tellus, a laoreet tortor interdum sed. Quisque ullamcorper non diam at dictum. Etiam ut rhoncus odio, ac mollis odio.\r\n\r\nSed gravida neque bibendum arcu convallis consequat. Praesent non lectus laoreet, dignissim mauris sed, dignissim justo. Duis euismod ex ut nunc consequat accumsan. Nunc imperdiet nunc nec ipsum mattis commodo pharetra eu risus. Mauris fermentum ex eu nisl consectetur tincidunt. Nunc interdum mollis vulputate. Etiam facilisis lectus vitae arcu lacinia, eu tempus mauris pulvinar. Nunc sit amet arcu arcu. Nunc sit amet felis ultricies, ultricies leo in, elementum eros. Integer sed nisl malesuada, porttitor arcu lacinia, feugiat mauris. Duis maximus neque non est vulputate aliquet. Morbi luctus molestie turpis pharetra fringilla. In congue nibh ipsum, at elementum neque posuere quis.\r\n\r\nDuis elit neque, ullamcorper ut sem a, bibendum lacinia ipsum. Morbi eu posuere purus, vitae iaculis lorem. Praesent non sollicitudin massa, at malesuada elit. Pellentesque cursus sapien lorem, ut sodales tellus lobortis efficitur. Aliquam id lectus feugiat orci egestas posuere a id sapien. Morbi a vehicula elit. Vivamus nisi risus, molestie eu magna at, vehicula mattis mi. Maecenas sollicitudin erat vel diam sagittis consectetur. Integer feugiat sapien in massa imperdiet, eu mattis est lacinia. Mauris felis eros, vehicula quis lorem eu, interdum pharetra lectus. Suspendisse ac viverra risus. Maecenas suscipit leo est, sit amet consequat quam lacinia sed. Maecenas egestas ipsum nisi, vel vehicula nisl interdum at. Nulla elementum porttitor venenatis.\r\n\r\nVivamus nec condimentum nulla. Aliquam sagittis leo interdum dui elementum molestie. Praesent efficitur in turpis sit amet ullamcorper. Mauris erat lorem, posuere in mi et, cursus convallis eros. Pellentesque ornare tortor at sodales ullamcorper. Donec convallis massa at sem molestie, sed condimentum sapien sodales. Mauris vitae dapibus lectus. Nullam quis lectus ut magna tempor finibus. Phasellus non quam a libero suscipit varius et eleifend arcu. Fusce dignissim odio auctor, porta eros consectetur, faucibus nunc.\r\n\r\nNulla at nunc lobortis, placerat dolor ac, placerat nibh. Morbi et tempus elit. Nulla odio nibh, sollicitudin sit amet purus et, iaculis gravida tortor. Integer blandit auctor magna, nec ullamcorper lorem eleifend sit amet. Donec aliquam commodo nisl et euismod. Sed libero libero, vehicula ut ipsum eu, pretium congue eros. Morbi consectetur placerat ex et mollis.'),
(3, 1, 'Chapitre 3', '2025-07-06', 562, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc eleifend quis sapien ut varius. Maecenas quis ante lacus. Sed elementum purus sit amet erat gravida aliquam. Aliquam efficitur orci rutrum pellentesque mattis. Sed cursus magna vitae tortor luctus tincidunt. Sed erat est, egestas vitae accumsan a, tincidunt in nisi. Mauris non risus eget sem laoreet placerat nec non libero. Integer non enim in felis lobortis facilisis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed porttitor velit risus, ultrices bibendum est gravida eget. Fusce sed auctor risus, at egestas nunc. Curabitur aliquet erat ante, non lacinia turpis dignissim ac.\r\n\r\nCras eu feugiat felis, ac mattis neque. Integer augue ipsum, dignissim at porta non, molestie ac urna. Ut dictum tincidunt orci, ac tempus justo efficitur in. Suspendisse sodales sapien tellus, at finibus risus pharetra et. Suspendisse imperdiet quam et sapien commodo, pharetra pellentesque diam faucibus. Curabitur sodales pretium eros, eu elementum massa ultricies laoreet. Donec quis ligula tristique, scelerisque libero id, consequat nibh. Sed auctor, mauris ut vehicula facilisis, neque dui placerat magna, vitae aliquet orci lacus vel est. Sed in efficitur diam, in viverra tellus. Donec augue arcu, efficitur congue pretium vitae, pretium vel nisl. Donec dapibus viverra tellus, a laoreet tortor interdum sed. Quisque ullamcorper non diam at dictum. Etiam ut rhoncus odio, ac mollis odio.\r\n\r\nSed gravida neque bibendum arcu convallis consequat. Praesent non lectus laoreet, dignissim mauris sed, dignissim justo. Duis euismod ex ut nunc consequat accumsan. Nunc imperdiet nunc nec ipsum mattis commodo pharetra eu risus. Mauris fermentum ex eu nisl consectetur tincidunt. Nunc interdum mollis vulputate. Etiam facilisis lectus vitae arcu lacinia, eu tempus mauris pulvinar. Nunc sit amet arcu arcu. Nunc sit amet felis ultricies, ultricies leo in, elementum eros. Integer sed nisl malesuada, porttitor arcu lacinia, feugiat mauris. Duis maximus neque non est vulputate aliquet. Morbi luctus molestie turpis pharetra fringilla. In congue nibh ipsum, at elementum neque posuere quis.\r\n\r\nDuis elit neque, ullamcorper ut sem a, bibendum lacinia ipsum. Morbi eu posuere purus, vitae iaculis lorem. Praesent non sollicitudin massa, at malesuada elit. Pellentesque cursus sapien lorem, ut sodales tellus lobortis efficitur. Aliquam id lectus feugiat orci egestas posuere a id sapien. Morbi a vehicula elit. Vivamus nisi risus, molestie eu magna at, vehicula mattis mi. Maecenas sollicitudin erat vel diam sagittis consectetur. Integer feugiat sapien in massa imperdiet, eu mattis est lacinia. Mauris felis eros, vehicula quis lorem eu, interdum pharetra lectus. Suspendisse ac viverra risus. Maecenas suscipit leo est, sit amet consequat quam lacinia sed. Maecenas egestas ipsum nisi, vel vehicula nisl interdum at. Nulla elementum porttitor venenatis.\r\n\r\nVivamus nec condimentum nulla. Aliquam sagittis leo interdum dui elementum molestie. Praesent efficitur in turpis sit amet ullamcorper. Mauris erat lorem, posuere in mi et, cursus convallis eros. Pellentesque ornare tortor at sodales ullamcorper. Donec convallis massa at sem molestie, sed condimentum sapien sodales. Mauris vitae dapibus lectus. Nullam quis lectus ut magna tempor finibus. Phasellus non quam a libero suscipit varius et eleifend arcu. Fusce dignissim odio auctor, porta eros consectetur, faucibus nunc.\r\n\r\nNulla at nunc lobortis, placerat dolor ac, placerat nibh. Morbi et tempus elit. Nulla odio nibh, sollicitudin sit amet purus et, iaculis gravida tortor. Integer blandit auctor magna, nec ullamcorper lorem eleifend sit amet. Donec aliquam commodo nisl et euismod. Sed libero libero, vehicula ut ipsum eu, pretium congue eros. Morbi consectetur placerat ex et mollis.'),
(4, 1, 'Chapitre 4', '2025-08-09', 3166, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vulputate sollicitudin magna, sit amet euismod lorem convallis eu. Pellentesque vel mauris magna. Praesent imperdiet a nibh vehicula facilisis. In maximus eros at lacinia congue. Maecenas ac diam quis nunc facilisis varius sit amet at tortor. Sed tempor nulla felis, non scelerisque ipsum dapibus et. Vestibulum quis ullamcorper eros. Etiam congue, nulla nec aliquam semper, urna diam consectetur turpis, imperdiet imperdiet lorem risus quis tortor. Nam pellentesque nunc nisi, ac tempor sem porttitor et. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras lacinia, turpis nec cursus pharetra, ipsum felis aliquet lacus, quis posuere est dolor sit amet sapien.\r\n\r\nMauris id lobortis purus, at aliquam tortor. Nunc sit amet libero commodo, sagittis magna et, aliquet orci. Maecenas porttitor sollicitudin nisi nec consequat. Praesent vestibulum urna vitae nulla ullamcorper, et efficitur sem hendrerit. Morbi dignissim, velit vitae placerat malesuada, massa arcu eleifend augue, vel interdum nulla mauris sollicitudin odio. Nunc sed suscipit magna. Sed lacinia leo a leo tincidunt accumsan. Vestibulum eget tellus volutpat, venenatis odio sed, maximus felis. Nam a interdum eros, quis dapibus libero. Maecenas egestas odio ut urna fringilla tristique. Praesent placerat elementum nisi, quis euismod purus semper a. Nam mollis mi sed pulvinar imperdiet. Donec vitae feugiat ante. Pellentesque rhoncus lectus sit amet magna sodales efficitur.\r\n\r\nIn ut sagittis lacus. Aliquam elementum sapien orci, vel vulputate dui auctor sit amet. Nunc viverra quam metus. Vivamus feugiat ac eros non mattis. Ut non auctor metus. Proin semper ornare lectus, at gravida diam vulputate sit amet. Donec vel mollis erat. Curabitur ut purus velit. Vestibulum mollis consectetur dolor eu placerat. Ut commodo augue in mollis venenatis. Nam id libero sed libero tincidunt feugiat ac nec enim. In tincidunt sapien in ipsum blandit, elementum pellentesque neque pulvinar.\r\n\r\nFusce vehicula orci vitae ipsum iaculis, sed mattis magna fringilla. Duis tristique quam vitae est condimentum maximus. Nam eget ex ac leo aliquam maximus. Quisque sed dui ornare, ultrices enim et, aliquam orci. Donec hendrerit accumsan cursus. Proin iaculis neque eu enim sodales blandit. Aliquam vel massa accumsan ante molestie posuere ut a libero. Donec commodo tellus risus, non tincidunt est consequat in. Praesent consectetur rhoncus pulvinar. Sed euismod ultrices volutpat. Mauris suscipit efficitur metus, sed ultricies enim luctus vitae. Fusce suscipit, urna ac molestie tristique, quam sem volutpat velit, consectetur vulputate odio diam a est.\r\n\r\nNulla ac arcu mi. Phasellus quis efficitur sapien. Sed fermentum sapien quis nisi vestibulum fringilla. Phasellus arcu ex, pharetra eget congue nec, vulputate in mauris. In metus massa, molestie nec massa eu, faucibus laoreet enim. Sed in rutrum mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor nulla at augue pulvinar porta eget et felis. Nullam vel tristique nisi. Quisque convallis nulla eu mattis ultrices. Mauris non tellus a erat dictum ultricies. Vivamus varius leo enim, elementum dignissim ante euismod a. Cras eu est nibh.\r\n\r\nNullam tincidunt bibendum est ut malesuada. Cras ultricies ex sit amet lacus ullamcorper rutrum. Aenean eu semper urna. Pellentesque velit ligula, pellentesque auctor ipsum vel, interdum auctor diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac arcu ipsum. Proin sollicitudin id orci nec mattis. Aenean metus neque, laoreet quis urna nec, tincidunt pulvinar turpis. Donec felis ante, interdum sit amet egestas sed, posuere id mi. Maecenas accumsan enim massa, ut efficitur nisi vehicula vel. Donec ac ante lectus. Praesent facilisis, nunc non venenatis venenatis, mauris sapien blandit nunc, vitae congue dolor dui eu quam. Duis ornare nisi ut ex fringilla, eu cursus lacus volutpat. Cras quis imperdiet libero.\r\n\r\nDuis tempor dui in eros congue, sit amet accumsan nunc tincidunt. Mauris iaculis leo quam, ac dapibus ipsum venenatis ut. Vivamus purus arcu, tempor scelerisque sodales sed, fermentum at est. Duis finibus erat ut nunc malesuada, sit amet convallis augue dapibus. Pellentesque vel tempor metus. In dui arcu, pharetra ac est quis, fermentum congue velit. Suspendisse finibus purus ex, nec rutrum nulla mollis ac. Proin diam orci, faucibus vitae finibus eget, lacinia vitae eros. Mauris aliquam mauris eu dapibus gravida. In suscipit leo odio, eget dignissim metus scelerisque sit amet. Pellentesque pharetra lectus eu tristique consectetur. Nullam non ullamcorper lectus. Donec eu pharetra libero. Maecenas congue magna viverra lacinia malesuada.\r\n\r\nCras faucibus rhoncus enim vel scelerisque. Morbi ac tempor tellus. Suspendisse potenti. Ut iaculis tempus nisl at tincidunt. Pellentesque vitae lectus orci. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In nibh est, fermentum posuere nulla aliquam, sagittis molestie sem. Donec sodales dui sed neque cursus facilisis. Integer iaculis metus lacus, quis ornare erat maximus vel. Cras at ex id lacus lacinia tempor sit amet quis tortor.\r\n\r\nNullam nulla purus, pretium id cursus non, gravida ac diam. Nam luctus, ante vel dictum consequat, turpis nulla lacinia urna, ut fringilla tellus dolor vitae quam. Maecenas hendrerit maximus euismod. Donec volutpat leo a dignissim ultricies. Vivamus in facilisis odio, sed vulputate erat. Sed vitae turpis iaculis, ornare sapien et, sollicitudin ex. Maecenas mollis tortor non ipsum porta, non tempor massa ultricies. Donec vehicula eleifend dolor, vel imperdiet mi vehicula ac. Donec ultrices urna quis lacinia cursus. Quisque ut metus blandit, aliquam dolor in, bibendum mauris. Suspendisse iaculis orci vel diam ornare, sit amet mattis eros maximus. Praesent congue neque non ipsum tincidunt, non porttitor ex tincidunt. Fusce sollicitudin lectus in augue porttitor, ac tincidunt lacus finibus. Mauris ornare efficitur nulla, sit amet finibus dui sollicitudin ut. Nam id est enim.\r\n\r\nInteger ultrices elit sed ante rhoncus, ut aliquam eros vulputate. Nulla rutrum felis in tortor ornare pretium. Donec purus neque, suscipit vitae egestas sed, dictum in diam. Sed ac magna vitae lectus hendrerit lacinia a quis lectus. Cras fermentum semper leo quis blandit. Sed finibus aliquam mauris, sit amet bibendum sapien faucibus vitae. Morbi laoreet sagittis libero, et tempus ex blandit ut. Sed sed pretium lorem. Phasellus vulputate diam et ipsum viverra suscipit. Sed ac cursus lorem. Proin rutrum mollis vehicula. In bibendum pharetra odio pharetra dapibus.\r\n\r\nDuis volutpat accumsan egestas. Etiam pulvinar, purus in feugiat fringilla, metus ante tristique neque, ut vehicula diam dui ac dolor. Duis arcu tortor, laoreet mattis ex et, consectetur molestie lorem. Vestibulum nec lectus non mi tristique tristique. Mauris bibendum egestas malesuada. Praesent tristique turpis libero, at vulputate purus euismod at. Morbi quis odio blandit, consequat nisl ac, sollicitudin quam. Etiam tincidunt eleifend mollis. Morbi volutpat nec elit nec ultricies. Morbi vehicula, est eu luctus aliquam, dolor mauris consequat dui, a iaculis dui leo in nisi. Nunc a justo neque. Vestibulum laoreet tincidunt molestie. Nam ornare nunc a purus gravida aliquet.\r\n\r\nProin maximus porttitor purus, ut ultricies dolor. Fusce aliquam aliquet erat nec scelerisque. Duis pharetra nec lorem id ultricies. Nunc vel nibh id leo elementum interdum. Cras tincidunt dui ante, non dictum nunc scelerisque nec. Ut nec gravida erat. Aliquam bibendum magna a ipsum mollis, id elementum augue pulvinar. Suspendisse volutpat congue euismod. Etiam pellentesque faucibus porta. Aenean sit amet tortor purus. Praesent vitae est eleifend, malesuada nulla non, vehicula elit. Suspendisse facilisis tellus id eros fermentum dictum. Donec at porttitor justo, quis malesuada ex.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at imperdiet ligula. Curabitur eu pretium mi. Praesent scelerisque vehicula dui et imperdiet. Praesent sed tortor egestas, egestas sem in, ultricies velit. Fusce consequat mollis tortor, ac venenatis libero condimentum ac. Etiam gravida dapibus varius. Fusce faucibus consequat venenatis. Nunc ante odio, imperdiet quis lorem sed, tincidunt vestibulum nunc. Donec in laoreet ante, eget hendrerit ante.\r\n\r\nMauris non lorem ipsum. Vestibulum mi risus, efficitur eget sagittis quis, suscipit ac libero. Integer in erat vitae ligula commodo vestibulum vitae vitae libero. Cras ac elit vitae mauris tincidunt dignissim. Phasellus facilisis, enim eget bibendum condimentum, quam dolor auctor ex, nec consectetur augue metus id purus. Phasellus nec erat et quam lobortis porttitor vel non dolor. Nulla facilisi. Aliquam elementum diam nibh, sed imperdiet nibh commodo ut. Suspendisse sit amet justo quis magna facilisis aliquet. Suspendisse eget purus tristique tellus sodales vehicula vitae eget quam. Integer id purus mi. Mauris semper, metus vitae maximus mollis, velit elit pretium diam, porta dignissim turpis nisi nec mauris. Aliquam felis lacus, vestibulum ut fringilla non, ullamcorper eget risus. Vivamus nec diam scelerisque, viverra justo eu, fermentum sem. Sed porta ex nec euismod tristique.\r\n\r\nSed rutrum mauris eu mauris ultrices, quis rutrum dui rutrum. Curabitur at fermentum arcu, quis dictum dolor. Cras convallis nisl nec risus scelerisque sollicitudin. Proin ut neque malesuada, volutpat eros id, varius enim. Curabitur sed ipsum urna. Aenean sed aliquet massa. Praesent ut neque est. Sed interdum augue quam, non placerat nunc ultrices id. Aenean sed nisi tristique, ultricies mauris a, suscipit dui. Phasellus vitae suscipit risus. Nunc nec nulla semper, dignissim libero eu, vestibulum urna. Integer volutpat purus eu lectus tincidunt consectetur. Proin a lectus non urna aliquet mattis. Sed elementum aliquam tortor, nec congue nunc ultrices eu. Phasellus ornare rhoncus tortor, vitae vehicula neque aliquam sit amet.\r\n\r\nIn hac habitasse platea dictumst. Nullam posuere ornare semper. Phasellus pulvinar, urna eget mollis venenatis, mauris eros pretium ex, eget blandit quam erat ac libero. Etiam vel consectetur elit, et fermentum tortor. Integer venenatis purus vitae sapien sagittis, ac hendrerit quam consequat. Aenean lacus lacus, finibus vel leo eu, molestie dignissim dui. Maecenas vulputate velit vitae auctor tristique. Praesent in vehicula lectus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris mi libero, feugiat quis viverra quis, vestibulum congue odio. Vestibulum convallis sagittis felis eget mollis. Curabitur ac convallis neque, in eleifend lorem. Nam aliquet nibh porta, malesuada justo quis, porta tellus. Nullam odio quam, congue vel aliquam sed, laoreet sed ex. Pellentesque at massa id orci elementum bibendum maximus nec lectus. Aenean viverra scelerisque ipsum.\r\n\r\nSed feugiat metus non maximus porta. Nullam egestas nisl elit, accumsan auctor metus posuere quis. Donec pharetra in urna at aliquet. Vestibulum feugiat arcu a tortor efficitur, tincidunt egestas tellus malesuada. Sed rutrum porttitor quam, in sollicitudin sapien ultrices sit amet. Morbi nunc ipsum, consequat vel convallis eu, lacinia nec libero. Donec vel est felis. Mauris vitae fermentum ligula, quis tempus velit. Pellentesque a tincidunt sem. Fusce convallis leo vel augue lacinia dapibus. Pellentesque in orci at ante varius lacinia.\r\n\r\nIn ac nulla eget diam varius vehicula non id lorem. Donec at consequat turpis. Sed ac tortor ac diam accumsan ultricies vitae et magna. Pellentesque sollicitudin viverra nibh, id aliquam lorem auctor non. Vivamus at leo aliquam lacus feugiat imperdiet vitae quis massa. Aliquam ut elementum leo. Maecenas sit amet turpis purus. Quisque egestas enim non arcu egestas semper. Curabitur aliquet massa sit amet blandit hendrerit. Suspendisse vel justo nibh. Aenean fringilla ligula dui, vel fermentum eros venenatis in. Quisque ac purus nec risus varius eleifend a nec felis. Aenean viverra enim hendrerit turpis cursus, nec molestie diam lobortis. Etiam interdum, est non eleifend sagittis, odio dolor gravida ex, tempor eleifend neque diam eget tortor. Fusce pellentesque at augue in viverra.\r\n\r\nAliquam purus magna, dignissim quis sapien quis, bibendum imperdiet lorem. Vestibulum commodo efficitur felis, ac scelerisque nisl sodales vel. Sed tempus a purus ac hendrerit. Donec dapibus varius libero, eu fringilla dui mollis a. Mauris hendrerit ac mi rutrum eleifend. Nunc at ligula fringilla lorem ultrices malesuada. Donec sed leo lorem. Vivamus et libero vehicula, ullamcorper ligula nec, egestas tellus. Etiam molestie, justo eget elementum fringilla, felis risus scelerisque urna, sit amet scelerisque ligula turpis vel ipsum.\r\n\r\nAliquam ut elit placerat, molestie magna id, imperdiet sem. Suspendisse ac mauris vestibulum, condimentum neque sed, laoreet dui. Donec pellentesque, felis porta tempor semper, est turpis dignissim felis, quis dapibus mauris risus vitae lacus. In in augue leo. Phasellus egestas ultricies justo. Donec tincidunt erat eros, sit amet porta libero ultrices at. Nunc suscipit semper libero sed suscipit.\r\n\r\nVestibulum tincidunt velit a libero molestie gravida. Phasellus ac enim purus. Etiam pulvinar, nibh sit amet ornare efficitur, nibh nibh fringilla neque, vel feugiat quam ex ut est. Praesent turpis nisi, tincidunt quis ultricies ac, condimentum nec nulla. Praesent bibendum mi eu imperdiet euismod. Praesent a ligula ultrices, mollis justo at, accumsan massa. Nam sagittis elit et ipsum pellentesque, nec ornare diam consectetur. Mauris feugiat luctus purus.\r\n\r\nUt dictum urna et vestibulum volutpat. Praesent congue molestie fermentum. Nam accumsan imperdiet interdum. Nullam odio diam, posuere euismod elementum at, malesuada non nibh. Nam egestas nisi sapien, et finibus sem molestie id. Nullam a nulla justo. Quisque at consectetur turpis. Nunc lectus tortor, scelerisque sed diam at, tristique viverra odio. Integer elementum nisi mauris. Praesent auctor nunc id ligula faucibus tempus. Phasellus vitae augue vitae purus tempor ullamcorper eu et augue. Etiam elementum, dui quis efficitur consequat, tellus odio ultrices tellus, vel rhoncus metus augue eget massa. Aenean consectetur felis nec convallis rutrum.\r\n\r\nOrci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras vel quam euismod, imperdiet neque consequat, volutpat eros. Maecenas scelerisque urna dui, id sodales urna maximus id. Proin orci dolor, consequat non eros et, dictum efficitur libero. Donec egestas felis et faucibus hendrerit. Aenean in tellus eget tellus lacinia rutrum. Sed ultrices magna turpis, at rutrum tortor dapibus non. Ut interdum sollicitudin egestas. Nam pellentesque ullamcorper sapien quis viverra. Quisque hendrerit magna vitae purus finibus tempus. Nam ut justo vel enim mattis dapibus a ac orci. Vivamus varius fringilla tellus, id mollis augue convallis sed. Fusce vel aliquam metus. Donec tempus enim in elit lobortis, sollicitudin facilisis enim cursus. Cras ac leo dui. Aliquam porta lacus quis neque laoreet facilisis.\r\n\r\nSuspendisse vitae blandit orci. Phasellus fringilla iaculis eros non fermentum. Morbi imperdiet viverra scelerisque. Ut et ex nec urna tincidunt efficitur. Proin dui nulla, vestibulum vitae convallis a, sollicitudin sed nisl. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi congue non tortor quis efficitur. Etiam at metus odio. Pellentesque vestibulum tristique nibh, nec finibus quam bibendum at.\r\n\r\nDonec eu nulla non augue tempor pellentesque a eget velit. Morbi at lacus bibendum, hendrerit nulla eu, dignissim sem. Nam ac eros ac massa euismod rhoncus. Praesent ac faucibus ipsum. Etiam accumsan posuere nisi, vel tincidunt lorem sagittis non. Mauris sit amet purus diam. In hac habitasse platea dictumst. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vel enim lacinia, tincidunt massa a, tincidunt metus. Pellentesque sollicitudin lacus id urna suscipit hendrerit.\r\n\r\nAenean sit amet magna quam. Etiam sagittis pulvinar felis, ut consequat risus tincidunt eu. Nunc et nibh ultrices dolor laoreet tempus. Vivamus aliquet nisl id tortor luctus tincidunt. Vestibulum convallis magna sed facilisis luctus. Vivamus sit amet condimentum nisi, eu feugiat mi. Vivamus ac lorem at diam aliquam luctus.\r\n\r\nAliquam sit amet mollis nulla. Donec placerat justo ipsum, sit amet tempor lacus egestas sed. Nunc ullamcorper sit amet ligula id consequat. Vestibulum at augue ut diam molestie blandit sed vel libero. Vivamus non lacus nec dui volutpat laoreet id pellentesque neque. Suspendisse lectus leo, pulvinar nec molestie a, hendrerit a quam. Phasellus est purus, mollis a ultrices non, sollicitudin eget massa. Fusce quis lorem lorem. Nam non sem lectus. In accumsan magna nulla, id vehicula ex aliquet at. Nullam vitae facilisis lacus, in pharetra nulla. Duis enim ante, sollicitudin at dignissim ut, rhoncus in dolor. Vivamus est leo, euismod facilisis volutpat non, consequat eget dui.\r\n\r\nAliquam scelerisque augue ante, sit amet iaculis enim interdum in. Suspendisse commodo tortor vitae nulla posuere, eu fermentum nulla dignissim. Sed tincidunt nisl eget eleifend malesuada. Nam fringilla mauris vel sodales convallis. Integer vel nunc elementum, dapibus arcu non, lobortis nulla. Fusce euismod orci sit amet nulla tempor sagittis. Cras blandit dolor eu tellus fringilla sagittis. Vestibulum vitae volutpat augue. Curabitur dignissim quam id sem convallis feugiat. Etiam rutrum lacus eget metus aliquam molestie. Nunc sit amet dapibus quam.\r\n\r\nPellentesque pulvinar tincidunt justo quis bibendum. Suspendisse sit amet ullamcorper diam, euismod auctor nulla. Etiam tincidunt fermentum turpis, nec aliquet lectus facilisis sed. Maecenas vel convallis nunc. Aliquam nec ligula massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nibh massa, rutrum et diam a, ullamcorper volutpat turpis. Integer interdum enim luctus lacinia lobortis. Curabitur vel maximus enim. Pellentesque rutrum enim et rutrum pulvinar. Maecenas sit amet consectetur enim.\r\n\r\nSuspendisse iaculis ornare tortor et dapibus. Fusce sit amet cursus lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer et auctor risus, non pretium purus. Suspendisse odio elit, scelerisque sed odio sed, pretium posuere justo. Fusce tincidunt mi turpis, nec consequat velit condimentum quis. Curabitur magna erat, pellentesque eget nunc eu, tempor venenatis nisl. Curabitur a enim hendrerit, rhoncus neque id, facilisis sem. Aliquam malesuada odio tellus, id hendrerit massa finibus vitae. Integer elementum accumsan lacus nec aliquet. Donec tincidunt erat vel vulputate vestibulum. Phasellus sodales lorem sed neque venenatis, a porttitor nisi consequat. Suspendisse sed massa sit amet tortor venenatis porttitor quis non nulla. In sit amet libero eleifend, consectetur nisi nec, convallis leo. Nunc bibendum lorem non mauris placerat, vitae dictum mi fringilla. Aliquam sed diam massa.\r\n\r\nProin ipsum turpis, fringilla ut rhoncus ut, efficitur vitae nisi. Donec iaculis tincidunt nibh, bibendum maximus felis ullamcorper vitae. Fusce porta est pulvinar tellus imperdiet, a finibus erat pulvinar. Nullam ligula enim, vulputate quis consectetur a, egestas vel purus. Aenean magna sapien, gravida eu nunc ut, finibus vulputate lacus. Cras suscipit nisl velit, non ultrices mauris lacinia convallis. Integer aliquet ornare dui, vel vulputate velit imperdiet ac. Donec porttitor justo dolor, et blandit neque sodales tristique. Sed tristique pretium massa, commodo sagittis est convallis quis. Morbi ac libero in nibh vulputate sollicitudin ac quis enim. Sed et sollicitudin tellus.\r\n\r\nInteger non turpis varius, commodo felis vitae, lobortis orci. Proin felis nisl, viverra vitae metus vitae, pellentesque faucibus eros. Vivamus nec hendrerit turpis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eu gravida leo, eu consequat lacus. Sed eu gravida eros. Aliquam erat volutpat. Cras vitae tortor vel ligula laoreet pharetra. Quisque vitae mauris erat. Nulla posuere, ante ut faucibus efficitur, felis diam blandit felis, ac semper sem odio ut risus.\r\n\r\nMaecenas consectetur nunc vel imperdiet rutrum. Cras mollis urna sit amet dolor hendrerit sollicitudin. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sit amet bibendum augue. Integer efficitur at ligula non tempor. Pellentesque ac sem nec leo porta imperdiet id eu tortor. Etiam finibus a nibh a fringilla. Cras pulvinar, elit at maximus egestas, nisi nulla bibendum massa, non vestibulum odio neque a turpis. Aenean gravida, lorem in suscipit dapibus, velit magna facilisis nulla, et pellentesque leo est eu enim. Fusce id efficitur nunc.\r\n\r\nAliquam faucibus leo a leo feugiat, ut commodo felis eleifend. Cras lacus magna, commodo quis leo et, interdum cursus quam. Nunc pharetra viverra sagittis. Sed mollis, nisi ut viverra volutpat, tellus ligula facilisis mi, vitae dignissim ex leo a massa. Fusce varius non tortor vitae mattis. In lobortis sodales scelerisque. Nullam sem turpis, rhoncus nec felis eu, tristique tincidunt nulla. Donec dapibus magna quis dolor facilisis elementum. Donec in ultricies neque. Praesent ut erat in massa finibus suscipit. Integer vehicula sagittis ipsum, quis aliquet erat convallis nec.\r\n\r\nQuisque interdum velit et volutpat euismod. Ut non viverra sem, eu faucibus arcu. Nulla iaculis bla'),
(5, 2, 'Chapitre 1: L\'armure', '2025-07-05', 150, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit labore architecto consectetur, iure ut vero, quia enim dolor similique dolorum, voluptates eius mollitia dolore saepe. Odio quia reprehenderit, fugit sequi quo, illum totam id earum, temporibus vel magni doloribus ipsum hic sapiente? Minus esse architecto autem maxime et hic tempore? Iste dolores atque rerum perspiciatis animi quos quisquam laborum itaque, placeat dolor explicabo suscipit. Placeat sunt ducimus eaque ipsum similique debitis voluptates, illo quaerat facere aliquam nulla rerum asperiores consequuntur officiis hic, libero soluta at quasi fugit praesentium possimus sapiente commodi. Magni laborum, quisquam perspiciatis odio eum beatae repellat expedita dolorum vitae voluptate optio iusto provident eos laboriosam cumque. Explicabo tempore eaque exercitationem ad ex aut iusto iste rem sed, deleniti minus cupiditate ratione assumenda eligendi at praesentium dolorem voluptatibus amet enim dolores nulla ipsa quam nobis excepturi? Harum eum quod voluptatum natus totam quo, sunt optio! Sed, minima deleniti!'),
(6, 2, 'Chapitre 2: La peluche', '2025-06-29', 300, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit labore architecto consectetur, iure ut vero, quia enim dolor similique dolorum, voluptates eius mollitia dolore saepe. Odio quia reprehenderit, fugit sequi quo, illum totam id earum, temporibus vel magni doloribus ipsum hic sapiente? Minus esse architecto autem maxime et hic tempore? Iste dolores atque rerum perspiciatis animi quos quisquam laborum itaque, placeat dolor explicabo suscipit. Placeat sunt ducimus eaque ipsum similique debitis voluptates, illo quaerat facere aliquam nulla rerum asperiores consequuntur officiis hic, libero soluta at quasi fugit praesentium possimus sapiente commodi. Magni laborum, quisquam perspiciatis odio eum beatae repellat expedita dolorum vitae voluptate optio iusto provident eos laboriosam cumque. Explicabo tempore eaque exercitationem ad ex aut iusto iste rem sed, deleniti minus cupiditate ratione assumenda eligendi at praesentium dolorem voluptatibus amet enim dolores nulla ipsa quam nobis excepturi? Harum eum quod voluptatum natus totam quo, sunt optio! Sed, minima deleniti!vLorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit labore architecto consectetur, iure ut vero, quia enim dolor similique dolorum, voluptates eius mollitia dolore saepe. Odio quia reprehenderit, fugit sequi quo, illum totam id earum, temporibus vel magni doloribus ipsum hic sapiente? Minus esse architecto autem maxime et hic tempore? Iste dolores atque rerum perspiciatis animi quos quisquam laborum itaque, placeat dolor explicabo suscipit. Placeat sunt ducimus eaque ipsum similique debitis voluptates, illo quaerat facere aliquam nulla rerum asperiores consequuntur officiis hic, libero soluta at quasi fugit praesentium possimus sapiente commodi. Magni laborum, quisquam perspiciatis odio eum beatae repellat expedita dolorum vitae voluptate optio iusto provident eos laboriosam cumque. Explicabo tempore eaque exercitationem ad ex aut iusto iste rem sed, deleniti minus cupiditate ratione assumenda eligendi at praesentium dolorem voluptatibus amet enim dolores nulla ipsa quam nobis excepturi? Harum eum quod voluptatum natus totam quo, sunt optio! Sed, minima deleniti!');

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
(1, '2025-06-28', 185),
(2, '2024-06-28', 135),
(3, '2025-02-27', 250),
(4, '2025-03-26', 150),
(5, '2025-05-25', 145),
(6, '2025-06-24', 160),
(7, '2025-06-17', 50);

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `couverture` varchar(255) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `etat` enum('En cours','Terminé','En pause') DEFAULT 'En cours',
  `resume` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `nom`, `couverture`, `date_debut`, `date_fin`, `etat`, `resume`) VALUES
(1, 'La lune', 'https://d1csarkz8obe9u.cloudfront.net/posterpreviews/full-moon-mixtape-album-cover-art-template-design-94f890e2ba980dc7fd5f729a85f0694c_screen.jpg?ts=1590893300', '2025-07-01', NULL, 'En cours', '    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit labore architecto consectetur, iure ut vero, quia enim dolor similique dolorum, voluptates eius mollitia dolore saepe. Odio quia reprehenderit, fugit sequi quo, illum totam id earum, temporibus vel magni doloribus ipsum hic sapiente? Minus esse architecto autem maxime et hic tempore? Iste dolores atque rerum perspiciatis animi quos quisquam laborum itaque, placeat dolor explicabo suscipit. Placeat sunt ducimus eaque ipsum similique debitis voluptates, illo quaerat facere aliquam nulla rerum asperiores consequuntur officiis hic, libero soluta at quasi fugit praesentium possimus sapiente commodi. Magni laborum, quisquam perspiciatis odio eum beatae repellat expedita dolorum vitae voluptate optio iusto provident eos laboriosam cumque. Explicabo tempore eaque exercitationem ad ex aut iusto iste rem sed, deleniti minus cupiditate ratione assumenda eligendi at praesentium dolorem voluptatibus amet enim dolores nulla ipsa quam nobis excepturi? Harum eum quod voluptatum natus totam quo, sunt optio! Sed, minima deleniti!'),
(2, 'The advanture of beebo', '../assets/covers/TheAdventureOfBeebo.jpg', '2023-08-05', NULL, 'En cours', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit labore architecto consectetur, iure ut vero, quia enim dolor similique dolorum, voluptates eius mollitia dolore saepe. Odio quia reprehenderit, fugit sequi quo, illum totam id earum, temporibus vel magni doloribus ipsum hic sapiente? Minus esse architecto autem maxime et hic tempore? Iste dolores atque rerum perspiciatis animi quos quisquam laborum itaque, placeat dolor explicabo suscipit. Placeat sunt ducimus eaque ipsum similique debitis voluptates, illo quaerat facere aliquam nulla rerum asperiores consequuntur officiis hic, libero soluta at quasi fugit praesentium possimus sapiente commodi. Magni laborum, quisquam perspiciatis odio eum beatae repellat expedita dolorum vitae voluptate optio iusto provident eos laboriosam cumque. Explicabo tempore eaque exercitationem ad ex aut iusto iste rem sed, deleniti minus cupiditate ratione assumenda eligendi at praesentium dolorem voluptatibus amet enim dolores nulla ipsa quam nobis excepturi? Harum eum quod voluptatum natus totam quo, sunt optio! Sed, minima deleniti!');

-- --------------------------------------------------------

--
-- Structure de la table `projets_themes`
--

CREATE TABLE `projets_themes` (
  `projet_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Structure de la table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Index pour la table `nano`
--
ALTER TABLE `nano`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projet_id` (`projet_id`);

--
-- Index pour la table `nb_page_lu`
--
ALTER TABLE `nb_page_lu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `projets_themes`
--
ALTER TABLE `projets_themes`
  ADD PRIMARY KEY (`projet_id`,`theme_id`),
  ADD KEY `theme_id` (`theme_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `nano`
--
ALTER TABLE `nano`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `nb_page_lu`
--
ALTER TABLE `nb_page_lu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lecture`
--
ALTER TABLE `lecture`
  ADD CONSTRAINT `lecture_ibfk_1` FOREIGN KEY (`livre_id`) REFERENCES `library` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `nano`
--
ALTER TABLE `nano`
  ADD CONSTRAINT `nano_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projets_themes`
--
ALTER TABLE `projets_themes`
  ADD CONSTRAINT `projets_themes_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projets_themes_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE CASCADE;
--
-- Base de données : `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Structure de la table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Structure de la table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Structure de la table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Structure de la table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Structure de la table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Structure de la table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Structure de la table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Déchargement des données de la table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"dbbeeboworld\",\"table\":\"books\"},{\"db\":\"DbBeeboWorld\",\"table\":\"books\"}]');

-- --------------------------------------------------------

--
-- Structure de la table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Structure de la table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Structure de la table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Structure de la table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Déchargement des données de la table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-06-05 17:27:44', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"fr\",\"ThemeDefault\":\"metro\"}');

-- --------------------------------------------------------

--
-- Structure de la table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Structure de la table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Index pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Index pour la table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Index pour la table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Index pour la table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Index pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Index pour la table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Index pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Index pour la table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Index pour la table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Index pour la table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Index pour la table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Index pour la table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Index pour la table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Index pour la table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de données : `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
