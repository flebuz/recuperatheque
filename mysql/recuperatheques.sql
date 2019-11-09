-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 09 nov. 2019 à 12:38
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `recuperatheques`
--

-- --------------------------------------------------------

--
-- Structure de la table `bag`
--

DROP TABLE IF EXISTS `bag`;
CREATE TABLE IF NOT EXISTS `bag` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `dimensions` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `tags` text NOT NULL,
  `remarques` text NOT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bag`
--

INSERT INTO `bag` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(16, 2, 7, 1, '4m x 2m', 2, 'grille,flexible', '', '2019-09-28 00:00:00', 0.1, 0, ''),
(18, 8, 49, 1, '', 3, 'rouge, fil, nylon, cachemire', '', '2019-09-29 00:00:00', 0.2, 0, ''),
(21, 8, 42, 1, '', 1, 'jute, toile, decoupe, effiloché', '', '2019-09-29 10:17:40', 0.5, 0, ''),
(20, 8, 49, 1, '', 3, 'turquoise, fil, nylon, bobine', '', '2019-09-29 09:43:56', 1, 0, ''),
(22, 3, 14, 1, '2m', 3, 'long, carton, craft', '', '2019-11-01 19:40:24', 1, 1.77, 'Récupérathèque'),
(23, 3, 110, 1, '', 3, 'couleur, vraiment, beaucoup, ripcolor, vert, rouge, bleu, mauve, violet, brun, orange, echantillon', '', '2019-11-03 13:50:44', 1, 2.2, '');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID`, `nom`, `score`) VALUES
(1, 'Bois', 18),
(2, 'Métal', 17),
(3, 'Papeterie', 18),
(4, 'Dessin et Écriture', 15),
(5, 'Mesure et Tracé', 14),
(6, 'Assemblage', 13),
(7, 'Découpe', 12),
(8, 'Textile', 11),
(9, 'Minéraux', 10),
(10, 'Céramique', 9),
(11, 'Verre', 8),
(12, 'Plastique', 7),
(13, 'Peinture', 6),
(14, 'Outils', 5),
(15, 'Quincaillerie', 4),
(16, 'Électronique', 3),
(17, 'Mobilier', 2),
(18, 'Insolite', 1);

-- --------------------------------------------------------

--
-- Structure de la table `gilbards`
--

