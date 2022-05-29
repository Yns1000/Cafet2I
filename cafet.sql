-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 29 mai 2022 à 21:55
-- Version du serveur : 8.0.29
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cafet`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int NOT NULL COMMENT 'Identitfiant de la transaction.',
  `id_client` int NOT NULL COMMENT 'Id du client (auteur de la commande)',
  `montant` float NOT NULL,
  `valide` tinyint NOT NULL COMMENT 'Si valide = 0, paiment non valide, si valide = 1, transaction validée',
  `livraison` tinyint NOT NULL COMMENT 'Si livraison = 0 : pas livré, si livraison = 1 : venir cherhcer, si livraison = 2 : commande terminé',
  `date_commande` date DEFAULT NULL COMMENT 'Une bonne transaction est datée !'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_unite` int NOT NULL,
  `id_panier` int NOT NULL COMMENT 'un rand',
  `id_client` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `reference` int NOT NULL COMMENT 'Référence du produit.',
  `nom_prod` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Nom du produit.',
  `prix` float NOT NULL COMMENT 'Prix du produit.',
  `quantite` int NOT NULL COMMENT 'Stock.',
  `dispo` tinyint NOT NULL COMMENT 'Produit disponible 1 / indisponible 0.',
  `categorie` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Pour ranger les produits.',
  `lien_photo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table pour referencer les stocks des produits';

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`reference`, `nom_prod`, `prix`, `quantite`, `dispo`, `categorie`, `lien_photo`) VALUES
(8, '7UP | 33cl', 1, 54, 1, 'boissons', 'ressources/Produits/7up.png'),
(9, 'COCA | 33cl', 1, 50, 1, 'boissons', 'ressources/Produits/Coca-Cola.png'),
(10, 'FANTA | 33cl', 1, 50, 1, 'boissons', 'ressources/Produits/fanta.png'),
(13, 'Kit-Kat', 1.5, 40, 1, 'confiserie', 'ressources/Produits/kisspng-chocolate-bar-kit-kat-tiramisu-white-chocolate-ice-kit-kat-5b1d1848e76372.7873874515286334169478.png'),
(85, 'Kinder Bueno', 1.5, 62, 1, 'confiserie', 'ressources/Produits/kisspng-chocolate-bar-kinder-chocolate-kinder-bueno-milk-oreo-5b4f34b0d7d2f9.461370131531917488884.png'),
(86, 'Shtroumpfs HARIBO', 1.25, 40, 0, 'confiserie', 'ressources/Produits/schtroumpfspik6_3.png'),
(88, 'Snickers', 1.3, 50, 1, 'confiserie', 'ressources/Produits/kisspng-ice-cream-mars-bounty-twix-snickers-snickers-5ab4ebd5a97d96.7971409515218062936942.png');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL COMMENT 'clé primaire, identifiant numérique auto incrémenté',
  `pseudo` varchar(20) NOT NULL COMMENT 'pseudo',
  `passe` varchar(20) NOT NULL COMMENT 'mot de passe',
  `blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est en liste noire',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est un administrateur',
  `connecte` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est connecte',
  `promo` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT 'La promo de l''utilisateur / son rôle dans l''ecole cas échéant',
  `nom` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT 'Le nom de l''étudiant',
  `prenom` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT 'Le prénom de l''étudiant',
  `NumeroTEL` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL COMMENT 'Numéro de télephone de l''étudiant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `passe`, `blacklist`, `admin`, `connecte`, `promo`, `nom`, `prenom`, `NumeroTEL`) VALUES
(3, 'RM26', 'web1', 1, 0, 0, 'LE5', 'Mahrez', 'Riyad', '0701020304'),
(4, 'Phil', 'sda1', 1, 0, 0, 'LE4', 'Foden', 'Phil', '+33612345678'),
(6, 'admin', 'admin', 0, 1, 0, 'LE3', 'root', 'x', '+33312345678'),
(29, 'YNS', 'admin', 0, 1, 0, 'LE1', 'Boughriet', 'Younes', '0766039074'),
(30, 'younes', 'aqwaqwaqw', 0, 0, 0, 'LE2', 'vdf', 'fbf', '0766039074');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_unite`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `prix` (`prix`),
  ADD KEY `id_panier` (`id_panier`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`reference`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int NOT NULL AUTO_INCREMENT COMMENT 'Identitfiant de la transaction.', AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_unite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `reference` int NOT NULL AUTO_INCREMENT COMMENT 'Référence du produit.', AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'clé primaire, identifiant numérique auto incrémenté', AUTO_INCREMENT=31;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `panier_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`reference`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `panier_ibfk_4` FOREIGN KEY (`id_panier`) REFERENCES `commandes` (`id_commande`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
