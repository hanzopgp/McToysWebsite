-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 20 nov. 2020 à 09:11
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cc`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `auteur` int(3) NOT NULL,
  `jouet` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_USER` (`auteur`),
  KEY `FK_JOUET` (`jouet`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `message`, `date`, `auteur`, `jouet`) VALUES
(1, 'J\'adore ce jouet ! Que de bons souvenirs :)', '2020-11-20 08:31:04', 1, 1),
(2, 'Impossible d\'oublier ce bon vieux Bruce Wayne qui se retrouvait chaque année au pied du sapin ...', '2020-11-20 08:31:55', 1, 2),
(3, 'Ils sont mignons (sans mauvais jeu de mots haha)', '2020-11-20 08:34:26', 2, 3),
(4, 'dede', '2020-11-20 08:43:30', 2, 3),
(5, 'Merci ! Moi aussi je l\'aime bien !', '2020-11-20 08:46:42', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jouet`
--

DROP TABLE IF EXISTS `jouet`;
CREATE TABLE IF NOT EXISTS `jouet` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `user` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_JOUET_USER` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jouet`
--

INSERT INTO `jouet` (`id`, `nom`, `image`, `date`, `user`) VALUES
(1, 'Superman', '5fb77e4db7d5e.jpeg', '2003-11-01', 2),
(2, 'Batman', '5fb77e71b42c6.jpeg', '2004-10-06', 2),
(3, 'Les Mignons', '5fb77ead6e236.jpeg', '2010-07-06', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `username`, `mdp`, `role`) VALUES
(1, 'Vanier', 'Pascal', 'vanier', '$2y$10$89Zj5LomWWx8eXk3rZ.gFu8v8tcxtYTbhb.RxwdN2nv4qg8cdLCbu', 0),
(2, 'Lecarpentier', 'Jean-Marc', 'lecarpentier', '$2y$10$UYR7fT8wBxcEKNLNn/lHiudMoDVf6SzVw.xU1Olty8VfwfUqUoxCy', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_JOUET` FOREIGN KEY (`jouet`) REFERENCES `jouet` (`id`),
  ADD CONSTRAINT `FK_USER` FOREIGN KEY (`auteur`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `jouet`
--
ALTER TABLE `jouet`
  ADD CONSTRAINT `FK_JOUET_USER` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