DROP TABLE IF EXISTS `gilbards`;
CREATE TABLE IF NOT EXISTS `gilbards` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `dimensions` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `tags` text NOT NULL,
  `remarques` text NOT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gilbards`
--

INSERT INTO `gilbards` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(1, 12, 119, 3200, '4cm x 4cm', 3, 'attache, flexible, flex, joint', 'Lot. Fonction originale: équerre pour carton. A partir de 200 pièces.', '2019-08-06 00:00:00', 0, 0, 'Rue Abbé Cuylits 44, 1070 Anderlecht'),
(2, 1, 1, 1600, '50.8cm x 2cm x 2cm', 4, 'sapin, baguette, tasseau, rabotté', 'Lot à prendre dans son entièretée', '2019-08-06 00:00:00', 0, 0, ''),
(3, 18, 125, 1, '10m', 3, 'lance, incendie, tuyau, rouge, eau', 'Lance à incendie sur support raccordée à adaptateur. 10m de longueur.', '2019-08-07 00:00:00', 0, 0, ''),
(4, 17, 124, 1, '38cm x 25cm', 2, 'coussin, bureau, chaise, bleu, tissus', 'Ancien dossier de chaise de bureau.', '2019-08-08 00:00:00', 0, 0, ''),
(5, 15, 85, 20, '5mm x 250mm', 3, 'cheville, plastique, blanc', '', '2019-02-14 00:00:00', 0, 0, ''),
(6, 12, 67, 1, '50.3cm x 19.5xm', 2, 'rayé, transparent, translucide, reconditionnable', '', '2019-04-02 00:00:00', 0, 0, ''),
(7, 18, 125, 10, '20cm', 3, 'blanc, rouge, orange, cire, feu', 'Lot de 10 bougies de tailles et couleurs différentes.', '2019-05-23 00:00:00', 0, 0, ''),
(8, 1, 1, 3, '181.5cm x 4.5cm x 2.3cm', 3, 'gîte, poutre, traité, vert, sapin', 'Tranches non traitées.', '2019-06-06 00:00:00', 0, 0, ''),
(9, 4, 17, 25, '', 3, 'enfant, couleur, coloriage, gallery ', 'Lot de 25.', '2019-06-17 00:00:00', 0, 0, ''),
(10, 3, 13, 1, '10.5cm x 14cm', 3, 'aurora, carnet, copie', 'Carnet autocopiant de 50 pages détachables.', '2019-06-17 00:00:00', 0, 0, ''),
(11, 18, 125, 1, '35cm x 35cm', 3, 'feu, gaz, plat, chauffe, alimentation', 'Chauffe plat au gaz.', '2019-07-30 00:00:00', 0, 0, 'Rue Abbé Cuylits 44, 1070 Anderlecht'),
(12, 16, 94, 7, '1m', 3, 'electrique, alimentation, plastique', '', '2019-03-22 00:00:00', 0, 0, ''),
(13, 15, 86, 2, '15cm x 8cm x 8cm', 3, 'grand, oversized, attache, metal', '', '2019-03-20 00:00:00', 0, 0, ''),
(14, 8, 115, 12, '50cm x 50cm', 2, 'carpette, épais, carré, bleu, paillaisson, tapis', 'Carrés de carpettes de 2 coloris différents.', '2019-06-20 00:00:00', 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `journal`
--

DROP TABLE IF EXISTS `journal`;
CREATE TABLE IF NOT EXISTS `journal` (
  `journal_ID` int(11) NOT NULL AUTO_INCREMENT,
  `operation` varchar(10) NOT NULL,
  `ID_objet` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL,
  PRIMARY KEY (`journal_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `journal`
--

