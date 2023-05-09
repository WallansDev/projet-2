-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 09 mai 2023 à 13:01
-- Version du serveur : 8.0.33-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE gestionnaire_inventaire;
USE gestionnaire_inventaire;
--
-- Base de données : `gestionnaire_inventaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `IdStock` bigint UNSIGNED NOT NULL,
  `LibelleStock` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MarqueStock` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `QteStock` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`IdStock`, `LibelleStock`, `MarqueStock`, `QteStock`) VALUES
(1, 'Chips Poulet paprika 500g', 'lay\'s', 25),
(2, 'Chips 250g, goût Barbecue', 'lays', 4),
(3, 'Chips 250g, goût Fromage', 'vico', 2),
(4, 'Cacahuètes 150g', 'menguy\'s', 0),
(5, 'Jack Daniel\'s N.7', 'Jack Daniel\'s', 5),
(6, 'Canettes Coca-Cola', 'Coca-Cola', 20),
(7, 'Canettes Fanta', 'Fanta', 10),
(8, 'Sirop de pêche 1L', 'Menguy\'s', 2),
(20, 'Chips', 'Lay\'s', 6);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `IdUser` bigint UNSIGNED NOT NULL,
  `Username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `JobUser` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PasswordHash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`IdUser`, `Username`, `JobUser`, `PasswordHash`) VALUES
(1, 'administrateur', 'admin', '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453'),
(2, 'Yannick', 'patron', '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453'),
(3, 'Patrice', 'patron', '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453'),
(4, 'Jean', 'serveur', '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453'),
(5, 'Pierre', 'serveur', '540eda905bdfc262fbae050565c539265cd0a92391d5d2838afc4ad10027c003'),
(8, 'Michel', 'patron', '00fcdde26dd77af7858a52e3913e6f3330a32b3121a61bce915cc6145fc44453');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`IdStock`),
  ADD UNIQUE KEY `UNIQUE_LibelleStock` (`LibelleStock`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `UNQIUE_Username` (`Username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `IdStock` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `IdUser` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
