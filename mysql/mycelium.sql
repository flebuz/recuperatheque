-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 05 déc. 2019 à 12:09
-- Version du serveur :  5.7.23-23-log
-- Version de PHP :  7.3.6

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
(16, 2, 7, 1, '4m x 2m', 1, 'grille,  flexible', '', '2019-09-28 00:00:00', 0.1, 4, ''),
(18, 8, 49, 1, '', 1, 'rouge,  fil,  nylon,  cachemire', '', '2019-09-29 00:00:00', 0.2, 1, ''),
(21, 8, 42, 1, '', 1, 'jute, toile, decoupe, effiloché', '', '2019-09-29 10:17:40', 0.5, 0, ''),
(20, 8, 49, 1, '', 1, 'turquoise,  fil,  nylon,  bobine', '', '2019-09-29 09:43:56', 1, 1, ''),
(22, 3, 14, 1, '2m', 3, 'long, carton, craft', '', '2019-11-01 19:40:24', 1, 1.77, 'Récupérathèque'),
(23, 3, 110, 1, '', 3, 'couleur, vraiment, beaucoup, ripcolor, vert, rouge, bleu, mauve, violet, brun, orange, echantillon', '', '2019-11-03 13:50:44', 1, 2.2, '');

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
(1, 18, 125, 1, '', 1, 'dinosaure,  diplodocus,  Jésus', '', '2019-12-05 11:41:20', 600, 999, '');

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
(2, 'edit', 1, 18, 125, 1, 1, '2019-12-05 11:58:44', 600, 99, '');

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
(1, 16, 123, 1, '', 1, 'Robot,  Tordeur,  Rodriguez,  gentleman', '', '2019-12-05 11:50:36', 0, 200, '');

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
(2, 'edit', 1, 16, 123, 1, 1, '2019-12-05 11:51:16', 0, 200, '');

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
(1, 12, 119, 1, '4cm x 4cm', 1, 'attache,    flexible,    flex,    joint', 'Vendu par lot de 200. Fonction originale: équerre pour carton.', '2019-08-06 00:00:00', 0, 25, 'Rue Abbé Cuylits 44, 1070 Anderlecht'),
(2, 1, 1, 1600, '50.8cm x 2cm x 2cm', 1, 'sapin,   baguette,   tasseau,   rabotté', 'Lot à prendre dans son entièreté', '2019-08-06 00:00:00', 0, 50, ''),
(3, 18, 125, 1, '10m', 1, 'lance,  incendie,  tuyau,  rouge,  eau', 'Lance à incendie sur support raccordée à adaptateur. 10m de longueur.', '2019-08-07 00:00:00', 0, 30, ''),
(4, 17, 124, 1, '38cm x 25cm', 1, 'coussin,   bureau,   chaise,   bleu,   tissus', 'Ancien dossier de chaise de bureau.', '2019-08-08 00:00:00', 0, 15, ''),
(5, 15, 85, 20, '5mm x 250mm', 3, 'cheville, plastique, blanc', '', '2019-02-14 00:00:00', 0, 0, ''),
(6, 12, 67, 1, '50.3cm x 19.5xm', 1, 'rayé,  transparent,  translucide,  reconditionnable', '', '2019-04-02 00:00:00', 0, 1, ''),
(7, 18, 125, 10, '20cm', 1, 'blanc,  rouge,  orange,  cire,  feu', 'Lot de 10 bougies de tailles et couleurs différentes.', '2019-05-23 00:00:00', 0, 3, ''),
(8, 1, 1, 3, '181.5cm x 4.5cm x 2.3cm', 1, 'gîte,  poutre,  traité,  vert,  sapin', 'Tranches non traitées.', '2019-06-06 00:00:00', 5, 4, ''),
(9, 4, 17, 25, '', 3, 'enfant, couleur, coloriage, gallery ', 'Lot de 25.', '2019-06-17 00:00:00', 0, 0, ''),
(10, 3, 13, 1, '10.5cm x 14cm', 1, 'aurora,  carnet,  copie', 'Carnet autocopiant de 50 pages détachables.', '2019-06-17 00:00:00', 0, 15, ''),
(11, 18, 125, 1, '35cm x 35cm', 1, 'feu,  gaz,  plat,  chauffe,  alimentation', 'Chauffe plat au gaz.', '2019-07-30 00:00:00', 0, 10, 'Rue Abbé Cuylits 44, 1070 Anderlecht'),
(12, 16, 94, 7, '1m', 1, 'electrique,  alimentation,  plastique', '', '2019-03-22 00:00:00', 0, 4, ''),
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
(1, 'Bois', 18),
(2, 'Métal', 17),
(3, 'Papeterie', 15),
(4, 'Dessin et Écriture', 16),
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
(1, 'La Boite à Gants', '87, rue du Page 1050 Bruxelles, sur le plateau art.', 'Glock', '', '$2y$10$0UjV97.WnaUf3ASvvKnukuRF48DMv0F.Oy1DOjeV8BuiAga3sKwDu', 'http://erg.be/BAG/', 'bag', 'bag@erg.be', NULL),
(2, 'Gilbard', 'Rue Abbé Cuylits 44, 1070 Anderlecht', 'G', '', '$2y$10$0UjV97.WnaUf3ASvvKnukuRF48DMv0F.Oy1DOjeV8BuiAga3sKwDu', 'http://gilbard.be', 'gilbard', 'info@gilbard.be', NULL),
(3, 'La Fourmilière', '', '', '', '$2y$10$0UjV97.WnaUf3ASvvKnukuRF48DMv0F.Oy1DOjeV8BuiAga3sKwDu', '', 'fourmiliere', 'lafourmiliere.ulb@gmail.com', NULL),
(4, 'La Caverne d\'Ali Baba', '', '', '', '$2y$10$0UjV97.WnaUf3ASvvKnukuRF48DMv0F.Oy1DOjeV8BuiAga3sKwDu', '', 'cab', '', NULL);

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
(111, 'Autre', 4, 'pc', 0.75),
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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `bag_journal`
--
ALTER TABLE `bag_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cab_catalogue`
--
ALTER TABLE `cab_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `cab_journal`
--
ALTER TABLE `cab_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `fourmiliere_catalogue`
--
ALTER TABLE `fourmiliere_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `fourmiliere_journal`
--
ALTER TABLE `fourmiliere_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `gilbard_catalogue`
--
ALTER TABLE `gilbard_catalogue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `gilbard_journal`
--
ALTER TABLE `gilbard_journal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `_global_categories`
--
ALTER TABLE `_global_categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `_global_recuperatheques`
--
ALTER TABLE `_global_recuperatheques`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `_global_souscategories`
--
ALTER TABLE `_global_souscategories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
