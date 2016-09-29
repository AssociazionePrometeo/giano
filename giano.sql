-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Set 30, 2016 alle 00:31
-- Versione del server: 10.1.16-MariaDB
-- Versione PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giano`
--
CREATE DATABASE IF NOT EXISTS `giano` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `giano`;

-- --------------------------------------------------------

--
-- Struttura della tabella `devices`
--

CREATE TABLE `devices` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `devices`
--

INSERT INTO `devices` (`id`, `name`, `active`, `type`) VALUES
(1, 'Ingresso', 1, 1),
(2, 'Sala Riunioni', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `log`
--

CREATE TABLE `log` (
  `id` int(25) NOT NULL,
  `userid` int(225) NOT NULL,
  `cardcode` text NOT NULL,
  `date_log` datetime NOT NULL,
  `devicelog` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `permissions` enum('0','1') NOT NULL DEFAULT '0',
  `insert_devices` enum('0','1') NOT NULL DEFAULT '0',
  `insert_tags` enum('0','1') NOT NULL DEFAULT '0',
  `insert_users` enum('0','1') NOT NULL DEFAULT '0',
  `delete_devices` enum('0','1') NOT NULL DEFAULT '0',
  `delete_tags` enum('0','1') NOT NULL DEFAULT '0',
  `delete_users` enum('0','1') NOT NULL DEFAULT '0',
  `insert_reservation` enum('0','1') NOT NULL DEFAULT '0',
  `delete_reservation` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `permissions`, `insert_devices`, `insert_tags`, `insert_users`, `delete_devices`, `delete_tags`, `delete_users`, `insert_reservation`, `delete_reservation`) VALUES
(1, 'admin', '1', '1', '1', '1', '1', '1', '1', '1', '1'),
(2, 'manager', '0', '1', '1', '1', '0', '0', '0', '1', '1'),
(3, 'user', '0', '0', '0', '0', '0', '0', '0', '1', '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `deviceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `from_time` timestamp NULL DEFAULT NULL,
  `to_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `system`
--

CREATE TABLE `system` (
  `site name` mediumtext NOT NULL,
  `site url` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE `tags` (
  `id` int(25) NOT NULL,
  `cardcode` text NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `status` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`id`, `cardcode`, `userid`, `status`) VALUES
(1, '112314', 1, 1),
(2, '4324', 3, 1),
(3, '47beet', 2, 1),
(4, '47beeb', 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `type_device`
--

CREATE TABLE `type_device` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `type_device`
--

INSERT INTO `type_device` (`id`, `name`) VALUES
(1, 'Porta');

-- --------------------------------------------------------

--
-- Struttura della tabella `type_user`
--

CREATE TABLE `type_user` (
  `id` int(11) NOT NULL,
  `level` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `type_user`
--

INSERT INTO `type_user` (`id`, `level`) VALUES
(1, 'administrator'),
(2, 'manager'),
(3, 'user');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `userid` int(25) NOT NULL,
  `first_name` varchar(25) NOT NULL DEFAULT '',
  `email_address` varchar(25) DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `PASSWORD` varchar(255) NOT NULL DEFAULT '',
  `info` text,
  `user_level` int(11) NOT NULL DEFAULT '3',
  `mobile_number` text NOT NULL,
  `signup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` date NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Membership Information';

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`userid`, `first_name`, `email_address`, `username`, `PASSWORD`, `info`, `user_level`, `mobile_number`, `signup_date`, `end_date`, `last_login`, `activated`) VALUES
(1, 'admin', 'admin@fb7.it', 'admin', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 1, '+393336666666', '2016-09-26 23:43:28', '2016-10-31', '2016-09-29 19:54:07', 1),
(2, 'manager', 'manager@fb7.it', 'manager', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 2, '+393354444444', '2016-09-26 23:43:28', '2016-09-30', '2016-09-26 23:43:28', 1),
(3, 'user', 'user@fb7.it', 'user', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 3, '+393489999999', '2016-09-26 23:43:28', '2016-09-30', '2016-09-29 19:22:25', 1),
(4, 'utente1', 'ut@ente.it', 'utente1', '', 'utente_add', 2, '+393476666666', '2016-09-28 21:24:28', '2016-12-31', '2016-09-28 21:24:28', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_devices_1_idx` (`type`);

--
-- Indici per le tabelle `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`,`deviceid`,`userid`),
  ADD KEY `fk_reservation_userid_idx` (`userid`),
  ADD KEY `fk_reservation_deviceid_idx` (`deviceid`);

--
-- Indici per le tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userid_tags_idx` (`userid`);

--
-- Indici per le tabelle `type_device`
--
ALTER TABLE `type_device`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `fk_user_level_idx` (`user_level`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `log`
--
ALTER TABLE `log`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `type_device`
--
ALTER TABLE `type_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `type_user`
--
ALTER TABLE `type_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `fk_type_device` FOREIGN KEY (`type`) REFERENCES `type_device` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_deviceid` FOREIGN KEY (`deviceid`) REFERENCES `devices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservation_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `fk_userid_tags` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_level` FOREIGN KEY (`user_level`) REFERENCES `type_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
