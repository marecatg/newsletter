-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 14 Mars 2017 à 12:54
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `newsletter`
--

-- --------------------------------------------------------

--
-- Structure de la table `campagne`
--

CREATE TABLE `campagne` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_lancement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contenu_newsletter`
--

CREATE TABLE `contenu_newsletter` (
  `id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `date_modification` date DEFAULT NULL,
  `contenu_html` longtext COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `contenu_newsletter`
--

INSERT INTO `contenu_newsletter` (`id`, `newsletter_id`, `date_modification`, `contenu_html`, `nom`) VALUES
(1, 1, NULL, '<h1>TEST</h1>', 'Newsletter test'),
(2, 1, NULL, '<h1>TEST 2</h1>', 'Newsletter test');

-- --------------------------------------------------------

--
-- Structure de la table `destinataire`
--

CREATE TABLE `destinataire` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `destinataire`
--

INSERT INTO `destinataire` (`id`, `email`, `actif`, `nom`, `prenom`) VALUES
(1, 'test@test.com', 1, '', ''),
(2, 'zerzrzt@gmail.com', 1, 'qsdq', 'qsdqd'),
(4, 'zerez@email.com', 1, 'zerzr', 'fze'),
(5, 'zaaze@mail', 1, 'zerz', 'zer'),
(6, 'zezrr@mail.com', 1, 'zerz', 'ezrz'),
(7, 'zadzqd@m', 1, 'zer', 'zerz'),
(8, 'zadzqd@m', 1, 'zer', 'zerz'),
(9, 'zerzr@mail', 1, 'zerezrz', 'qzee'),
(10, 'zerzr@mail', 1, 'zerezrz', 'qzee'),
(11, 'zerzr@mail', 1, 'zerezrz', 'qzee'),
(12, 'zerzr@mail', 1, 'zerezrz', 'qzee'),
(13, 'ertet@mail.com', 1, 'ert', 'erte'),
(14, 'ertet@mail.com', 1, 'ert', 'erte'),
(15, 'ertet@mail.com', 1, 'ert', 'erte'),
(16, 'rete@mail.com', 1, 'erte', 'ert'),
(17, 'AAA@mail.com', 1, 'AAAA', 'AAAA'),
(18, 'azeza@mail.com', 1, 'azeaee', 'azeaez'),
(19, 'BB@mail', 1, 'BBB', 'BBB'),
(20, 'mlkjglg@mail.com', 1, 'hqsd', 'ytqfdyt'),
(21, 'MMM@mail.com', 1, 'mlgfg', 'MMM'),
(22, 'vbvcbdfbfdg@mail.com', 1, 'dfgd', 'ggdfgdfd'),
(23, 'adlezr@mail.com', 1, 'sùgkvv', 'sdfjb'),
(24, 'vcdmflkgd@mail.com', 1, 'fgd', 'sgdfg'),
(25, 'mplmflkgd@mail.com', 1, 'fgd', 'sgdfg'),
(26, 'kldkf@mail.com', 1, 'qsdqsd', 'qsdqd'),
(27, 'bvbdpger@mail.com', 1, 'dgfd', 'dfgdg'),
(28, 'lkefsf@mail.com', 1, 'fgdg', 'zer'),
(29, 'kfsfefs@mail.com', 1, 'sdfs', 'azerea'),
(30, 'toto@mail.com', 1, 'TOTO', 'TOTO');

-- --------------------------------------------------------

--
-- Structure de la table `destinataire_liste_diffusion`
--

CREATE TABLE `destinataire_liste_diffusion` (
  `destinataire_id` int(11) NOT NULL,
  `liste_diffusion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `destinataire_liste_diffusion`
--

INSERT INTO `destinataire_liste_diffusion` (`destinataire_id`, `liste_diffusion_id`) VALUES
(1, 1),
(2, 1),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 2),
(9, 2),
(10, 1),
(11, 1),
(13, 1),
(16, 2),
(17, 1),
(17, 2),
(18, 1),
(19, 1),
(21, 1),
(30, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `destinataire_id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `campagne_source` int(11) DEFAULT NULL,
  `liste_diffusion_source` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liste_diffusion`
--

CREATE TABLE `liste_diffusion` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `liste_diffusion`
--

INSERT INTO `liste_diffusion` (`id`, `nom`) VALUES
(1, 'Liste 1'),
(2, 'Liste 2');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `date_prochain_envoi` date DEFAULT NULL,
  `periodicite_unite` enum('jour','semaine','mois','annee') COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodicite_valeur` int(11) NOT NULL,
  `createur_id` int(11) NOT NULL,
  `campagne_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `date_prochain_envoi`, `periodicite_unite`, `periodicite_valeur`, `createur_id`, `campagne_id`) VALUES
(1, NULL, 'annee', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `email`, `nom`, `prenom`, `username_canonical`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1, 'root', 'gaetan.marecat@epsi.fr', 'John', 'Root', 'root', 'gaetan.marecat@epsi.fr', 1, 'l6pyec7se6840g8c4ss40gwg000o4o8', '$2y$13$l6pyec7se6840g8c4ss40eXD2NRO46FB0CzsWh62N8mBAFNFFbDSC', '2017-03-14 12:44:05', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `campagne`
--
ALTER TABLE `campagne`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contenu_newsletter`
--
ALTER TABLE `contenu_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7C197F5522DB1917` (`newsletter_id`);

--
-- Index pour la table `destinataire`
--
ALTER TABLE `destinataire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `destinataire_liste_diffusion`
--
ALTER TABLE `destinataire_liste_diffusion`
  ADD PRIMARY KEY (`destinataire_id`,`liste_diffusion_id`),
  ADD KEY `IDX_58874234A4F84F6E` (`destinataire_id`),
  ADD KEY `IDX_588742346E6D126D` (`liste_diffusion_id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5E90F6D6A4F84F6E` (`destinataire_id`),
  ADD KEY `IDX_5E90F6D622DB1917` (`newsletter_id`);

--
-- Index pour la table `liste_diffusion`
--
ALTER TABLE `liste_diffusion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7E8585C873A201E5` (`createur_id`),
  ADD KEY `IDX_7E8585C816227374` (`campagne_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B392FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_1D1C63B3A0D96FBF` (`email_canonical`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `campagne`
--
ALTER TABLE `campagne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `contenu_newsletter`
--
ALTER TABLE `contenu_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `destinataire`
--
ALTER TABLE `destinataire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `liste_diffusion`
--
ALTER TABLE `liste_diffusion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenu_newsletter`
--
ALTER TABLE `contenu_newsletter`
  ADD CONSTRAINT `FK_7C197F5522DB1917` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletter` (`id`);

--
-- Contraintes pour la table `destinataire_liste_diffusion`
--
ALTER TABLE `destinataire_liste_diffusion`
  ADD CONSTRAINT `FK_588742346E6D126D` FOREIGN KEY (`liste_diffusion_id`) REFERENCES `liste_diffusion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_58874234A4F84F6E` FOREIGN KEY (`destinataire_id`) REFERENCES `destinataire` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D622DB1917` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletter` (`id`),
  ADD CONSTRAINT `FK_5E90F6D6A4F84F6E` FOREIGN KEY (`destinataire_id`) REFERENCES `destinataire` (`id`);

--
-- Contraintes pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `FK_7E8585C816227374` FOREIGN KEY (`campagne_id`) REFERENCES `campagne` (`id`),
  ADD CONSTRAINT `FK_7E8585C873A201E5` FOREIGN KEY (`createur_id`) REFERENCES `utilisateur` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
