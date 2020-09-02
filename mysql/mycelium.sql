-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 02 sep. 2020 à 21:14
-- Version du serveur :  5.7.23-23-log
-- Version de PHP :  7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mycelium`
--

-- --------------------------------------------------------

--
-- Structure de la table `bag_catalogue`
--

CREATE TABLE `bag_catalogue` (
  `ID` int(11) NOT NULL,
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
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bag_catalogue`
--

INSERT INTO `bag_catalogue` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(49, 13, 79, 1, '', 1, 'éponge', '', '2019-12-19 10:18:34', 0, 1, ''),
(45, 15, 57, 1, '', 1, 'Argile', 'Utilisable, à humidifier. ', '2019-12-19 10:05:05', 1, 0.4, ''),
(20, 8, 49, 1, '', 1, 'turquoise,  fil,  nylon,  bobine', '', '2019-09-29 09:43:56', 1, 1, ''),
(44, 13, 120, 1, '', 3, 'Gouache, colors', '', '2019-12-19 10:04:25', 0.1, 2, ''),
(23, 3, 110, 1, '', 1, 'couleur,  vraiment,  beaucoup,  ripcolor,  vert,  rouge,  bleu,  mauve,  violet,  brun,  orange,  echantillon', '', '2019-11-03 13:50:44', 1, 3, ''),
(51, 15, 84, 1, 'Toutes tailles', 1, 'varié, métal, attache', 'Divers', '2019-12-19 10:23:52', 0, 0.05, ''),
(50, 17, 69, 1, '', 1, 'torus,  boucle,  infinity', '', '2019-12-19 10:19:44', 0.1, 3.6, ''),
(47, 17, 124, 1, '', 1, '', '', '2019-12-19 10:09:16', 0.2, 6, ''),
(48, 11, 63, 1, '', 1, '', '', '2019-12-19 10:17:22', 0.7, 3.45, ''),
(52, 4, 134, 1, 'Grand', 1, 'noir', 'État pas top en début de rouleau, mais après nickel', '2019-12-19 10:32:03', 1, 28.69, ''),
(53, 2, 109, 1, '', 1, 'range,  capsule,  café', '', '2019-12-19 10:36:11', 0.5, 4, ''),
(54, 14, 166, 2, 'Variable', 1, 'Béton cellulaire', 'Divers ', '2019-12-19 10:46:00', 0.6, 0.4, ''),
(55, 23, 178, 3, '', 1, 'plante,   vert', '', '2020-04-09 08:13:10', 0.6, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `bag_journal`
--

CREATE TABLE `bag_journal` (
  `ID` int(11) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `ID_objet` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bag_journal`
--

INSERT INTO `bag_journal` (`ID`, `operation`, `ID_objet`, `ID_categorie`, `ID_souscategorie`, `pieces`, `etat`, `date_operation`, `poids`, `prix`, `localisation`) VALUES
(1, 'sell', 16, 2, 7, 1, 1, '2019-12-10 13:02:21', 0.1, 4, ''),
(2, 'sell', 18, 8, 49, 1, 1, '2019-12-10 13:02:40', 0.2, 1, ''),
(3, 'sell', 21, 8, 42, 1, 1, '2019-12-10 13:03:36', 0.5, 0, ''),
(4, 'sell', 22, 3, 14, 1, 3, '2019-12-10 13:04:21', 1, 1.77, 'Récupérathèque'),
(5, 'add', 44, 13, 120, 1, 3, '2019-12-19 10:04:25', 0.1, 2, ''),
(6, 'add', 45, 10, 57, 1, 2, '2019-12-19 10:05:05', 1, 0.24, ''),
(7, 'add', 46, 12, 119, 1, 3, '2019-12-19 10:06:36', 0.1, 0.4, ''),
(8, 'sell', 46, 12, 119, 1, 3, '2019-12-19 10:07:04', 0.1, 0.4, ''),
(9, 'add', 47, 18, 125, 1, 3, '2019-12-19 10:09:16', 0.2, 0, ''),
(10, 'add', 48, 18, 125, 1, 2, '2019-12-19 10:17:22', 0.7, 0, ''),
(11, 'edit', 47, 18, 125, 1, 1, '2019-12-19 10:17:28', 0.2, 1, ''),
(12, 'add', 49, 13, 79, 1, 4, '2019-12-19 10:18:34', 0, 0.2, ''),
(13, 'edit', 48, 18, 125, 1, 1, '2019-12-19 10:19:26', 0.7, 1, ''),
(14, 'add', 50, 12, 69, 1, 4, '2019-12-19 10:19:44', 0.1, 0.5, ''),
(15, 'edit', 49, 13, 79, 1, 4, '2019-12-19 10:19:57', 0, 1, ''),
(16, 'edit', 50, 12, 69, 1, 1, '2019-12-19 10:20:31', 0.1, 1, ''),
(17, 'add', 51, 15, 84, 1, 4, '2019-12-19 10:23:52', 0, 0.05, ''),
(18, 'edit', 50, 12, 69, 1, 1, '2019-12-19 10:26:07', 0.1, 1, ''),
(19, 'edit', 49, 13, 79, 1, 1, '2019-12-19 10:26:52', 0, 1, ''),
(20, 'edit', 51, 15, 84, 1, 1, '2019-12-19 10:28:52', 0, 0.05, ''),
(21, 'edit', 45, 10, 57, 1, 3, '2019-12-19 10:30:39', 1, 2, ''),
(22, 'edit', 23, 3, 110, 1, 1, '2019-12-19 10:31:05', 1, 3, ''),
(23, 'add', 52, 3, 13, 1, 3, '2019-12-19 10:32:03', 0.7, 3, ''),
(24, 'edit', 52, 3, 13, 1, 3, '2019-12-19 10:35:15', 1, 3, ''),
(25, 'add', 53, 2, 109, 1, 3, '2019-12-19 10:36:11', 0.5, 1.1, ''),
(26, 'add', 54, 9, 52, 5, 1, '2019-12-19 10:46:00', 0.6, 0.5, ''),
(27, 'edit', 54, 9, 52, 5, 1, '2019-12-19 15:42:32', 0.6, 1, ''),
(28, 'edit', 52, 3, 13, 1, 1, '2019-12-19 15:42:57', 1, 3, ''),
(29, 'edit', 53, 2, 109, 1, 1, '2019-12-19 15:44:11', 0.5, 1.1, ''),
(30, 'edit', 48, 11, 63, 1, 1, '2019-12-20 14:24:49', 0.7, 3.45, ''),
(31, 'sell', 54, 9, 52, 3, 1, '2020-04-09 08:11:02', 1.8, 3, ''),
(32, 'add', 55, 18, 125, 3, 3, '2020-04-09 08:13:10', 0.6, 0, ''),
(33, 'edit', 55, 18, 125, 3, 1, '2020-04-09 08:13:44', 0.6, 5, ''),
(34, 'add', 56, 1, 5, 3, 1, '2020-04-29 10:19:26', 4, 1.25, ''),
(35, 'remove', 56, 1, 5, 3, 1, '2020-04-29 10:22:22', 4, 1.25, ''),
(36, 'edit', 55, 23, 178, 3, 1, '2020-05-31 08:07:10', 0.6, 1, ''),
(37, 'edit', 54, 14, 166, 2, 1, '2020-05-31 08:09:39', 0.6, 0.4, ''),
(38, 'edit', 52, 4, 134, 1, 1, '2020-05-31 08:15:04', 1, 28.69, ''),
(39, 'edit', 50, 17, 69, 1, 1, '2020-05-31 08:15:34', 0.1, 3.6, ''),
(40, 'edit', 47, 17, 124, 1, 1, '2020-05-31 08:15:59', 0.2, 6, ''),
(41, 'edit', 45, 15, 57, 1, 1, '2020-05-31 08:16:24', 1, 0.4, ''),
(42, 'edit', 53, 2, 109, 1, 1, '2020-05-31 08:16:51', 0.5, 4, '');

-- --------------------------------------------------------

--
-- Structure de la table `cab_catalogue`
--

CREATE TABLE `cab_catalogue` (
  `ID` int(11) NOT NULL,
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
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cab_catalogue`
--

INSERT INTO `cab_catalogue` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(23, 3, 14, 10, '', 3, 'Carton plume, 3mm, Petit format', '', '2020-01-27 14:17:59', 1, 1.42, ''),
(15, 3, 14, 15, '100cm x 70cm, 2mm d\'épaisseur', 4, 'Carton brun', '', '2020-01-27 13:30:53', 1, 4, ''),
(14, 13, 76, 1, '', 4, 'Laque blanc extérieur levis', '', '2020-01-27 13:28:14', 0.7, 5.25, ''),
(16, 13, 120, 1, '', 4, 'Cyan,  Bleu clair,  Talens,  Gouache', '', '2020-01-27 13:42:19', 1, 3, ''),
(17, 3, 14, 10, '100cm x 70cm, 6mm d\'épaisseur', 4, 'Carton brun,  6mm', '', '2020-01-27 13:57:42', 1, 4, ''),
(18, 3, 14, 14, '100cm x 70cm, 3mm d\'épaisseur', 4, 'Carton plume,  3mm', '', '2020-01-27 14:00:39', 1, 4, ''),
(19, 3, 14, 21, '50cm x 70cm 3mm', 4, 'Carton plume,   3mm', '', '2020-01-27 14:04:10', 1, 2, ''),
(20, 3, 14, 6, '50cm x 70cm 5mm', 4, 'Carton plume,  5mm', '', '2020-01-27 14:08:19', 1, 2, ''),
(21, 3, 14, 1, '70cm x 100cm 5mm', 2, 'Carton plume, 5mm', '', '2020-01-27 14:13:41', 1, 3.5, ''),
(22, 3, 14, 2, '', 3, 'Carton plume,  10mm', '100cm x 70cm 10mm', '2020-01-27 14:15:41', 1, 3.5, ''),
(24, 3, 14, 17, '', 2, 'Carton plume,  3mm,  Moyen format', '', '2020-01-27 14:19:44', 1, 1.5, ''),
(25, 3, 14, 10, '', 1, 'Carton plume, 5mm, Petit format', '', '2020-01-27 14:22:11', 1, 1, ''),
(26, 3, 14, 7, '', 1, 'Carton plume, 5mm, Moyen format', '', '2020-01-27 14:25:34', 1, 1.5, ''),
(27, 3, 14, 19, '', 4, 'Carton plume, 5mm, Petit format', '', '2020-01-27 14:27:10', 1, 1, ''),
(28, 3, 14, 13, '', 2, 'Carton brun, Fin, Moyen format', '', '2020-01-27 14:31:26', 1, 1.5, ''),
(29, 3, 14, 3, '', 2, 'Carton brun, Moyen format, Fin', '', '2020-01-27 14:32:15', 1, 1, ''),
(30, 3, 14, 19, '', 4, 'Carton brun, Épais, Moyen format', '', '2020-01-27 14:34:05', 1, 2, ''),
(31, 3, 14, 26, '', 3, 'Carton brun, Petit format, Épais', '', '2020-01-27 14:35:20', 1, 1, ''),
(32, 3, 14, 7, '', 2, 'Carton plume, 10mm, Moyen format', '', '2020-01-27 14:40:07', 1, 2, ''),
(33, 3, 14, 14, '', 2, 'Carton plume, 10mm, Petit format', '', '2020-01-27 14:40:55', 1, 1.5, '');

-- --------------------------------------------------------

--
-- Structure de la table `cab_journal`
--

CREATE TABLE `cab_journal` (
  `ID` int(11) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `ID_objet` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cab_journal`
--

INSERT INTO `cab_journal` (`ID`, `operation`, `ID_objet`, `ID_categorie`, `ID_souscategorie`, `pieces`, `etat`, `date_operation`, `poids`, `prix`, `localisation`) VALUES
(1, 'add', 1, 18, 125, 1, 4, '2019-12-05 11:41:20', 600, 0, ''),
(2, 'edit', 1, 18, 125, 1, 1, '2019-12-05 11:58:44', 600, 99, ''),
(8, 'add', 3, 11, 118, 1, 4, '2019-12-12 11:31:57', 0.7, 2.1, ''),
(7, 'add', 2, 13, 120, 1, 3, '2019-12-12 11:30:00', 0.9, 3, ''),
(9, 'edit', 3, 11, 118, 1, 1, '2019-12-12 11:32:25', 0.7, 2, ''),
(10, 'edit', 3, 11, 118, 1, 4, '2019-12-12 11:33:21', 0.7, 2, ''),
(11, 'add', 4, 13, 75, 1, 3, '2019-12-12 11:36:49', 0.1, 1, ''),
(12, 'add', 5, 13, 75, 1, 4, '2019-12-12 11:41:27', 0.3, 2, ''),
(13, 'add', 6, 5, 30, 1, 2, '2019-12-12 11:43:44', 0, 1, ''),
(14, 'add', 7, 5, 30, 1, 3, '2019-12-12 11:45:53', 0, 1, ''),
(15, 'add', 8, 7, 38, 1, 3, '2019-12-12 11:47:26', 0, 2, ''),
(16, 'add', 9, 3, 110, 3, 2, '2019-12-12 11:49:45', 0.1, 1, ''),
(17, 'add', 10, 5, 25, 1, 3, '2019-12-12 11:51:47', 0, 2, ''),
(18, 'add', 11, 13, 120, 1, 2, '2019-12-12 11:53:19', 0.1, 1, ''),
(19, 'add', 12, 8, 42, 1, 2, '2019-12-12 11:57:17', 0.1, 1, ''),
(20, 'remove', 12, 8, 42, 1, 1, '2020-01-27 11:27:10', 0.1, 1, ''),
(21, 'remove', 11, 13, 120, 1, 1, '2020-01-27 11:27:18', 0.1, 1, ''),
(22, 'remove', 10, 5, 25, 1, 1, '2020-01-27 11:27:26', 0, 2, ''),
(23, 'remove', 9, 3, 110, 3, 1, '2020-01-27 11:27:43', 0.1, 1, ''),
(24, 'remove', 8, 7, 38, 1, 1, '2020-01-27 11:27:49', 0, 2, ''),
(25, 'remove', 7, 5, 30, 1, 1, '2020-01-27 11:27:57', 0, 1, ''),
(26, 'remove', 6, 5, 30, 1, 1, '2020-01-27 11:28:03', 0, 1, ''),
(27, 'remove', 5, 13, 75, 1, 1, '2020-01-27 11:28:11', 0.3, 2, ''),
(28, 'remove', 4, 13, 75, 1, 1, '2020-01-27 11:28:18', 0.1, 1, ''),
(29, 'remove', 3, 11, 118, 1, 1, '2020-01-27 11:28:26', 0.7, 2, ''),
(30, 'remove', 2, 13, 120, 1, 1, '2020-01-27 11:28:33', 0.9, 3, ''),
(31, 'remove', 1, 18, 125, 1, 1, '2020-01-27 11:28:44', 600, 999, ''),
(32, 'add', 13, 3, 14, 15, 4, '2020-01-27 13:12:58', 1, 1.77, ''),
(33, 'edit', 13, 3, 14, 15, 4, '2020-01-27 13:17:25', 0.011, 2, ''),
(34, 'edit', 13, 3, 14, 15, 1, '2020-01-27 13:20:45', 0.011, 2, ''),
(35, 'edit', 13, 3, 14, 15, 4, '2020-01-27 13:23:47', 0.011, 2, ''),
(36, 'add', 14, 13, 76, 1, 4, '2020-01-27 13:28:14', 0.7, 5.25, ''),
(37, 'remove', 13, 3, 14, 15, 1, '2020-01-27 13:29:34', 0.011, 2, ''),
(38, 'add', 15, 3, 14, 15, 4, '2020-01-27 13:30:53', 0.31, 0.55, ''),
(39, 'add', 16, 13, 120, 1, 4, '2020-01-27 13:42:19', 0.1, 0.35, ''),
(40, 'edit', 16, 13, 120, 1, 1, '2020-01-27 13:51:22', 0.1, 3, ''),
(41, 'edit', 16, 13, 120, 1, 4, '2020-01-27 13:51:33', 0.1, 3, ''),
(42, 'edit', 16, 13, 120, 1, 1, '2020-01-27 13:52:05', 1, 3, ''),
(43, 'edit', 15, 3, 14, 15, 1, '2020-01-27 13:52:33', 1, 4, ''),
(44, 'edit', 15, 3, 14, 15, 4, '2020-01-27 13:53:41', 1, 4, ''),
(45, 'add', 17, 3, 14, 10, 3, '2020-01-27 13:57:42', 1, 1.42, ''),
(46, 'edit', 17, 3, 14, 10, 4, '2020-01-27 13:58:04', 1, 4, ''),
(47, 'add', 18, 3, 14, 14, 3, '2020-01-27 14:00:39', 1, 4, ''),
(48, 'edit', 16, 13, 120, 1, 3, '2020-01-27 14:01:37', 1, 3, ''),
(49, 'edit', 16, 13, 120, 1, 4, '2020-01-27 14:01:51', 1, 3, ''),
(50, 'add', 19, 3, 14, 1, 4, '2020-01-27 14:04:10', 1, 2, ''),
(51, 'edit', 19, 3, 14, 21, 1, '2020-01-27 14:04:55', 1, 2, ''),
(52, 'edit', 18, 3, 14, 14, 1, '2020-01-27 14:05:15', 1, 4, ''),
(53, 'edit', 18, 3, 14, 14, 4, '2020-01-27 14:05:32', 1, 4, ''),
(54, 'edit', 18, 3, 14, 14, 4, '2020-01-27 14:05:38', 1, 4, ''),
(55, 'edit', 19, 3, 14, 21, 4, '2020-01-27 14:05:50', 1, 2, ''),
(56, 'add', 20, 3, 14, 1, 4, '2020-01-27 14:08:19', 1, 2, ''),
(57, 'edit', 20, 3, 14, 6, 4, '2020-01-27 14:09:01', 1, 2, ''),
(58, 'add', 21, 3, 14, 1, 2, '2020-01-27 14:13:41', 1, 3.5, ''),
(59, 'add', 22, 3, 14, 2, 2, '2020-01-27 14:15:41', 1, 3.5, ''),
(60, 'add', 23, 3, 14, 10, 3, '2020-01-27 14:17:59', 1, 1.42, ''),
(61, 'add', 24, 3, 14, 17, 4, '2020-01-27 14:19:44', 1, 1.5, ''),
(62, 'add', 25, 3, 14, 10, 1, '2020-01-27 14:22:11', 1, 1, ''),
(63, 'edit', 24, 3, 14, 17, 2, '2020-01-27 14:22:33', 1, 1.5, ''),
(64, 'edit', 22, 3, 14, 2, 3, '2020-01-27 14:22:55', 1, 3.5, ''),
(65, 'add', 26, 3, 14, 7, 1, '2020-01-27 14:25:34', 1, 1.5, ''),
(66, 'add', 27, 3, 14, 19, 4, '2020-01-27 14:27:10', 1, 1, ''),
(67, 'add', 28, 3, 14, 13, 2, '2020-01-27 14:31:26', 1, 1.5, ''),
(68, 'add', 29, 3, 14, 3, 2, '2020-01-27 14:32:15', 1, 1, ''),
(69, 'add', 30, 3, 14, 19, 4, '2020-01-27 14:34:05', 1, 2, ''),
(70, 'add', 31, 3, 14, 26, 3, '2020-01-27 14:35:20', 1, 1, ''),
(71, 'add', 32, 3, 14, 7, 2, '2020-01-27 14:40:07', 1, 2, ''),
(72, 'add', 33, 3, 14, 14, 2, '2020-01-27 14:40:55', 1, 1.5, '');

-- --------------------------------------------------------

--
-- Structure de la table `fourmiliere_catalogue`
--

CREATE TABLE `fourmiliere_catalogue` (
  `ID` int(11) NOT NULL,
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
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fourmiliere_catalogue`
--

INSERT INTO `fourmiliere_catalogue` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(10, 12, 70, 1, '', 3, 'Tube, PVC, gris', '', '2020-02-18 14:23:49', 0.3, 19.5, ''),
(6, 12, 70, 1, '', 1, 'Tube,  PVC', '', '2020-02-18 14:15:49', 0.3, 14.5, ''),
(5, 12, 70, 1, '', 3, 'Tube, PVC', '', '2020-02-18 14:08:42', 0.4, 26, ''),
(11, 12, 70, 1, '', 4, 'Tube, PVC, gris', '', '2020-02-18 14:25:21', 0.1, 8, ''),
(9, 12, 70, 1, '', 3, 'Tube, PVC, Blanc', '', '2020-02-18 14:20:26', 0.2, 13, ''),
(12, 12, 70, 1, '', 3, 'Tube, PVC, Gris', '', '2020-02-18 14:28:03', 0.2, 13, ''),
(13, 12, 70, 1, '', 3, 'Tube, PVC, Gris', '', '2020-02-18 14:30:11', 0.2, 13, ''),
(14, 12, 70, 1, '', 3, 'Tube, PVC, Blanc', '', '2020-02-18 14:33:37', 0.2, 13, ''),
(15, 12, 70, 1, '', 3, 'Tube, PVC, Gris', '', '2020-02-18 14:37:47', 0.4, 26, ''),
(16, 3, 14, 6, '1,1M', 3, 'Tube, Carton', '', '2020-02-18 16:00:30', 0.2, 5, ''),
(17, 8, 43, 1, '2,5M x 0,5M', 2, 'Tissu, Bleu', '', '2020-02-18 16:05:54', 0.1, 3, ''),
(18, 3, 13, 1, '', 2, 'Papier, carton', '', '2020-02-18 16:07:32', 0.2, 4, ''),
(19, 3, 110, 1, '', 2, 'Papier, Calque', '', '2020-02-18 16:08:49', 0.1, 1, ''),
(20, 3, 14, 3, '84cm', 4, 'Tube, carton', '', '2020-02-18 16:13:27', 0.5, 10, ''),
(21, 3, 13, 1, '75cm ', 4, 'Papier, Blanc', '', '2020-02-18 16:26:03', 0.2, 7, ''),
(22, 3, 14, 1, '59,5', 4, 'Tube, carton', '', '2020-02-18 16:28:13', 0.2, 3.5, ''),
(23, 3, 13, 1, '', 2, 'Papier, carton', '', '2020-02-18 16:33:00', 0.1, 2, ''),
(24, 3, 110, 1, '', 3, 'Papier, nappe, noir', '', '2020-02-18 16:34:25', 0.2, 3.5, ''),
(25, 3, 13, 1, '', 2, 'Papier, carton', '', '2020-02-18 16:35:46', 0.1, 2, ''),
(26, 3, 13, 1, '', 4, 'Papier', '', '2020-02-18 16:41:05', 0.3, 1.04, ''),
(27, 3, 13, 1, '', 2, 'Papier', '', '2020-02-18 16:43:13', 0.2, 4, ''),
(28, 3, 13, 1, '', 2, 'Papier, craft', '', '2020-02-18 16:45:38', 0.5, 10.5, ''),
(29, 1, 108, 2, '', 1, 'Bois, Brut', '', '2020-02-19 12:39:50', 0.3, 2.5, ''),
(30, 1, 108, 1, '', 2, 'Bois, Brut', '', '2020-02-19 12:41:26', 0.3, 1.5, ''),
(31, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:43:35', 0.5, 3.5, ''),
(32, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:45:05', 0.4, 3, ''),
(33, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:45:58', 0.2, 1.5, ''),
(34, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:48:09', 0.2, 1.5, ''),
(35, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:53:32', 0.4, 3, ''),
(36, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:55:17', 0.4, 3, ''),
(37, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 12:56:00', 0.2, 1.5, ''),
(38, 1, 108, 1, '', 4, 'Bois, Brut', '', '2020-02-19 12:56:48', 0.3, 3, ''),
(39, 1, 108, 1, '', 2, 'Bois, Brut', '', '2020-02-19 12:58:38', 0.6, 3, ''),
(40, 1, 108, 1, '', 3, 'Bois, Brut', '', '2020-02-19 13:00:27', 0.4, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `fourmiliere_journal`
--

CREATE TABLE `fourmiliere_journal` (
  `ID` int(11) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `ID_objet` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fourmiliere_journal`
--

INSERT INTO `fourmiliere_journal` (`ID`, `operation`, `ID_objet`, `ID_categorie`, `ID_souscategorie`, `pieces`, `etat`, `date_operation`, `poids`, `prix`, `localisation`) VALUES
(1, 'add', 1, 16, 123, 1, 3, '2019-12-05 11:50:36', 0, 6, ''),
(2, 'edit', 1, 16, 123, 1, 1, '2019-12-05 11:51:16', 0, 200, ''),
(3, 'add', 2, 3, 14, 1, 2, '2019-12-06 11:48:59', 0.3, 0.32, ''),
(4, 'add', 3, 16, 89, 1, 1, '2019-12-07 18:03:39', 0, 0, ''),
(5, 'remove', 3, 16, 89, 1, 1, '2019-12-07 18:04:47', 0, 0, ''),
(6, 'add', 4, 18, 125, 1, 3, '2020-01-06 16:07:07', 1, 39, ''),
(7, 'remove', 4, 18, 125, 1, 1, '2020-01-06 16:07:26', 1, 39, ''),
(8, 'add', 5, 12, 70, 1, 3, '2020-02-18 14:08:42', 0.4, 26, ''),
(9, 'remove', 2, 3, 14, 1, 1, '2020-02-18 14:09:27', 0.3, 0.32, ''),
(10, 'remove', 1, 16, 123, 1, 1, '2020-02-18 14:09:51', 0, 200, ''),
(11, 'add', 6, 12, 70, 1, 2, '2020-02-18 14:15:49', 0.3, 14.6, ''),
(12, 'add', 7, 12, 70, 1, 2, '2020-02-18 14:18:28', 0.3, 14.6, ''),
(13, 'add', 8, 12, 70, 1, 2, '2020-02-18 14:19:33', 0.3, 14.6, ''),
(14, 'add', 9, 12, 70, 1, 3, '2020-02-18 14:20:26', 0.2, 13, ''),
(15, 'remove', 8, 12, 70, 1, 1, '2020-02-18 14:21:12', 0.3, 14.6, ''),
(16, 'remove', 7, 12, 70, 1, 1, '2020-02-18 14:21:27', 0.3, 14.6, ''),
(17, 'add', 10, 12, 70, 1, 3, '2020-02-18 14:23:49', 0.3, 19.5, ''),
(18, 'add', 11, 12, 70, 1, 4, '2020-02-18 14:25:21', 0.1, 8, ''),
(19, 'edit', 6, 12, 70, 1, 1, '2020-02-18 14:26:01', 0.3, 14.5, ''),
(20, 'add', 12, 12, 70, 1, 3, '2020-02-18 14:28:03', 0.2, 13, ''),
(21, 'add', 13, 12, 70, 1, 3, '2020-02-18 14:30:11', 0.2, 13, ''),
(22, 'add', 14, 12, 70, 1, 3, '2020-02-18 14:33:37', 0.2, 13, ''),
(23, 'add', 15, 12, 70, 1, 3, '2020-02-18 14:37:47', 0.4, 26, ''),
(24, 'add', 16, 3, 14, 6, 3, '2020-02-18 16:00:30', 0.2, 5, ''),
(25, 'add', 17, 8, 43, 1, 2, '2020-02-18 16:05:54', 0.1, 3, ''),
(26, 'add', 18, 3, 13, 1, 2, '2020-02-18 16:07:32', 0.2, 4, ''),
(27, 'add', 19, 3, 110, 1, 2, '2020-02-18 16:08:49', 0.1, 1, ''),
(28, 'add', 20, 3, 14, 3, 4, '2020-02-18 16:13:27', 0.5, 10, ''),
(29, 'add', 21, 3, 13, 1, 4, '2020-02-18 16:26:03', 0.2, 7, ''),
(30, 'add', 22, 3, 14, 1, 4, '2020-02-18 16:28:13', 0.2, 3.5, ''),
(31, 'add', 23, 3, 13, 1, 2, '2020-02-18 16:33:00', 0.1, 2, ''),
(32, 'add', 24, 3, 110, 1, 3, '2020-02-18 16:34:25', 0.2, 3.5, ''),
(33, 'add', 25, 3, 13, 1, 2, '2020-02-18 16:35:46', 0.1, 2, ''),
(34, 'add', 26, 3, 13, 1, 4, '2020-02-18 16:41:05', 0.3, 1.04, ''),
(35, 'add', 27, 3, 13, 1, 2, '2020-02-18 16:43:13', 0.2, 4, ''),
(36, 'add', 28, 3, 13, 1, 2, '2020-02-18 16:45:38', 0.5, 10.5, ''),
(37, 'add', 29, 1, 108, 2, 3, '2020-02-19 12:39:50', 0.3, 2.5, ''),
(38, 'add', 30, 1, 108, 1, 2, '2020-02-19 12:41:26', 0.3, 1.5, ''),
(39, 'edit', 29, 1, 108, 2, 1, '2020-02-19 12:41:51', 0.3, 2.5, ''),
(40, 'add', 31, 1, 108, 1, 3, '2020-02-19 12:43:35', 0.5, 3.5, ''),
(41, 'add', 32, 1, 108, 1, 3, '2020-02-19 12:45:05', 0.4, 3, ''),
(42, 'add', 33, 1, 108, 1, 3, '2020-02-19 12:45:58', 0.2, 1.5, ''),
(43, 'add', 34, 1, 108, 1, 3, '2020-02-19 12:48:09', 0.2, 1.5, ''),
(44, 'add', 35, 1, 108, 1, 3, '2020-02-19 12:53:32', 0.4, 3, ''),
(45, 'add', 36, 1, 108, 1, 3, '2020-02-19 12:55:17', 0.4, 3, ''),
(46, 'add', 37, 1, 108, 1, 3, '2020-02-19 12:56:00', 0.2, 1.5, ''),
(47, 'add', 38, 1, 108, 1, 4, '2020-02-19 12:56:48', 0.3, 3, ''),
(48, 'add', 39, 1, 108, 1, 2, '2020-02-19 12:58:38', 0.6, 3, ''),
(49, 'add', 40, 1, 108, 1, 3, '2020-02-19 13:00:27', 0.4, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `gilbard_catalogue`
--

CREATE TABLE `gilbard_catalogue` (
  `ID` int(11) NOT NULL,
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
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gilbard_catalogue`
--

INSERT INTO `gilbard_catalogue` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`, `localisation`) VALUES
(2, 1, 1, 1600, '50.8cm x 2cm x 2cm', 1, 'sapin,     baguette,     tasseau,     rabotté', 'A prendre en lots de 100 ', '2019-08-06 00:00:00', 0, 3, ''),
(12, 18, 125, 20, '1m', 1, 'electrique,   alimentation,   plastique', 'Lot de cables électriques pouvant être raccordés ensemble ', '2019-03-22 00:00:00', 0, 0, ''),
(13, 15, 86, 2, '15cm x 8cm x 8cm', 3, 'grand, oversized, attache, metal', '', '2019-03-20 00:00:00', 0, 0, ''),
(14, 8, 115, 12, '50cm x 50cm', 1, 'carpette,  épais,  carré,  bleu,  paillaisson,  tapis', 'Carrés de carpettes de 2 coloris différents.', '2019-06-20 00:00:00', 0, 5, '');

-- --------------------------------------------------------

--
-- Structure de la table `gilbard_journal`
--

CREATE TABLE `gilbard_journal` (
  `ID` int(11) NOT NULL,
  `operation` varchar(10) NOT NULL,
  `ID_objet` int(11) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `etat` int(11) NOT NULL,
  `date_operation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  `localisation` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gilbard_journal`
--

INSERT INTO `gilbard_journal` (`ID`, `operation`, `ID_objet`, `ID_categorie`, `ID_souscategorie`, `pieces`, `etat`, `date_operation`, `poids`, `prix`, `localisation`) VALUES
(1, 'sell', 4, 17, 124, 1, 1, '2019-12-05 16:20:17', 0, 15, ''),
(2, 'sell', 3, 18, 125, 1, 1, '2019-12-05 16:20:23', 0, 30, ''),
(3, 'sell', 11, 18, 125, 1, 1, '2019-12-05 16:20:31', 0, 10, 'Rue Abbé Cuylits 44, 1070 Anderlecht'),
(4, 'sell', 10, 3, 13, 1, 1, '2019-12-05 16:20:42', 0, 15, ''),
(5, 'sell', 8, 1, 1, 1, 1, '2019-12-05 16:20:52', 5, 4, ''),
(6, 'sell', 8, 1, 1, 1, 1, '2019-12-05 16:21:01', 5, 4, ''),
(7, 'sell', 8, 1, 1, 1, 1, '2019-12-05 16:21:11', 5, 4, ''),
(8, 'sell', 7, 18, 125, 1, 1, '2019-12-05 16:21:20', 0, 3, ''),
(9, 'sell', 5, 15, 85, 1, 3, '2019-12-05 16:21:39', 0, 0, ''),
(10, 'sell', 5, 15, 85, 19, 3, '2019-12-05 16:21:55', 0, 0, ''),
(11, 'sell', 7, 18, 125, 5, 1, '2019-12-05 16:22:40', 0, 15, ''),
(12, 'edit', 1, 12, 119, 1, 1, '2019-12-05 16:37:30', 0, 25, ''),
(13, 'edit', 12, 18, 125, 20, 1, '2019-12-05 16:40:00', 0, 0, ''),
(14, 'edit', 2, 1, 1, 1600, 1, '2019-12-21 16:01:08', 0, 3, ''),
(15, 'edit', 2, 1, 1, 1600, 1, '2019-12-21 16:01:55', 0, 3, ''),
(16, 'sell', 6, 12, 67, 1, 1, '2020-03-16 16:00:03', 0, 1, ''),
(17, 'sell', 7, 18, 125, 1, 1, '2020-03-16 16:00:31', 0, 3, ''),
(18, 'sell', 1, 12, 119, 1, 1, '2020-03-16 16:00:38', 0, 25, ''),
(19, 'sell', 9, 4, 17, 1, 3, '2020-03-16 16:00:56', 0, 0, ''),
(20, 'sell', 9, 4, 17, 1, 3, '2020-03-16 16:01:07', 0, 0, ''),
(21, 'sell', 9, 4, 17, 23, 3, '2020-03-16 16:01:19', 0, 0, ''),
(22, 'sell', 7, 18, 125, 3, 1, '2020-03-16 16:01:28', 0, 9, '');

-- --------------------------------------------------------

--
-- Structure de la table `_global_categories`
--

CREATE TABLE `_global_categories` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `_global_categories`
--

INSERT INTO `_global_categories` (`ID`, `nom`, `score`) VALUES
(1, 'Bois', 3),
(2, 'Fer', 2),
(3, 'Métal Autre', 2),
(4, 'Papier', 3),
(5, 'Carton', 3),
(6, 'Dessin ', 2),
(7, 'Marqueur', 2),
(8, 'Mesure & Tracé', 1),
(9, 'Colle', 1),
(10, 'Ruban adhésif', 1),
(11, 'Découpe', 1),
(12, 'Textile', 1),
(13, 'Mercerie', 1),
(14, 'Minéraux', 1),
(15, 'Céramique', 1),
(16, 'Verre', 1),
(17, 'Plastique', 1),
(18, 'Peinture', 1),
(19, 'Outils', -1),
(20, 'Quincaillerie', -1),
(22, 'Mobilier', -1),
(23, 'Insolite', -1);

-- --------------------------------------------------------

--
-- Structure de la table `_global_recuperatheques`
--

CREATE TABLE `_global_recuperatheques` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `monnaie` varchar(8) NOT NULL,
  `telephone` varchar(16) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `pseudo` varchar(16) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `date_creation` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `_global_recuperatheques`
--

INSERT INTO `_global_recuperatheques` (`ID`, `nom`, `adresse`, `monnaie`, `telephone`, `mdp`, `site`, `pseudo`, `mail`, `date_creation`) VALUES
(1, 'La Boite à Gants', '87, rue du Page 1050 Bruxelles, sur le plateau art.', 'Glock', '', '$2y$10$pznGgvXs2isREfM4eQl3LeVFuXnlJ1RqtLwo1YCmUQX4A4XA0oqZe', 'https://boiteagants.solutions', 'bag', 'contact@boiteagants.solutions', NULL),
(2, 'Gilbard', 'Rue Abbé Cuylits 44, 1070 Anderlecht', 'G', '', '$2y$10$0UjV97.WnaUf3ASvvKnukuRF48DMv0F.Oy1DOjeV8BuiAga3sKwDu', 'http://gilbard.be', 'gilbard', 'info@gilbard.be', NULL),
(3, 'La Fourmilière', 'S.UA.5.113', 'Myrmée', '', '$2y$10$BT1BD4lkJs7x0ZxQBaJER.EAqPxUmsI4W7LzILiJQbAYus.QoXq4.', '', 'fourmiliere', 'lafourmiliere.ulb@gmail.com', NULL),
(4, 'La Caverne d\'Ali Baba', '30 place morichar 1060 Bruxelles', 'Lux', '', '$2y$10$U1YJHGvtSG5vJVj2nDBA2O37/oTzeR5ue2WmF/xR20Xzd/0GByYG.', '', 'cab', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `_global_souscategories`
--

CREATE TABLE `_global_souscategories` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `unite` varchar(255) NOT NULL,
  `prix` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `_global_souscategories`
--

INSERT INTO `_global_souscategories` (`ID`, `nom`, `ID_categorie`, `unite`, `prix`) VALUES
(1, 'Massif', 1, 'kg', 1),
(2, 'Contreplaqué/Multiplex', 1, 'kg', 1.88),
(3, 'Aggloméré', 1, 'kg', 0.3),
(4, 'OSB', 1, 'kg', 0.36),
(5, 'Médium/MDF', 1, 'kg', 0.78),
(6, 'Balsa', 1, 'kg', 236),
(7, 'Plaque', 2, 'kg', 3.3),
(8, 'Laiton', 3, 'kg', 12.5),
(9, 'Aluminium', 3, 'kg', 8.72),
(10, 'Plomb', 3, 'kg', 3.36),
(126, 'Cuivre', 3, 'kg', 8.25),
(12, 'Or', 3, 'kg', 2724),
(13, 'Cigarette (12-25 g/m²)', 4, 'kg', 2.84),
(14, 'Gris', 5, 'kg', 1.77),
(15, 'Fil de reliure', 13, 'pc', 11.62),
(16, 'Stylo/bic', 6, 'pc', 0.5),
(17, 'Alcool', 7, 'pc', 2.73),
(18, 'Porte-mine', 6, 'pc', 2.82),
(19, 'Crayon', 6, 'pc', 0.9),
(20, 'Pastel', 6, 'pc', 1),
(21, 'Craie', 6, 'pc', 0.3),
(22, 'Fusain', 6, 'pc', 0.19),
(24, 'Régle', 8, 'pc', 1),
(25, 'Équerre', 8, 'pc', 1.89),
(26, 'Rapporteur', 8, 'pc', 0.62),
(27, 'Pistolet', 8, 'pc', 3.36),
(28, 'Laser', 8, 'pc', 25.44),
(29, 'Mètre', 8, 'pc', 1.47),
(30, 'Compas', 8, 'pc', 9.9),
(31, 'Vinylique/à bois/blanche', 9, 'kg', 12.49),
(33, 'Pistolet à colle', 9, 'pc', 3.45),
(34, 'de peintre', 10, 'pc', 2.74),
(35, 'Pâte à fixe', 9, 'pc', 2.35),
(36, 'Cutter', 11, 'pc', 1.25),
(37, 'Tapis de découpe', 11, 'pc', 3),
(38, 'Ciseau', 11, 'pc', 2),
(39, 'Pince coupante', 11, 'pc', 2),
(40, 'Rogneuse', 11, 'pc', 8.5),
(162, 'Aiguille à tricoter', 13, 'pc', 1),
(42, 'Tissus', 12, 'kg', 3),
(43, 'Feutre', 12, 'kg', 5),
(51, 'Plâtre', 14, 'kg', 0.24),
(50, 'Chaux', 14, 'kg', 0.35),
(46, 'Toile peintre', 12, 'kg', 4),
(47, 'Cuir', 12, 'kg', 10),
(48, 'Moquette', 12, 'kg', 2.26),
(49, 'Fermeture éclair', 13, 'pc', 0),
(52, 'Béton', 14, 'kg', 0.08),
(53, 'Pierre', 14, 'kg', 0.12),
(57, 'Argile', 15, 'kg', 0.4),
(56, 'Carreaux', 15, 'kg', 0.37),
(58, 'Grès', 15, 'kg', 0.4),
(59, 'Porcelaine', 15, 'kg', 0.7),
(60, 'Émail', 15, 'pc', 33),
(61, 'Tour de potier', 15, 'pc', 650),
(62, 'Plaque', 16, 'kg', 3.4),
(63, 'Mirroir', 16, 'kg', 3.45),
(64, 'Fenêtre', 16, 'kg', 0),
(65, 'Soufflé', 16, 'kg', 0),
(67, 'Plexiglass', 17, 'kg', 6.11),
(68, 'Mousse', 17, 'kg', 3),
(69, 'Polystyrène/Frigolite/Sagex', 17, 'kg', 3.6),
(70, 'PVC', 17, 'kg', 8.12),
(71, 'Gélatine', 17, 'kg', 25.8),
(72, 'Forex', 17, 'kg', 4.59),
(73, 'Dibond', 17, 'kg', 11.6),
(74, 'Aquarelle', 18, 'pc', 1),
(75, 'Intérieur', 18, 'kg', 7),
(76, 'Extérieur', 18, 'kg', 7.5),
(77, 'Pigments', 18, 'pc', 39.75),
(78, 'Chassis de peinture', 18, 'pc', 1),
(79, 'Pinceau', 18, 'pc', 2),
(80, 'Foreuse', 19, 'pc', 25),
(81, 'Tournevis', 19, 'pc', 5),
(82, 'Ponceuse', 19, 'pc', 18),
(83, 'Meuleuse', 19, 'pc', 22),
(84, 'Vis', 20, 'pc', 0.05),
(85, 'Chevilles', 20, 'pc', 0.02),
(86, 'Boulons', 20, 'pc', 1),
(87, 'Roulettes', 20, 'pc', 1),
(88, 'Chaînes', 20, 'pc', 1),
(89, 'Ordinateur', 21, 'pc', 28),
(90, 'Écran', 21, 'pc', 8),
(91, 'Vidéo', 21, 'pc', 1),
(92, 'Audio', 21, 'pc', 1),
(93, 'Lampe', 21, 'pc', 1),
(94, 'Câble', 21, 'pc', 2),
(108, 'Autre', 1, 'kg', 0.9),
(109, 'Autre', 2, 'kg', 4),
(179, 'Autre', 3, 'kg', 2.75),
(178, 'Autre', 4, 'pc', 1),
(180, 'Autre', 5, 'kg', 2),
(113, 'Autre', 6, 'pc', 1),
(182, 'Autre', 7, 'pc', 1.5),
(115, 'Autre', 8, 'kg', 3),
(184, 'Autre', 9, 'kg', 7),
(185, 'Autre', 10, 'kg', 1),
(118, 'Autre', 11, 'pc', 2),
(119, 'Autre', 12, 'kg', 3),
(181, 'Autre', 13, 'pc', 1),
(183, 'Autre', 14, 'kg', 0.15),
(122, 'Autre', 15, 'kg', 0.04),
(123, 'Autre', 16, 'kg', 3),
(124, 'Autre', 17, 'kg', 6),
(186, 'Autre', 18, 'no', 1),
(127, 'Ondulé', 2, 'kg', 1.17),
(128, 'Déployé', 2, 'kg', 8.38),
(129, 'Grillage', 2, 'kg', 4.2),
(130, 'Profilé L/T/O/U', 2, 'kg', 4),
(131, 'Cable', 2, 'kg', 17.9),
(132, 'Galvanisé', 2, 'kg', 4.27),
(133, 'Impression (65-90 g/m²)', 4, 'kg', 3.47),
(134, 'Photographie (175-250 g/m²)', 4, 'kg', 28.69),
(135, 'Bristol (180 g/m²)', 4, 'kg', 18.45),
(138, 'Kraft', 4, 'kg', 6.78),
(139, 'Claque', 4, 'kg', 17.86),
(136, 'Peinture (450 g/m²)', 4, 'kg', 11.43),
(137, 'Dessin (120 g/m²)', 4, 'kg', 4.86),
(140, 'Blanc', 5, 'kg', 2),
(141, 'Ondulé', 5, 'kg', 6.88),
(142, 'Bois', 5, 'kg', 7.36),
(143, 'Mousse', 5, 'kg', 24),
(144, 'Plume', 5, 'kg', 18),
(145, 'Dessin scientifique', 7, 'pc', 1.28),
(146, 'Couleur', 7, 'pc', 0.53),
(147, 'Tableau blanc', 7, 'pc', 0.62),
(148, 'Permanent/indélébile', 7, 'pc', 0.73),
(149, 'Surligneur', 7, 'pc', 0.68),
(150, 'Posca', 7, 'pc', 1.63),
(151, 'Super Glue', 9, 'kg', 1380),
(152, 'Universelle gel', 9, 'kg', 91.5),
(153, 'Papier peint', 9, 'kg', 13.8),
(154, 'Néoprène', 9, 'kg', 12.42),
(155, 'Baton', 9, 'kg', 0.12),
(156, 'Transparent', 10, 'pc', 2),
(157, 'Double face', 10, 'pc', 3.15),
(158, 'Kraft', 10, 'pc', 4.96),
(159, 'Kraft Gommé', 10, 'pc', 4.32),
(160, 'Tissu', 10, 'pc', 3.62),
(161, 'Gaffeur', 10, 'pc', 4),
(163, 'Bouton', 13, 'pc', 0.5),
(164, 'Fil à coudre', 13, 'pc', 1),
(165, 'Fil à tricoter', 13, 'pc', 1),
(166, 'Béton cellulaire', 14, 'kg', 0.4),
(167, 'Gouache', 18, 'kg', 3.36),
(168, 'Autre', 19, 'pc', 10),
(169, 'Scie', 19, 'pc', 15),
(170, 'Autre', 20, 'pc', 0.3),
(171, 'Autre', 21, 'pc', 6),
(187, 'Autre', 22, 'pc', 20),
(172, 'Socle', 22, 'pc', 1),
(174, 'Chaise', 22, 'pc', 50),
(175, 'Table', 22, 'pc', 1),
(176, 'Vitrine', 22, 'pc', 30),
(177, 'Chevalet', 22, 'pc', 23),
(191, 'Autre', 23, 'pc', 1),
(173, 'Armoire', 22, 'pc', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bag_catalogue`
--
ALTER TABLE `bag_catalogue`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `bag_journal`
--
ALTER TABLE `bag_journal`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `cab_catalogue`
--
ALTER TABLE `cab_catalogue`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `cab_journal`
--
ALTER TABLE `cab_journal`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `fourmiliere_catalogue`
--
ALTER TABLE `fourmiliere_catalogue`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `fourmiliere_journal`
--
ALTER TABLE `fourmiliere_journal`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `gilbard_catalogue`
--
ALTER TABLE `gilbard_catalogue`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `gilbard_journal`
--
ALTER TABLE `gilbard_journal`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `_global_categories`
--
ALTER TABLE `_global_categories`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `_global_recuperatheques`
--
ALTER TABLE `_global_recuperatheques`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `_global_souscategories`
--
ALTER TABLE `_global_souscategories`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bag_catalogue`
--
ALTER TABLE `bag_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `bag_journal`
--
ALTER TABLE `bag_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `cab_catalogue`
--
ALTER TABLE `cab_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `cab_journal`
--
ALTER TABLE `cab_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT pour la table `fourmiliere_catalogue`
--
ALTER TABLE `fourmiliere_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `fourmiliere_journal`
--
ALTER TABLE `fourmiliere_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `gilbard_catalogue`
--
ALTER TABLE `gilbard_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `gilbard_journal`
--
ALTER TABLE `gilbard_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `_global_categories`
--
ALTER TABLE `_global_categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `_global_recuperatheques`
--
ALTER TABLE `_global_recuperatheques`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `_global_souscategories`
--
ALTER TABLE `_global_souscategories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
