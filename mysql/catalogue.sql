-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 24 juil. 2019 à 15:06
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
  `categorie` varchar(255) NOT NULL,
  `sous_categorie` varchar(255) NOT NULL,
  `nombre` int(11) NOT NULL,
  `mesure` varchar(255) NOT NULL,
  `qualite` int(11) NOT NULL,
  `tags` text NOT NULL,
  `description` text NOT NULL,
  `date_ajout` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `catalogue`
--

INSERT INTO `catalogue` (`ID`, `categorie`, `sous_categorie`, `nombre`, `mesure`, `qualite`, `tags`, `description`, `date_ajout`) VALUES
(1, 'bois', 'bois médium', 5, '2.5m', 4, 'tasseau, fin, structure', 'des longs tasseaux pas utilisés de chez brico', '2019-07-09'),
(2, 'bois', 'mdf', 12, '40cm x 32cm x 1cm', 3, 'mdf, plaques', 'plein de plaques de mdf récupérés, s’effrite un peu.', '2019-06-11'),
(3, 'plastique', 'plexiglas', 1, '2m x 1.6m', 5, 'transparent, blanc, translucide', 'super belle plaque de plexiglas, non-griffé, parfais pour découpe laser.', '2019-05-18'),
(4, 'verre', 'miroir', 1, '1.8m x 0.6m', 2, 'cassé, coupant, géométrique', 'un miroir cassé', '2019-04-02'),
(5, 'plastique', 'pvc', 12, '1m', 3, 'tube, tubular, conduit, électricité', 'des fins tubes en PVC pour fixer des câbles électriques', '2019-07-03'),
(6, 'construction', 'objet', 2, '1.2m', 4, 'néon, tube', 'tubes néons en bonne état', '2019-06-21'),
(7, 'peinture', 'peinture murale', 1, '50L', 5, 'turquoise', 'peinture murale turquoise, 3 couches', '2019-05-05');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `catalogue`
--
ALTER TABLE `catalogue` ADD FULLTEXT KEY `categorie` (`categorie`,`sous_categorie`,`mesure`,`tags`,`description`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