INSERT INTO `journal` (`journal_ID`, `operation`, `ID_objet`, `ID_categorie`, `ID_souscategorie`, `pieces`, `etat`, `date_operation`, `poids`, `prix`, `localisation`) VALUES
(67, 'add', 28, 7, 39, 1, 1, '2019-10-21 10:43:11', 0, 0, 'Récupérathèque'),
(66, 'add', 27, 7, 39, 1, 1, '2019-10-21 10:43:02', 0, 0, 'Récupérathèque'),
(65, 'add', 26, 4, 18, 1, 1, '2019-10-21 10:42:24', 0, 0, 'Récupérathèque'),
(64, 'add', 25, 11, 63, 1, 1, '2019-10-21 10:41:20', 1, 0, 'Récupérathèque'),
(63, 'add', 24, 8, 42, 1, 1, '2019-10-21 10:41:06', 1, 0, 'Récupérathèque'),
(62, 'add', 23, 9, 52, 1, 1, '2019-10-21 10:40:56', 1, 0, 'Récupérathèque'),
(61, 'add', 22, 4, 19, 1, 1, '2019-10-21 10:40:48', 0, 0, 'Récupérathèque'),
(68, 'add', 29, 5, 27, 1, 1, '2019-10-21 10:43:22', 0, 0, 'Récupérathèque'),
(69, 'add', 30, 4, 19, 1, 1, '2019-10-21 10:43:31', 0, 0, 'Récupérathèque'),
(70, 'add', 31, 3, 15, 1, 1, '2019-10-21 10:43:44', 0, 0, 'Récupérathèque'),
(71, 'sell', 25, 11, 63, 1, 1, '2019-10-21 10:44:13', 1, 0, 'Récupérathèque'),
(72, 'sell', 26, 4, 18, 1, 1, '2019-10-21 10:44:20', 0, 0, 'Récupérathèque'),
(73, 'sell', 31, 3, 15, 1, 1, '2019-10-21 10:44:24', 0, 0, 'Récupérathèque'),
(74, 'sell', 30, 4, 19, 1, 1, '2019-10-21 10:44:29', 0, 0, 'Récupérathèque'),
(75, 'sell', 29, 5, 27, 1, 1, '2019-10-21 10:44:34', 0, 0, 'Récupérathèque'),
(76, 'sell', 28, 7, 39, 1, 1, '2019-10-21 10:44:40', 0, 0, 'Récupérathèque'),
(77, 'sell', 27, 7, 39, 1, 1, '2019-10-21 10:44:47', 0, 0, 'Récupérathèque'),
(78, 'add', 25, 18, 125, 1, 1, '2019-10-21 10:45:05', 1, 0, 'Récupérathèque'),
(79, 'sell', 25, 18, 125, 1, 1, '2019-10-21 10:45:13', 1, 0, 'Récupérathèque'),
(80, 'remove', 24, 8, 42, 1, 1, '2019-10-21 10:45:25', 1, 0, 'Récupérathèque'),
(81, 'add', 24, 13, 120, 3, 3, '2019-10-21 10:45:51', 0.4, 25, 'Récupérathèque'),
(82, 'add', 25, 8, 46, 1, 1, '2019-10-21 10:46:50', 1, 0, 'Récupérathèque'),
(83, 'add', 26, 1, 2, 3, 3, '2019-10-21 10:53:14', 5, 0, 'Récupérathèque'),
(84, 'add', 27, 6, 34, 1, 1, '2019-10-21 11:14:47', 0, 0, 'Récupérathèque'),
(85, 'add', 28, 6, 34, 1, 1, '2019-10-21 11:42:08', 0, 0, 'Récupérathèque'),
(86, 'add', 29, 5, 26, 1, 1, '2019-10-21 11:43:09', 0, 0, 'Récupérathèque'),
(87, 'add', 30, 6, 35, 1, 1, '2019-10-21 11:43:25', 0, 0, 'Récupérathèque'),
(88, 'add', 31, 5, 27, 1, 1, '2019-10-21 11:43:40', 0, 0, 'Récupérathèque'),
(89, 'add', 32, 12, 69, 1, 1, '2019-10-21 11:44:08', 1, 0, 'Récupérathèque'),
(90, 'add', 33, 5, 26, 1, 1, '2019-10-21 11:46:10', 0, 0, 'Récupérathèque'),
(91, 'add', 34, 6, 34, 1, 1, '2019-10-21 11:53:17', 0, 0, 'Récupérathèque'),
(92, 'remove', 30, 6, 35, 1, 1, '2019-10-21 12:11:54', 0, 0, 'Récupérathèque'),
(93, 'remove', 33, 5, 26, 1, 1, '2019-10-21 12:12:06', 0, 0, 'Récupérathèque'),
(94, 'sell', 32, 12, 69, 1, 1, '2019-10-21 12:16:10', 1, 0, 'Récupérathèque'),
(95, 'sell', 31, 5, 27, 1, 1, '2019-10-21 12:16:16', 0, 0, 'Récupérathèque'),
(96, 'sell', 28, 6, 34, 1, 1, '2019-10-21 12:16:21', 0, 0, 'Récupérathèque'),
(97, 'sell', 29, 5, 26, 1, 1, '2019-10-21 12:16:27', 0, 0, 'Récupérathèque'),
(98, 'sell', 27, 6, 34, 1, 1, '2019-10-21 12:16:32', 0, 0, 'Récupérathèque'),
(99, 'add', 35, 18, 125, 1, 1, '2019-10-21 12:17:11', 15, 8, 'Récupérathèque'),
(100, 'add', 36, 18, 125, 2, 3, '2019-10-21 12:17:56', 10, 5, 'Récupérathèque'),
(101, 'remove', 26, 1, 2, 3, 1, '2019-10-21 12:18:12', 5, 0, 'Récupérathèque'),
(102, 'sell', 36, 18, 125, 1, 3, '2019-10-21 15:25:10', 10, 5, 'Récupérathèque'),
(103, 'edit', 22, 4, 19, 9, 1, '2019-10-21 15:30:33', 0, 0, 'Récupérathèque'),
(104, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:30:42', 0, 0, 'Récupérathèque'),
(105, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:30:53', 0, 0, 'Récupérathèque'),
(106, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:31:53', 0, 0, 'Récupérathèque'),
(107, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:35:15', 0, 0, 'Récupérathèque'),
(108, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:36:14', 0, 0, 'Récupérathèque'),
(109, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:37:24', 0, 0, 'Récupérathèque'),
(110, 'sell', 36, 18, 125, 1, 3, '2019-10-21 15:37:33', 10, 5, 'Récupérathèque'),
(111, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:37:45', 0, 0, 'Récupérathèque'),
(112, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:37:56', 0, 0, 'Récupérathèque'),
(113, 'sell', 22, 4, 19, 1, 1, '2019-10-21 15:38:05', 0, 0, 'Récupérathèque'),
(114, 'add', 36, 2, 7, 1, 1, '2019-10-21 19:32:21', 1, 0.4, 'Récupérathèque'),
(115, 'add', 37, 2, 7, 1, 1, '2019-10-21 19:32:53', 1, 0.4, 'Récupérathèque'),
(116, 'add', 38, 2, 10, 1, 1, '2019-10-21 19:33:07', 1, 3.36, 'Récupérathèque'),
(117, 'add', 39, 4, 20, 1, 1, '2019-10-21 19:33:18', 0, 0, 'Récupérathèque'),
(118, 'add', 40, 4, 17, 1, 1, '2019-10-21 19:33:26', 0, 1.5, 'Récupérathèque'),
(119, 'add', 41, 7, 36, 1, 1, '2019-10-21 19:37:43', 0, 1.25, 'Récupérathèque'),
(120, 'remove', 41, 7, 36, 1, 1, '2019-10-21 19:40:00', 0, 1.25, 'Récupérathèque'),
(121, 'remove', 40, 4, 17, 1, 1, '2019-10-21 19:40:10', 0, 1.5, 'Récupérathèque'),
(122, 'remove', 39, 4, 20, 1, 1, '2019-10-21 19:40:19', 0, 0, 'Récupérathèque'),
(123, 'remove', 38, 2, 10, 1, 1, '2019-10-21 19:40:35', 1, 3.36, 'Récupérathèque'),
(124, 'remove', 37, 2, 7, 1, 1, '2019-10-21 19:40:44', 1, 0.4, 'Récupérathèque'),
(125, 'remove', 36, 2, 7, 1, 1, '2019-10-21 19:42:12', 1, 0.4, 'Récupérathèque'),
(126, 'remove', 35, 18, 125, 1, 1, '2019-10-21 19:42:21', 15, 8, 'Récupérathèque'),
(127, 'remove', 34, 6, 34, 1, 1, '2019-10-21 19:42:32', 0, 0, 'Récupérathèque'),
(128, 'remove', 25, 8, 46, 1, 1, '2019-10-21 19:42:40', 1, 0, 'Récupérathèque'),
(129, 'remove', 24, 13, 120, 3, 1, '2019-10-21 19:42:51', 0.4, 25, 'Récupérathèque'),
(130, 'sell', 23, 9, 52, 1, 1, '2019-10-21 19:43:00', 1, 0, 'Récupérathèque'),
(131, 'add', 22, 3, 14, 1, 3, '2019-11-01 19:40:24', 1, 1.77, 'Récupérathèque'),
(132, 'add', 23, 3, 110, 1, 3, '2019-11-03 13:50:44', 1, 2.2, '');

-- --------------------------------------------------------

--
-- Structure de la table `recuperatheques`
--

DROP TABLE IF EXISTS `recuperatheques`;
CREATE TABLE IF NOT EXISTS `recuperatheques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `monnaie` varchar(8) NOT NULL,
  `telephone` varchar(16) NOT NULL,
  `mdp` varchar(32) NOT NULL,
  `site` varchar(255) NOT NULL,
  `raccourci` varchar(16) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `recuperatheques`
--

INSERT INTO `recuperatheques` (`ID`, `nom`, `adresse`, `monnaie`, `telephone`, `mdp`, `site`, `raccourci`) VALUES
(1, 'Boite à Gants', '87, rue du Page\r\n1050 Bruxelles (B)\r\nSur le plateau art.', 'glock', '', '', 'http://erg.be/BAG/index.html', 'bag'),
(2, 'Gilbards', 'Rue Abbé Cuylits 44, 1070 Anderlecht', 'G', '', '', 'http://gilbard.be/', 'gilbards');

-- --------------------------------------------------------

--
-- Structure de la table `souscategorie`
--

DROP TABLE IF EXISTS `souscategorie`;
CREATE TABLE IF NOT EXISTS `souscategorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `unite` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `souscategorie`
--

INSERT INTO `souscategorie` (`ID`, `nom`, `ID_categorie`, `unite`, `prix`) VALUES
(1, 'Massif', 1, 'kg', 1),
(2, 'Contreplaqué/Multiplex', 1, 'kg', 1.88),
(3, 'Aggloméré', 1, 'kg', 0.3),
(4, 'OSB', 1, 'kg', 0.36),
(5, 'Médium/MDF', 1, 'kg', 0.78),
(6, 'Balsa', 1, 'kg', 236),
(7, 'Acier', 2, 'kg', 0.4),
(8, 'Laiton', 2, 'kg', 12.5),
(9, 'Aluminium', 2, 'kg', 8.72),
(10, 'Plomb', 2, 'kg', 3.36),
(126, 'Cuivre', 2, 'kg', 8.25),
(12, 'Or', 2, 'kg', 2724),
(13, 'Papier', 3, 'kg', 3.46),
(14, 'Carton', 3, 'kg', 1.77),
(15, 'Fil de reliure', 3, 'pc', 11.62),
(16, 'Stylo', 4, 'pc', 0.5),
(17, 'Feutre', 4, 'pc', 1.5),
(18, 'Porte-mine', 4, 'pc', 2.82),
(19, 'Crayon', 4, 'pc', 0.9),
(20, 'Pastel', 4, 'pc', 0),
(21, 'Craie', 4, 'pc', 0.3),
(22, 'Fusain', 4, 'pc', 0.19),
(24, 'Régle', 5, 'pc', 0),
(25, 'Équerre', 5, 'pc', 1.89),
(26, 'Rapporteur', 5, 'pc', 0.62),
(27, 'Pistolet', 5, 'pc', 3.36),
(28, 'Laser', 5, 'pc', 25.44),
(29, 'Mètre', 5, 'pc', 1.47),
(30, 'Compas', 5, 'pc', 9.9),
(31, 'Colle', 6, 'pc', 7.39),
(33, 'Pistolet à colle', 6, 'pc', 3.45),
(34, 'Ruban adhésif', 6, 'pc', 1),
(35, 'Pâte à fixe', 6, 'pc', 2.35),
(36, 'Cutter', 7, 'pc', 1.25),
(37, 'Tapis de découpe', 7, 'pc', 3),
(38, 'Ciseau', 7, 'pc', 2),
(39, 'Pince coupante', 7, 'pc', 2),
(40, 'Rogneuse', 7, 'pc', 8.5),
(41, 'Scie', 7, 'pc', 5.25),
(42, 'Tissus', 8, 'kg', 3),
(43, 'Feutre', 8, 'kg', 5),
(51, 'Plâtre', 9, 'kg', 0.24),
(50, 'Chaux', 9, 'kg', 0.35),
(46, 'Toile peintre', 8, 'kg', 4),
(47, 'Cuir', 8, 'kg', 10),
(48, 'Moquette', 8, 'kg', 2.26),
(49, 'Mercerie', 8, 'pc', 0),
(52, 'Béton', 9, 'kg', 0.08),
(53, 'Pierre', 9, 'kg', 0.12),
(57, 'Argile', 10, 'kg', 0.4),
(56, 'Carreaux', 10, 'kg', 0.37),
(58, 'Grès', 10, 'kg', 0.4),
(59, 'Porcelaine', 10, 'kg', 0.7),
(60, 'Émail', 10, 'pc', 33),
(61, 'Tour de potier', 10, 'pc', 650),
(62, 'Plaque', 11, 'kg', 3.4),
(63, 'Mirroir', 11, 'kg', 3.45),
(64, 'Fenêtre', 11, 'kg', 0),
(65, 'Soufflé', 11, 'kg', 0),
(67, 'Plexiglass', 12, 'kg', 6.11),
(68, 'Mousse', 12, 'kg', 3),
(69, 'Polystyrène/Frigolite/Sagex', 12, 'kg', 3.6),
(70, 'PVC', 12, 'kg', 8.12),
(71, 'Gélatine', 12, 'kg', 25.8),
(72, 'Forex', 12, 'kg', 4.59),
(73, 'Dibond', 12, 'kg', 11.6),
(74, 'Aquarelle', 13, 'pc', 0),
(75, 'Intérieur', 13, 'kg', 7),
(76, 'Extérieur', 13, 'kg', 7.5),
(77, 'Pigments', 13, 'pc', 39.75),
(78, 'Chassis de peinture', 13, 'pc', 0),
(79, 'Pinceau', 13, 'pc', 2),
(80, 'Foreuse', 14, 'pc', 25),
(81, 'Tournevis', 14, 'pc', 5),
(82, 'Ponceuse', 14, 'pc', 18),
(83, 'Meuleuse', 14, 'pc', 22),
(84, 'Vis', 15, 'pc', 0.05),
(85, 'Chevilles', 15, 'pc', 0.02),
(86, 'Boulons', 15, 'pc', 0),
(87, 'Roulettes', 15, 'pc', 0),
(88, 'Chaînes', 15, 'pc', 0),
(89, 'Ordinateur', 16, 'pc', 0),
(90, 'Écran', 16, 'pc', 8),
(91, 'Vidéo', 16, 'pc', 0),
(92, 'Audio', 16, 'pc', 0),
(93, 'Micro controleur/Micro ordinateur', 16, 'pc', 0),
(94, 'Cable', 16, 'pc', 0),
(108, 'Autre', 1, 'kg', 0.9),
(109, 'Autre', 2, 'kg', 2.75),
(110, 'Autre', 3, 'kg', 2.2),
(111, 'Autre', 4, 'pc\r\n', 0.75),
(112, 'Autre', 5, 'pc', 3),
(113, 'Autre', 6, 'pc', 2.5),
(114, 'Autre', 7, 'pc', 2.25),
(115, 'Autre', 8, 'kg', 3),
(116, 'Autre', 9, 'kg', 0.15),
(117, 'Autre', 10, 'kg', 0.4),
(118, 'Autre', 11, 'kg', 3),
(119, 'Autre', 12, 'kg', 6),
(120, 'Autre', 13, 'kg', 3.5),
(121, 'Autre', 14, 'pc', 10),
(122, 'Autre', 15, 'pc', 0.03),
(123, 'Autre', 16, 'pc', 6),
(124, 'Autre', 17, 'pc', 20),
(125, 'Autre', 18, 'no', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
