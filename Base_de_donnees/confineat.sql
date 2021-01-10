-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 02 jan. 2021 à 16:44
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `alik0002_confint`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `idAddress` int(11) NOT NULL COMMENT 'Identifiant Adresse',
  `idUser` int(11) NOT NULL DEFAULT 1 COMMENT 'Identifiant Utilisateur',
  `street` varchar(40) DEFAULT NULL COMMENT 'Rue',
  `addr_compl` varchar(40) DEFAULT NULL COMMENT 'Complément Adresse Utilisateur',
  `pos_code` char(5) DEFAULT NULL COMMENT 'Code Postal',
  `city` varchar(100) DEFAULT NULL COMMENT 'Ville',
  `latitude` float DEFAULT NULL COMMENT 'latitude',
  `longitude` float DEFAULT NULL COMMENT 'longitude'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`idAddress`, `idUser`, `street`, `addr_compl`, `pos_code`, `city`, `latitude`, `longitude`) VALUES
(1, 1, '132 rue gambetta', NULL, '51100', 'Reims', NULL, NULL),
(2, 2, '11 Rue Gaston Boyer', NULL, '51100', 'Reims', NULL, NULL),
(5, 5, '84 Rue Gambetta', NULL, '51100', 'Reims', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `basket`
--

CREATE TABLE `basket` (
  `idBasket` int(11) NOT NULL COMMENT 'Identifiant Panier',
  `idUser` int(11) NOT NULL DEFAULT 1 COMMENT 'Identifiant Utilisateur',
  `completed` tinyint(1) DEFAULT NULL COMMENT 'Complet',
  `delivered` tinyint(1) DEFAULT NULL COMMENT 'Livré',
  `price` int(11) DEFAULT 0 COMMENT 'Prix',
  `dateCompleted` date DEFAULT NULL COMMENT 'Date de commande'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `basket`
--

INSERT INTO `basket` (`idBasket`, `idUser`, `completed`, `delivered`, `price`, `dateCompleted`) VALUES
(1, 1, 0, 0, 0, NULL),
(2, 2, 0, 0, 0, NULL),
(5, 5, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `composition`
--

CREATE TABLE `composition` (
  `idMenu` int(11) NOT NULL COMMENT 'Identifiant Menu',
  `idItem` int(11) NOT NULL COMMENT 'Identifiant Article'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `composition`
--

INSERT INTO `composition` (`idMenu`, `idItem`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(5, 17),
(5, 18),
(5, 19),
(5, 20),
(6, 6),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(7, 3),
(7, 7),
(7, 8),
(7, 15),
(7, 16),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 14),
(8, 17),
(8, 18),
(8, 19),
(8, 20),
(8, 27),
(8, 28),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(9, 23),
(9, 24),
(9, 25),
(9, 26),
(9, 27),
(9, 28),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(11, 13),
(11, 17),
(11, 18),
(11, 19),
(11, 20),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 17),
(12, 18),
(12, 19),
(12, 20),
(16, 1),
(16, 2),
(16, 11),
(16, 17),
(16, 23),
(16, 28),
(20, 1),
(20, 2),
(20, 3);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `idItem` int(11) NOT NULL COMMENT 'Identifiant Article',
  `name` varchar(100) NOT NULL COMMENT 'Nom',
  `price` float DEFAULT NULL COMMENT 'Prix',
  `type` int(11) DEFAULT NULL COMMENT 'Type : 0 groupe 1 plat 2 boisson 3 dessert ',
  `quantity` int(11) DEFAULT 100 COMMENT 'Quantité disponible en stock',
  `imgPath` varchar(255) NOT NULL COMMENT 'URL image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`idItem`, `name`, `price`, `type`, `quantity`, `imgPath`) VALUES
(1, 'cheese bacon burger', 4, 1, 98, 'view/img/images/Plat/Burger/cheese_bacon_burger.jpg'),
(2, 'cheesy burger', 4, 1, 99, 'view/img/images/Plat/Burger/cheesy_burger.jpg'),
(3, 'chicken burger', 4, 1, 99, 'view/img/images/Plat/Burger/chicken_burger.jpg'),
(4, 'double steak burger', 4, 1, 99, 'view/img/images/Plat/Burger/double_steak_burger.jpg'),
(5, 'panini cheese', 4, 1, 100, 'view/img/images/Plat/Panini/panini_cheese.jpeg'),
(6, 'panini jambon', 4, 1, 100, 'view/img/images/Plat/Panini/panini_jambon.png'),
(7, 'panini bacon', 4, 1, 100, 'view/img/images/Plat/Panini/panini_bacon.png'),
(8, 'panini poulet', 4, 1, 100, 'view/img/images/Plat/Panini/panini_poulet.png'),
(9, 'salade compose', 4, 1, 100, 'view/img/images/Plat/Salade/salade_compose.jpg'),
(10, 'salade nicoise', 4, 1, 100, 'view/img/images/Plat/Salade/salade_nicoise.jpg'),
(11, 'salade poulet', 4, 1, 100, 'view/img/images/Plat/Salade/salade_poulet.jpg'),
(12, 'salade végétarienne', 4, 1, 100, 'view/img/images/Plat/Salade/salade_vegetarienne.png'),
(13, 'sandwich parisien', 4, 1, 100, 'view/img/images/Plat/Sandwich/sandwich_parisien.jpg'),
(14, 'sandwich americain', 4, 1, 100, 'view/img/images/Plat/Sandwich/sandwich_americain.jpg'),
(15, 'sandwich poulet crudités', 4, 1, 100, 'view/img/images/Plat/Sandwich/sandwich_poulet_crudités.jpg'),
(16, 'sandwich thon mayonnaise', 4, 1, 100, 'view/img/images/Plat/Sandwich/sandwich_thon_mayonnaise.jpg'),
(17, 'coca', 1.5, 2, 99, 'view/img/images/Boissons/coca.jpg'),
(18, 'evian', 1.5, 2, 100, 'view/img/images/Boissons/evian.jpg'),
(19, 'oasis', 1.5, 2, 99, 'view/img/images/Boissons/oasis.jpg'),
(20, 'orangina', 1.5, 2, 0, 'view/img/images/Boissons/orangina.jpg'),
(21, 'fondant chocolat', 2.5, 3, 99, 'view/img/images/Dessert/fondant_chocolat.jpg'),
(22, 'mille feuilles nature', 2.5, 3, 99, 'view/img/images/Dessert/mille_feuilles_nature.jpg'),
(23, 'capuccino', 2.5, 3, 100, 'view/img/images/Dessert/capuccino.jpg'),
(24, 'verrines fraises', 2.5, 3, 100, 'view/img/images/Dessert/verrines_fraises.jpg'),
(25, 'creme glace chocolat', 2.5, 3, 100, 'view/img/images/Dessert/creme_glace_chocolat.jpg'),
(26, 'parfait caramel', 2.5, 3, 100, 'view/img/images/Dessert/parfait_caramel.jpg'),
(27, 'petite salade', 2.5, 4, 100, 'view/img/images/plat/salade/petite_salade.jpg'),
(28, 'onion rings', 1.5, 4, 100, 'view/img/images/plat/onion_rings.png');

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `idBasket` int(11) NOT NULL COMMENT 'Identifiant Liste',
  `idMenu` int(11) NOT NULL COMMENT 'Identifiant Menu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `list`
--

INSERT INTO `list` (`idBasket`, `idMenu`) VALUES
(1, 16),
(5, 20);

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL COMMENT 'Identifiant Menu',
  `name` varchar(100) NOT NULL COMMENT 'Nom',
  `price` float DEFAULT NULL COMMENT 'Prix',
  `imgPath` varchar(255) NOT NULL COMMENT 'URL image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menu`
--

INSERT INTO `menu` (`idMenu`, `name`, `price`, `imgPath`) VALUES
(1, 'burgers', 0, 'view/img/plat_burger.png'),
(2, 'paninis', 0, 'view/img/plat_panini.jpeg'),
(3, 'salades', 0, 'view/img/plat_salade.jpg'),
(4, 'sandwichs', 0, 'view/img/plat_sandwich.jpeg'),
(5, 'boissons', 0, 'view/img/boissons_main.jpg'),
(6, 'desserts', 0, 'view/img/dessert_main.jpg'),
(7, 'Menu Etudiant', 6, 'view/img/menu/etudiant.jpg'),
(8, 'Menu Duo', 12.5, 'view/img/menu/duo.jpg'),
(9, 'Menu Full', 13.5, 'view/img/menu/full.jpg'),
(10, 'Menu Salade', 7.5, 'view/img/menu/salade.png'),
(11, 'Menu Light', 5.5, 'view/img/menu/light.png\r\n'),
(12, 'Menu Burger', 8.5, 'view/img/menu/burger.png'),
(16, 'Menu Personnalisé', 0, ''),
(18, 'Menu Personnalisé', 0, ''),
(20, 'Menu Personnalisé', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL COMMENT 'Identifiant Utilisateur',
  `firstname` varchar(30) DEFAULT NULL COMMENT 'Prenom',
  `lastname` varchar(30) DEFAULT NULL COMMENT 'Nom',
  `email` varchar(30) DEFAULT NULL COMMENT 'Email',
  `phone` char(10) DEFAULT NULL COMMENT 'Téléphone',
  `password` varchar(255) DEFAULT NULL COMMENT 'Mot de passe',
  `card` varchar(255) DEFAULT NULL COMMENT 'Numéro de carte bancaire',
  `userLevel` int(11) DEFAULT NULL COMMENT 'Niveau'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `firstname`, `lastname`, `email`, `phone`, `password`, `card`, `userLevel`) VALUES
(1, 'test', 'test', 'test@test.com', '578747585', 'ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff', NULL, 1),
(2, 'titi', 'titi', 'titi@titi.com', '247854125', '880a1b018a8d4b2585ee55fe1ff4da75d5f8ffaf8002cba3a65fb54a46728f9903e9ff243336f12baf3089a4244ec53fa0484380b8b35f85128de5e34f94e96c', '56d01c4d1a698e26ac99eefdd77b9e98f1b909b407282830e8dffc18fb99f2159a44a1059f08c53e9bba17bc7695f35c720a207643dc8a11f7f93e470936b0f3', 2),
(5, 'Jean ', 'Luc', 'jeanluc@gmail.com', '0245785412', '7be02f49ebfe0f90c786d50fe5461f4e58c565896209e16068d389d51ddbf419e59f1c1328813e857494728851ede2eda18fa0d757fedaefe9b1affd13de907e', '56d01c4d1a698e26ac99eefdd77b9e98f1b909b407282830e8dffc18fb99f2159a44a1059f08c53e9bba17bc7695f35c720a207643dc8a11f7f93e470936b0f3', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`idAddress`) COMMENT 'Clé primaire Adresse',
  ADD KEY `FK_ADDR` (`idUser`);

--
-- Index pour la table `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`idBasket`) COMMENT 'Clé primaire Panier ',
  ADD KEY `FK_Basket` (`idUser`);

--
-- Index pour la table `composition`
--
ALTER TABLE `composition`
  ADD PRIMARY KEY (`idMenu`,`idItem`) COMMENT 'Clé primaire Composition',
  ADD KEY `FK_COMP_ITEM` (`idItem`),
  ADD KEY `FK_COMP_MENU` (`idMenu`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`idItem`) COMMENT 'Clé primaire Article';

--
-- Index pour la table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`idBasket`,`idMenu`) COMMENT 'Clé primaire Liste',
  ADD KEY `FK_LIST_MENU` (`idMenu`),
  ADD KEY `FK_LIST_BASKET` (`idBasket`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`) COMMENT 'Clé primaire Menu';

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`) COMMENT 'Clé primaire Utilisateur';

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `idAddress` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Adresse', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `basket`
--
ALTER TABLE `basket`
  MODIFY `idBasket` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Panier', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Article', AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Menu', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Utilisateur', AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_ADDR` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Contraintes pour la table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `FK_Basket` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Contraintes pour la table `composition`
--
ALTER TABLE `composition`
  ADD CONSTRAINT `FK_COMP_ITEM` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COMP_MENU` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE CASCADE;

--
-- Contraintes pour la table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `FK_LIST_BASKET` FOREIGN KEY (`idBasket`) REFERENCES `basket` (`idBasket`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_LIST_MENU` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
