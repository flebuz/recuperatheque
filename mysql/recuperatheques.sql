-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 01 sep. 2019 à 17:55
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
  `ID_categorie` int(11) NOT NULL,
  `ID_souscategorie` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `dimensions` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `tags` text NOT NULL,
  `remarques` text NOT NULL,
  `date_ajout` date NOT NULL,
  `poids` float NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `catalogue`
--

INSERT INTO `catalogue` (`ID`, `ID_categorie`, `ID_souscategorie`, `pieces`, `dimensions`, `etat`, `tags`, `remarques`, `date_ajout`, `poids`, `prix`) VALUES
(1, 12, 119, 3200, '4cm x 4cm', 3, 'attache, flexible, flex, joint', 'Lot. Fonction originale: équerre pour carton. A partir de 200 pièces.', '2019-08-06', 0, 0),
(2, 1, 1, 1600, '50.8cm x 2cm x 2cm', 5, 'sapin, baguette, tasseau, rabotté', 'Lot à prendre dans son entièretée', '2019-08-06', 0, 0),
(3, 18, 125, 1, '10m', 3, 'lance, incendie, tuyau, rouge, eau', 'Lance à incendie sur support raccordée à adaptateur. 10m de longueur.', '2019-08-07', 0, 0),
(4, 17, 124, 1, '38cm x 25cm', 2, 'coussin, bureau, chaise, bleu, tissus', 'Ancien dossier de chaise de bureau.', '2019-08-08', 0, 0),
(5, 15, 85, 20, '5mm x 250mm', 4, 'cheville, plastique, blanc', '', '2019-02-14', 0, 0),
(6, 12, 67, 1, '50.3cm x 19.5xm', 2, 'rayé, transparent, translucide, reconditionnable', '', '2019-04-02', 0, 0),
(7, 18, 125, 10, '20cm', 4, 'blanc, rouge, orange, cire, feu', 'Lot de 10 bougies de tailles et couleurs différentes.', '2019-05-23', 0, 0),
(8, 1, 1, 3, '181.5cm x 4.5cm x 2.3cm', 3, 'gîte, poutre, traité, vert, sapin', 'Tranches non traitées.', '2019-06-06', 0, 0),
(9, 4, 17, 25, '', 3, 'enfant, couleur, coloriage, gallery ', 'Lot de 25.', '2019-06-17', 0, 0),
(10, 3, 13, 1, '10.5cm x 14cm', 4, 'aurora, carnet, copie', 'Carnet autocopiant de 50 pages détachables.', '2019-06-17', 0, 0),
(11, 18, 125, 1, '35cm x 35cm', 3, 'feu, gaz, plat, chauffe, alimentation', 'Chauffe plat au gaz.', '2019-07-30', 0, 0),
(12, 16, 94, 7, '1m', 4, 'electrique, alimentation, plastique', '', '2019-03-22', 0, 0),
(13, 15, 86, 2, '15cm x 8cm x 8cm', 3, 'grand, oversized, attache, metal', '', '2019-03-20', 0, 0),
(14, 8, 115, 12, '50cm x 50cm', 2, 'carpette, épais, carré, bleu, paillaisson, tapis', 'Carrés de carpettes de 2 coloris différents.', '2019-06-20', 0, 0);

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
-- Structure de la table `souscategorie`
--

DROP TABLE IF EXISTS `souscategorie`;
CREATE TABLE IF NOT EXISTS `souscategorie` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `ID_categorie` int(11) NOT NULL,
  `unite` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `souscategorie`
--

INSERT INTO `souscategorie` (`ID`, `nom`, `ID_categorie`, `unite`) VALUES
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
(94, 'Cable', 16, 'pc'),
(108, 'Autre', 1, 'no'),
(109, 'Autre', 2, 'no'),
(110, 'Autre', 3, 'no'),
(111, 'Autre', 4, 'no'),
(112, 'Autre', 5, 'no'),
(113, 'Autre', 6, 'no'),
(114, 'Autre', 7, 'no'),
(115, 'Autre', 8, 'no'),
(116, 'Autre', 9, 'no'),
(117, 'Autre', 10, 'no'),
(118, 'Autre', 11, 'no'),
(119, 'Autre', 12, 'no'),
(120, 'Autre', 13, 'no'),
(121, 'Autre', 14, 'no'),
(122, 'Autre', 15, 'no'),
(123, 'Autre', 16, 'no'),
(124, 'Autre', 17, 'no'),
(125, 'Autre', 18, 'no');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
