-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 06 août 2019 à 10:48
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
-- Structure de la table `catalogue`
--

DROP TABLE IF EXISTS `catalogue`;
CREATE TABLE IF NOT EXISTS `catalogue` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` int(11) NOT NULL,
  `sous_categorie` int(11) NOT NULL,
  `nombre` int(11) NOT NULL,
  `mesure` varchar(255) NOT NULL,
  `état` int(11) NOT NULL,
  `tags` text NOT NULL,
  `description` text NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `catalogue`
--

INSERT INTO `catalogue` (`ID`, `categorie`, `sous_categorie`, `nombre`, `mesure`, `état`, `tags`, `description`, `date_ajout`) VALUES
(1, 0, 0, 5, '2.5m', 4, 'tasseau, fin, structure', 'des longs tasseaux pas utilisés de chez brico', '2019-07-09'),
(2, 0, 0, 12, '40cm x 32cm x 1cm', 3, 'mdf, plaques', 'plein de plaques de mdf récupérés, s’effrite un peu.', '2019-06-11'),
(3, 0, 0, 1, '2m x 1.6m', 5, 'transparent, blanc, translucide', 'super belle plaque de plexiglas, non-griffé, parfais pour découpe laser.', '2019-05-18'),
(4, 0, 0, 1, '1.8m x 0.6m', 2, 'cassé, coupant, géométrique', 'un miroir cassé', '2019-04-02'),
(5, 0, 0, 12, '1m', 3, 'tube, tubular, conduit, électricité', 'des fins tubes en PVC pour fixer des câbles électriques', '2019-07-03'),
(6, 0, 0, 2, '1.2m', 4, 'néon, tube', 'tubes néons en bonne état', '2019-06-21'),
(7, 0, 0, 1, '50L', 5, 'turquoise', 'peinture murale turquoise, 3 couches', '2019-05-05');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`ID`, `nom`) VALUES
(1, 'Bois'),
(2, 'Métal'),
(3, 'Papeterie'),
(4, 'Dessin/Ecriture'),
(5, 'Mesure/Tracé'),
(6, 'Assemblage'),
(7, 'Découpe'),
(8, 'Textile'),
(9, 'Minéraux'),
(10, 'Céramique'),
(11, 'Verre'),
(12, 'Plastique'),
(13, 'Peinture'),
(14, 'Outils'),
(15, 'Quincaillerie'),
(16, 'Numérique'),
(17, 'Mobilier'),
(18, 'Insolite');

-- --------------------------------------------------------

--
-- Structure de la table `sous-categorie`
--

DROP TABLE IF EXISTS `sous-categorie`;
CREATE TABLE IF NOT EXISTS `sous-categorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `unite` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sous-categorie`
--

INSERT INTO `sous-categorie` (`ID`, `nom`, `ID_categorie`, `unite`) VALUES
(1, 'Massif', 1, 'kg'),
(2, 'Contreplaqué/Multiplex', 1, 'kg'),
(3, 'Aggloméré', 1, 'kg'),
(4, 'OSB', 1, 'kg'),
(5, 'MDF', 1, 'kg'),
(6, 'Balsa', 1, 'kg'),
(7, 'Acier', 2, 'kg'),
(8, 'Laiton', 2, 'kg'),
(9, 'Aluminium', 2, 'kg'),
(10, 'Plomb', 2, 'kg'),
(11, 'Zinc', 2, 'kg'),
(12, 'Or', 2, 'kg'),
(13, 'Papier', 3, 'kg'),
(14, 'Carton', 3, 'kg'),
(15, 'Fil de reliure', 3, 'pc'),
(16, 'Stylo', 4, 'pc'),
(17, 'Feutre', 4, 'pc'),
(18, 'Porte-mine', 4, 'pc'),
(19, 'Crayon', 4, 'pc'),
(20, 'Pastel', 4, 'pc'),
(21, 'Craie', 4, 'pc'),
(22, 'Fusain', 4, 'pc'),
(23, 'Accessoire', 4, 'pc'),
(24, 'Régle', 5, 'pc'),
(25, 'Équerre', 5, 'pc'),
(26, 'Rapporteur', 5, 'pc'),
(27, 'Pistolet', 5, 'pc'),
(28, 'Laser', 5, 'pc'),
(29, 'Mètre ruban', 5, 'pc'),
(30, 'Compas', 5, 'pc'),
(31, 'Colle', 6, 'pc'),
(33, 'Pistolet à colle', 6, 'pc'),
(34, 'Ruban adhésif', 6, 'pc'),
(35, 'Pâte à fixe', 6, 'pc'),
(36, 'Cutter', 7, 'pc'),
(37, 'Tapis de découpe', 7, 'pc'),
(38, 'Ciseau', 7, 'pc'),
(39, 'Pince coupante', 7, 'pc'),
(40, 'Rogneuse', 7, 'pc'),
(41, 'Scie', 7, 'pc'),
(42, 'Tissus', 8, 'kg'),
(43, 'Feutre', 8, 'kg'),
(51, 'Plâtre', 9, 'kg'),
(50, 'Chaux', 9, 'kg'),
(46, 'Toile peintre', 8, 'kg'),
(47, 'Cuir', 8, 'kg'),
(48, 'Fil', 8, 'pc'),
(49, 'Mercerie', 8, 'pc'),
(52, 'Béton', 9, 'kg'),
(53, 'Pierre', 9, 'kg'),
(57, 'Argile', 10, 'kg'),
(56, 'Carreaux', 10, 'kg'),
(58, 'Grès', 10, 'kg'),
(59, 'Porcelaine', 10, 'kg'),
(60, 'Émail', 10, 'pc'),
(61, 'Tour de potier', 10, 'pc'),
(62, 'Plaque', 11, 'kg'),
(63, 'Mirroir', 11, 'kg'),
(64, 'Fenêtre', 11, 'kg'),
(65, 'Soufflé', 11, 'kg'),
(66, 'Bakélite', 12, 'kg'),
(67, 'Plexiglass', 12, 'kg'),
(68, 'Mousse', 12, 'kg'),
(69, 'Polystyrène/Frigolite/Sagex', 12, 'kg'),
(70, 'PVC', 12, 'kg'),
(71, 'Gélatine', 12, 'kg'),
(72, 'Forex', 12, 'kg'),
(73, 'Dibond', 12, 'kg'),
(74, 'Aquarelle', 13, 'pc'),
(75, 'Intérieur', 13, 'kg'),
(76, 'Extérieur', 13, 'kg'),
(77, 'Pigments', 13, 'pc'),
(78, 'Chassis de peinture', 13, 'pc'),
(79, 'Pinceau', 13, 'pc'),
(80, 'Visseuse', 14, 'pc'),
(81, 'Tournevis', 14, 'kg'),
(82, 'Ponceuse', 14, 'pc'),
(83, 'Meuleuse', 14, 'pc'),
(84, 'Vis', 15, 'pc'),
(85, 'Chevilles', 15, 'pc'),
(86, 'Boulons', 15, 'pc'),
(87, 'Roulettes', 15, 'pc'),
(88, 'Chaînes', 15, 'pc'),
(89, 'Ordinateur', 16, 'pc'),
(90, 'Écran', 16, 'pc'),
(91, 'Vidéo', 16, 'pc'),
(92, 'Audio', 16, 'pc'),
(93, 'Micro controleur/Micro ordinateur', 16, 'pc'),
(94, 'Cable', 16, 'pc');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
