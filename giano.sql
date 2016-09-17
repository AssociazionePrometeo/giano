-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Set 14, 2016 alle 00:10
-- Versione del server: 5.5.50-MariaDB
-- Versione PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giano`
--

drop database if exists giano ; 
create database if not exists giano;
use giano;

-- --------------------------------------------------------

--
-- Struttura della tabella `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `type` enum('0','1','2','3') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `devices`
--

INSERT INTO `devices` (`id`, `name`, `active`, `type`) VALUES
(1, 'porta 1', 1, '1'),
(2, 'porta 2', 1, '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(25) NOT NULL,
  `userid` int(225) NOT NULL,
  `cardcode` text NOT NULL,
  `date_log` datetime NOT NULL,
  `device` int(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `log`
--

INSERT INTO `log` (`id`, `userid`, `cardcode`, `date_log`, `device`) VALUES
(1, 1, 'cardcode1', '2016-09-11 07:25:12', 1),
(2, 20, 'cardcode2', '2016-09-10 06:22:34', 1),
(3, 1, 'cardcode1', '2016-09-13 07:25:12', 2),
(4, 20, 'cardcode2', '2016-09-11 15:40:34', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `system`
--

CREATE TABLE IF NOT EXISTS `system` (
  `site name` mediumtext NOT NULL,
  `site url` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(25) NOT NULL,
  `cardcode` text NOT NULL,
  `userid` int(255) NOT NULL,
  `status` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`id`, `cardcode`, `userid`, `status`) VALUES
(1, 'cardcode1', 1, 0),
(2, 'cardcode2', 20, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(25) NOT NULL,
  `first_name` varchar(25) NOT NULL DEFAULT '',
  `last_name` varchar(25) NOT NULL DEFAULT '',
  `email_address` varchar(25) NOT NULL DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `PASSWORD` varchar(255) NOT NULL DEFAULT '',
  `decrypted_password` varchar(255) NOT NULL DEFAULT '',
  `info` text NOT NULL,
  `user_level` enum('-1','0','1','2','3') NOT NULL DEFAULT '-1',
  `signup_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activated` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COMMENT='Membership Information';

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`userid`, `first_name`, `last_name`, `email_address`, `username`, `PASSWORD`, `decrypted_password`, `info`, `user_level`, `signup_date`, `end_date`, `last_login`, `activated`) VALUES
(1, '', '', '', 'admin', '6e6bc4e49dd477ebc98ef4046c067b5f', 'ciao', '', '0', '2006-04-06 15:56:58', '0000-00-00 00:00:00', '2016-09-13 22:00:31', '1'),
(20, '', '', '', 'utente1', 'b88d6b04a9dc38860301f6bdd81e5ccd', 'utente1', 'poco privilegiato', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-09-11 11:30:48', '1'),
(21, 'ugo', 'prova', 'prova@ugo.com', 'utente2', 'ciao', '5f423b7772a80f77438407c8b78ff305', '', '1', '2016-09-12 05:22:26', '2017-08-16 15:32:35', '0000-00-00 00:00:00', '1');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `log`
--
ALTER TABLE `log`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(25) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;