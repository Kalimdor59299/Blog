-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 09 fév. 2020 à 22:29
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `table1`
--

CREATE TABLE `table1` (
  `id` int(11) NOT NULL COMMENT 'Numéro de l''article',
  `titre` varchar(50) CHARACTER SET armscii8 NOT NULL COMMENT 'Titre de l''article',
  `texte` text CHARACTER SET armscii8 NOT NULL COMMENT 'Contenu de l''article',
  `date` date NOT NULL COMMENT 'Date de publication',
  `publie` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='ma première table pour un premier blog';

--
-- Déchargement des données de la table `table1`
--

INSERT INTO `table1` (`id`, `titre`, `texte`, `date`, `publie`) VALUES
(11, 'Nintendo Switch', ' Nintendo Switch avec paire de JoyCon Rouge Neon et Bleu Neon', '2019-11-22', 1),
(33, 'Ecran Asus', 'ASUS VG248QG - Ecran PC gaming eSport 24 FHD - Dalle TN - 16:9  165Hz - 0,5ms  1920x1080 - 350cd/m  DP HDMI et DVI  AMD FreeSync & Nvidia G-Sync Compatible Haut parleurs', '2019-12-06', 1),
(31, 'Clavier Roccat', 'Roccat Vulcan 120 - Clavier de Jeu Noir, gaming mecanique RGB, Retro-Eclarage LED Aimo Multicolore touche par touche, Switchs Titan, Conception Durable (Plaque Superieure en aluminium)', '2019-12-06', 1),
(30, 'Souris Roccat', 'Roccat Kone AIMO Souris Gaming (remastered) Capteur Optique OwlEye Haute Precision (de 100 a 16.000 DPI), Noire', '2019-12-06', 1),
(36, 'Ecran BenQ', 'BenQ ZOWIE XL2411P Ecran eSports Gaming de 24 pouces, 144 Hz, 1ms, Pied reglable en hauteur, Display Port, Black eQualizer, Noir Gris', '2020-02-05', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `table1`
--
ALTER TABLE `table1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `table1`
--
ALTER TABLE `table1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Numéro de l''article', AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
