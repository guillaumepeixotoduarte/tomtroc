-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 12 fév. 2026 à 16:04
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tom_troc`
--
CREATE DATABASE IF NOT EXISTS `tom_troc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tom_troc`;

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut_exchange` tinyint NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `image`, `description`, `statut_exchange`, `user_id`) VALUES
(2, 'Bleach Can\'t Fear Your Own World Part. 2', 'Tite Kubo', 'book_6984709a4f7e24.50934576.jpg', 'Roman Bleach de Tite Kubo et Ryohgo Narita', 1, 2),
(7, 'Bleach Can\'t Fear Your Own World Part. 3', 'Tite Kubo', 'book_6989d78b288c68.79115596.jpg', 'Roman Bleach de Tite Kubo et Ryohgo Narita', 0, 2),
(9, 'Bleach Can\'t Fear Your Own World Part 1', 'Tite Kubo', 'book_698df5769fb253.81272910.jpg', 'Roman Bleach', 1, 2),
(10, 'Naruto Tome 42', 'Masashi Kishimoto', 'book_698df692d5aab9.48711247.jpg', 'Manga Naruto tome 42', 1, 4),
(11, '13 Blades', 'Tite Kubo', 'book_698df6d8529cc4.30966808.jpg', 'Livre d\'informations sur les captaines de Bleach', 1, 3),
(12, 'Masked', 'Tite Kubo', 'book_698df70b121775.37420155.jpg', 'Livre d\'explication sur les Vizard Bleach', 1, 3),
(13, 'Unmasked', 'Tite Kubo', 'book_698df73691b7e8.96686854.jpg', 'Livre d\'explication sur les Arrancar Bleach', 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `created_at`) VALUES
(1, '2026-02-10 14:33:24'),
(2, '2026-02-11 14:59:33'),
(3, '2026-02-11 15:25:04');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `readed` tinyint(1) NOT NULL,
  `user_id` int NOT NULL,
  `conversation_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_conversation` (`conversation_id`),
  KEY `fk_message_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `content`, `created_at`, `readed`, `user_id`, `conversation_id`) VALUES
(1, 'Ceci est un test', '2026-02-10 14:33:24', 1, 2, 1),
(2, 'Ceci est une nouvelle conversation entre nous 2', '2026-02-11 14:59:33', 1, 4, 2),
(3, 'Et celui ci en est un autre', '2026-02-11 15:24:03', 1, 4, 2),
(4, 'Tu as pu lire les 3 tomes ?', '2026-02-11 15:25:04', 1, 3, 3),
(5, 'On va tester la longueur de la conversation', '2026-02-11 15:26:54', 1, 2, 3),
(6, 'Pour tester si on a bien le scroll', '2026-02-11 15:27:02', 1, 2, 3),
(7, 'Pour l&#039;instant le site fonctionne plutot bien, il faut juste vérifier si on les bonnes dimensions et espacement', '2026-02-11 15:27:39', 1, 2, 3),
(8, 'Le texte revient à la ligne correctement', '2026-02-11 15:27:55', 1, 2, 3),
(9, 'Pour améliorer le projet, on pourrait réaliser les requetes en ajax pour eviter l&#039;actualisation a chaque fois', '2026-02-11 15:28:20', 1, 2, 3),
(10, 'Encore un message et on va pouvoir vérifier', '2026-02-11 15:28:32', 1, 2, 3),
(11, 'je crois que ca fonctionne pas trop', '2026-02-11 15:28:41', 1, 2, 3),
(12, 'Il va falloir revoir le systeme', '2026-02-11 15:29:06', 1, 2, 3),
(13, 'Ceci est un nouveau test', '2026-02-11 16:53:45', 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `conversation_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_participant_user` (`user_id`),
  KEY `fk_participant_conversation` (`conversation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`id`, `user_id`, `conversation_id`) VALUES
(1, 2, 1),
(2, 4, 1),
(3, 4, 2),
(4, 3, 2),
(5, 3, 3),
(6, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profil_image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `profil_image`, `role`, `created_at`) VALUES
(2, 'Guillaume', '$2y$10$3lRz.5NAl3aHUGH6jAo4l..bcnttR5Rpfs3hemXyPpEWadoJ24706', 'guillaume@gmail.com', 'profil_6989dc1c5cd9d0.10311183.jpg', 'user', '2026-02-03 15:04:45'),
(3, 'Gabriel P', '$2y$10$oTJw4vE/OpR/IN4CD8ok5u/donhI/ixmOrJ4d6dt8rRBjq86xz66S', 'gabriel@gmail.com', NULL, 'user', '2026-02-06 13:14:43'),
(4, 'Jean', '$2y$10$vPyX.Qc6RIEsbi2TIzogSuOiMRVBdvmU8B/CeXeVImq4DDOctsqpu', 'jean@gmail.com', 'profil_698cb44c1bf349.67162331.jpg', 'user', '2026-02-06 14:34:37');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_livre_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`),
  ADD CONSTRAINT `fk_message_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `fk_participant_conversation` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_participant_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
