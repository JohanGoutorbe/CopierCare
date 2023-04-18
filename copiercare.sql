-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 18 avr. 2023 à 09:48
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `copiercare`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom_client` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tel` int(10) UNSIGNED NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `interlocuteur` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `conso`
--

CREATE TABLE `conso` (
  `id` int(10) UNSIGNED NOT NULL,
  `copieur_id` int(10) UNSIGNED NOT NULL,
  `tambour_noir` int(10) UNSIGNED NOT NULL,
  `tambour_couleur` int(10) UNSIGNED NOT NULL,
  `dev_noir` int(10) UNSIGNED NOT NULL,
  `dev_couleur` int(10) UNSIGNED NOT NULL,
  `courroie` int(10) UNSIGNED NOT NULL,
  `four` int(10) UNSIGNED NOT NULL,
  `patins_dep_papier` int(10) UNSIGNED NOT NULL,
  `patins_chargeur` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `copieurs`
--

CREATE TABLE `copieurs` (
  `id` int(10) UNSIGNED NOT NULL,
  `marque` varchar(15) NOT NULL,
  `modele` varchar(25) NOT NULL,
  `date_mise_en_service` varchar(10) NOT NULL,
  `dat_fin_garantie` varchar(10) NOT NULL,
  `releve_compteur_nb` text NOT NULL,
  `releve_compteur_couleur` text NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `inters`
--

CREATE TABLE `inters` (
  `id` int(10) UNSIGNED NOT NULL,
  `num_gestco` int(10) UNSIGNED NOT NULL,
  `date` varchar(10) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `copieur_id` int(10) UNSIGNED NOT NULL,
  `tech_id` int(10) UNSIGNED NOT NULL,
  `compteur_nb` text NOT NULL,
  `compteur_couleur` text NOT NULL,
  `panne` text NOT NULL,
  `diagnostic` text NOT NULL,
  `travaux` text NOT NULL,
  `liste_pieces_changees` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rang` varchar(50) NOT NULL,
  `photo` text NOT NULL,
  `formation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conso`
--
ALTER TABLE `conso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `copieur_id` (`copieur_id`);

--
-- Index pour la table `copieurs`
--
ALTER TABLE `copieurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `inters`
--
ALTER TABLE `inters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `copieur_id` (`copieur_id`),
  ADD KEY `tech_id` (`tech_id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `conso`
--
ALTER TABLE `conso`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `copieurs`
--
ALTER TABLE `copieurs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inters`
--
ALTER TABLE `inters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `conso`
--
ALTER TABLE `conso`
  ADD CONSTRAINT `conso_ibfk_1` FOREIGN KEY (`copieur_id`) REFERENCES `copieurs` (`id`);

--
-- Contraintes pour la table `copieurs`
--
ALTER TABLE `copieurs`
  ADD CONSTRAINT `copieurs_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `inters`
--
ALTER TABLE `inters`
  ADD CONSTRAINT `inters_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `inters_ibfk_2` FOREIGN KEY (`copieur_id`) REFERENCES `copieurs` (`id`),
  ADD CONSTRAINT `inters_ibfk_3` FOREIGN KEY (`tech_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
