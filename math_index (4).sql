-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 avr. 2024 à 19:49
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `math_index`
--

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

CREATE TABLE `exercices` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Thematique` varchar(100) NOT NULL,
  `Difficulte` int(11) DEFAULT NULL,
  `Duree` time DEFAULT NULL,
  `MotsCles` varchar(255) DEFAULT NULL,
  `Fichier` longblob DEFAULT NULL,
  `MatiereID` int(11) DEFAULT NULL,
  `Date_Creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `exercices`
--

INSERT INTO `exercices` (`ID`, `Nom`, `Thematique`, `Difficulte`, `Duree`, `MotsCles`, `Fichier`, `MatiereID`, `Date_Creation`) VALUES
(1, 'Exo suite', 'Suites', 8, '04:00:00', 'arithmétique, base', NULL, 1, '2024-03-24 14:50:57'),
(2, 'Primitives', 'Continuité', 11, '01:00:00', 'récurrence', NULL, 2, '2024-03-24 14:50:57'),
(3, 'Continuité diverse', 'Continuité', 12, '02:00:00', 'arithmétique', NULL, 2, '2024-03-24 14:50:57'),
(4, 'Matrice à gogo', 'Matriciel', 11, '03:00:00', 'base', NULL, 3, '2024-03-24 14:50:57'),
(5, 'Exercice 1', 'Suites', 7, '01:30:00', 'arithmétique, géométrique', NULL, 1, '2024-03-24 15:51:03'),
(7, 'Exercice 1', 'Suites', 7, '01:30:00', 'arithmétique, géométrique', NULL, 1, '2024-03-24 15:51:45'),
(9, 'Exercice 6', 'Suites', 7, '01:45:00', 'arithmétique, géométrique', NULL, 1, '2024-03-24 15:55:07'),
(10, 'Exercice 7', 'Continuité', 8, '02:15:00', 'limite, continuité', NULL, 2, '2024-03-24 15:55:07'),
(11, 'Exercice 8', 'Matriciel', 9, '01:30:00', 'opérations sur les matrices', NULL, 3, '2024-03-24 15:55:07'),
(12, 'Exercice 9', 'Suites', 6, '01:00:00', 'suite arithmétique', NULL, 1, '2024-03-24 15:55:07'),
(13, 'Exercice 10', 'Continuité', 7, '02:00:00', 'continuité des fonctions', NULL, 2, '2024-03-24 15:55:07'),
(14, 'Exercice 11', 'Matriciel', 8, '01:45:00', 'déterminant, inverse', NULL, 3, '2024-03-24 15:55:07'),
(15, 'Exercice 12', 'Suites', 6, '01:30:00', 'suite géométrique', NULL, 1, '2024-03-24 15:55:07'),
(16, 'Exercice 13', 'Continuité', 8, '02:30:00', 'limite infinie, continuité', NULL, 2, '2024-03-24 15:55:07'),
(17, 'Exercice 14', 'Matriciel', 9, '02:00:00', 'transposition, multiplication', NULL, 3, '2024-03-24 15:55:07'),
(18, 'Exercice 15', 'Suites', 7, '01:15:00', 'suite arithmétique, somme', NULL, 1, '2024-03-24 15:55:07'),
(19, 'Exercice 16', 'Continuité', 8, '02:15:00', 'continuité, dérivabilité', NULL, 2, '2024-03-24 15:55:07'),
(20, 'Exercice 17', 'Matriciel', 9, '01:45:00', 'calcul matriciel, inversion', NULL, 3, '2024-03-24 15:55:07'),
(21, 'Exercice 18', 'Suites', 6, '01:00:00', 'suite géométrique, limite', NULL, 1, '2024-03-24 15:55:07'),
(22, 'Exercice 19', 'Continuité', 7, '02:00:00', 'continuité, fonction continue', NULL, 2, '2024-03-24 15:55:07'),
(23, 'Exercice 20', 'Matriciel', 8, '01:30:00', 'matrices carrées, multiplication', NULL, 3, '2024-03-24 15:55:07'),
(24, 'Exercice 21', 'Suites', 7, '01:30:00', 'suite arithmétique, somme des termes', NULL, 1, '2024-03-24 15:55:07'),
(25, 'Exercice 22', 'Continuité', 8, '02:15:00', 'continuité, dérivabilité, limite', NULL, 2, '2024-03-24 15:55:07'),
(26, 'Exercice 23', 'Matriciel', 9, '02:00:00', 'déterminant, inverse, multiplication', NULL, 3, '2024-03-24 15:55:07'),
(27, 'Exercice 24', 'Suites', 6, '01:30:00', 'suite arithmétique, limite infinie', NULL, 1, '2024-03-24 15:55:07'),
(28, 'Exercice 25', 'Continuité', 7, '02:30:00', 'continuité, fonction continue, dérivée', NULL, 2, '2024-03-24 15:55:07');

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`ID`, `Nom`, `Description`) VALUES
(1, 'Suites', 'Exercices sur les suites arithmétiques et géométriques.'),
(2, 'Continuité', 'Exercices sur la continuité des fonctions.'),
(3, 'Matriciel', 'Exercices sur les opérations matricielles.');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `niveau_droit` enum('eleve','professeur','administrateur') DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MatiereID` (`MatiereID`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `exercices`
--
ALTER TABLE `exercices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD CONSTRAINT `exercices_ibfk_1` FOREIGN KEY (`MatiereID`) REFERENCES `matieres` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
