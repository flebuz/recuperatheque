-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 03 nov. 2019 à 13:27
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
