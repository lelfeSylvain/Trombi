-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 30 Août 2016 à 07:37
-- Version du serveur :  5.5.50-MariaDB
-- Version de PHP :  5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `trombi`
--

-- --------------------------------------------------------

--
-- Structure de la table `trombi_classe`
--

CREATE TABLE `trombi_classe` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(10) NOT NULL,
  `numtrombi` bigint(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_classeur`
--

CREATE TABLE `trombi_classeur` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numuser` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_eleve`
--

CREATE TABLE `trombi_eleve` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `numclasse` bigint(20) NOT NULL,
  `numfichier` bigint(20) NOT NULL DEFAULT '0',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_fichier`
--

CREATE TABLE `trombi_fichier` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `suffixe` varchar(5) NOT NULL,
  `numtrombi` bigint(20) NOT NULL,
  `numrepertoire` bigint(20) NOT NULL,
  `type` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `numeleve` bigint(20) NOT NULL,
  `numclasseur` bigint(20) NOT NULL COMMENT 'si numtrombi est null',
  `estsupprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_parametres`
--

CREATE TABLE `trombi_parametres` (
  `num` bigint(20) NOT NULL,
  `numclasseur` bigint(20) NOT NULL,
  `numtrombi` bigint(20) NOT NULL,
  `numuser` bigint(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `orientation` varchar(1) NOT NULL,
  `cheminphoto` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `nbcol` int(11) NOT NULL,
  `nblig` int(11) NOT NULL,
  `margedroite` float NOT NULL,
  `margegauche` float NOT NULL,
  `margebas` float NOT NULL,
  `hauteurtitre` float NOT NULL,
  `hauteuretiquette` float NOT NULL,
  `margeHentrephotos` float NOT NULL,
  `margeVentrephotos` float NOT NULL,
  `largeurmin` float NOT NULL,
  `largeurmax` float NOT NULL,
  `largeurmoy` float NOT NULL,
  `hauteurmin` float NOT NULL,
  `hauteurmax` float NOT NULL,
  `hauteurmoy` float NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_repertoire`
--

CREATE TABLE `trombi_repertoire` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_trombi`
--

CREATE TABLE `trombi_trombi` (
  `num` bigint(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `numrepertoire` bigint(20) NOT NULL,
  `numclasseur` bigint(20) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_type`
--

CREATE TABLE `trombi_type` (
  `num` int(11) NOT NULL,
  `lib` varchar(20) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filtre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `trombi_user`
--

CREATE TABLE `trombi_user` (
  `num` bigint(20) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `tsDerniereCx` timestamp NULL DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nv` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `trombi_classe`
--
ALTER TABLE `trombi_classe`
  ADD PRIMARY KEY (`num`),
  ADD KEY `numtrombi` (`numtrombi`);

--
-- Index pour la table `trombi_classeur`
--
ALTER TABLE `trombi_classeur`
  ADD PRIMARY KEY (`num`),
  ADD KEY `numuser` (`numuser`);

--
-- Index pour la table `trombi_eleve`
--
ALTER TABLE `trombi_eleve`
  ADD PRIMARY KEY (`num`),
  ADD KEY `classe` (`numclasse`);

--
-- Index pour la table `trombi_fichier`
--
ALTER TABLE `trombi_fichier`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `trombi_parametres`
--
ALTER TABLE `trombi_parametres`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `trombi_repertoire`
--
ALTER TABLE `trombi_repertoire`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `trombi_trombi`
--
ALTER TABLE `trombi_trombi`
  ADD PRIMARY KEY (`num`),
  ADD KEY `numclasseur` (`numclasseur`),
  ADD KEY `numrepertoire` (`numrepertoire`);

--
-- Index pour la table `trombi_type`
--
ALTER TABLE `trombi_type`
  ADD PRIMARY KEY (`num`);

--
-- Index pour la table `trombi_user`
--
ALTER TABLE `trombi_user`
  ADD PRIMARY KEY (`num`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `trombi_classe`
--
ALTER TABLE `trombi_classe`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `trombi_classeur`
--
ALTER TABLE `trombi_classeur`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `trombi_eleve`
--
ALTER TABLE `trombi_eleve`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=342;
--
-- AUTO_INCREMENT pour la table `trombi_fichier`
--
ALTER TABLE `trombi_fichier`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;
--
-- AUTO_INCREMENT pour la table `trombi_parametres`
--
ALTER TABLE `trombi_parametres`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `trombi_repertoire`
--
ALTER TABLE `trombi_repertoire`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `trombi_trombi`
--
ALTER TABLE `trombi_trombi`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `trombi_type`
--
ALTER TABLE `trombi_type`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `trombi_user`
--
ALTER TABLE `trombi_user`
  MODIFY `num` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `trombi_classeur`
--
ALTER TABLE `trombi_classeur`
  ADD CONSTRAINT `trombi_classeur_ibfk_1` FOREIGN KEY (`numuser`) REFERENCES `trombi_user` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `trombi_trombi`
--
ALTER TABLE `trombi_trombi`
  ADD CONSTRAINT `trombi_trombi_ibfk_1` FOREIGN KEY (`numclasseur`) REFERENCES `trombi_classeur` (`num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trombi_trombi_ibfk_2` FOREIGN KEY (`numrepertoire`) REFERENCES `trombi_repertoire` (`num`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
