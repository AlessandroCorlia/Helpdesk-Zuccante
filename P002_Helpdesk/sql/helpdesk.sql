-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 16, 2024 alle 19:06
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `alert`
--

CREATE TABLE `alert` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stanza` int(11) NOT NULL,
  `id_dispositivo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `alert`
--

INSERT INTO `alert` (`id`, `id_utente`, `id_stanza`, `id_dispositivo`) VALUES
(34, 6, 32, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `dispositivo`
--

CREATE TABLE `dispositivo` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `id_stanza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `dispositivo`
--

INSERT INTO `dispositivo` (`id`, `nome`, `id_stanza`) VALUES
(1, 'LAP1-WS01', 42),
(2, 'LAP1-WS02', 42),
(3, 'LAP1-WS03', 42),
(4, 'LAP1-WS04', 42),
(5, 'LAP1-WS05', 42),
(6, 'LAP1-WS06', 42),
(7, 'LAP1-WS07', 42),
(8, 'LAP1-WS08', 42),
(9, 'LAP1-WS09', 42),
(10, 'LAP1-WS10', 42),
(11, 'LAP1-WS11', 42),
(12, 'LAP1-WS12', 42),
(13, 'LAP1-WS13', 42),
(14, 'LAP1-WS14', 42),
(15, 'LAP1-WS15', 42),
(16, 'LAP1-WS16', 42),
(17, 'LAP1-WS17', 42),
(18, 'LAP1-WS18', 42),
(19, 'LAP1-WS19', 42),
(20, 'LAP1-WS20', 42),
(21, 'LAP1-WS21', 42),
(22, 'LAP1-WS22', 42),
(23, 'LAP1-WS23', 42),
(24, 'LAP1-WS24', 42),
(25, 'LAP1-WS25', 42),
(26, 'LAP1-WS26', 42),
(27, 'LAP1-WS27', 42),
(28, 'LAP1-WS28', 42),
(29, 'LAP1-WS29', 42),
(30, 'LAP1-WS30', 42),
(31, 'LAP1-WS31', 42),
(32, 'LAP2-WS01', 13),
(33, 'LAP2-WS02', 13),
(34, 'LAP2-WS03', 13),
(35, 'LAP2-WS04', 13),
(36, 'LAP2-WS05', 13),
(37, 'LAP2-WS06', 13),
(38, 'LAP2-WS07', 13),
(39, 'LAP2-WS08', 13),
(40, 'LAP2-WS09', 13),
(41, 'LAP2-WS10', 13),
(42, 'LAP2-WS11', 13),
(43, 'LAP2-WS12', 13),
(44, 'LAP2-WS13', 13),
(45, 'LAP2-WS14', 13),
(46, 'LAP2-WS15', 13),
(47, 'LAP2-WS16', 13),
(48, 'LAP2-WS17', 13),
(49, 'LAP2-WS18', 13),
(50, 'LAP2-WS19', 13),
(51, 'LAP2-WS20', 13),
(52, 'LAP2-WS21', 13),
(53, 'LAP2-WS22', 13),
(54, 'LAP2-WS23', 13),
(55, 'LAP2-WS24', 13),
(56, 'LAP2-WS25', 13),
(57, 'LAP2-WS26', 13),
(58, 'LAP2-WS27', 13),
(59, 'LAP2-WS28', 13),
(60, 'LAP2-WS29', 13),
(61, 'LAP2-WS30', 13),
(62, 'LLM-WS01', 12),
(63, 'LLM-WS02', 12),
(64, 'LLM-WS03', 12),
(65, 'LLM-WS04', 12),
(66, 'LLM-WS05', 12),
(67, 'LLM-WS06', 12),
(68, 'LLM-WS07', 12),
(69, 'LLM-WS08', 12),
(70, 'LLM-WS09', 12),
(71, 'LLM-WS10', 12),
(72, 'LLM-WS11', 12),
(73, 'LLM-WS12', 12),
(74, 'LLM-WS13', 12),
(75, 'LLM-WS14', 12),
(76, 'LLM-WS15', 12),
(77, 'LLM-WS16', 12),
(78, 'LLM-WS17', 12),
(79, 'LLM-WS18', 12),
(80, 'LLM-WS19', 12),
(81, 'LLM-WS20', 12),
(82, 'LLM-WS21', 12),
(83, 'LLM-WS22', 12),
(84, 'LLM-WS23', 12),
(85, 'LLM-WS24', 12),
(86, 'LLM-WS25', 12),
(87, 'LLM-WS26', 12),
(88, 'LLM-WS27', 12),
(89, 'LLM-WS28', 12),
(90, 'CAT01', 12),
(91, 'WS01', 1),
(92, 'WS01', 2),
(93, 'WS01', 3),
(94, 'WS01', 4),
(95, 'WS01', 5),
(96, 'WS01', 6),
(97, 'WS01', 7),
(98, 'WS01', 8),
(99, 'WS01', 9),
(100, 'WS01', 23),
(101, 'WS01', 24),
(102, 'WS01', 25),
(103, 'WS01', 26),
(104, 'WS01', 27),
(105, 'WS01', 28),
(106, 'WS01', 29),
(107, 'WS01', 30),
(108, 'WS01', 31),
(109, 'WS01', 32),
(110, 'WS01', 33),
(111, 'WS01', 34),
(112, 'WS01', 35);

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `id` int(11) NOT NULL,
  `id_stanza` int(11) NOT NULL,
  `id_dispositivo` int(11) DEFAULT NULL,
  `id_segnalazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`id`, `id_stanza`, `id_dispositivo`, `id_segnalazione`) VALUES
(1, 7, NULL, 10),
(4, 3, NULL, 13),
(5, 2, 92, 14),
(6, 2, NULL, 15),
(7, 2, NULL, 16),
(9, 27, NULL, 18),
(11, 6, 96, 20),
(12, 2, 92, 21),
(13, 32, NULL, 22),
(14, 12, 64, 23),
(15, 32, 109, 24),
(16, 3, NULL, 25),
(17, 1, NULL, 26),
(18, 1, NULL, 27),
(19, 24, NULL, 28),
(20, 3, NULL, 29);

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazione`
--

CREATE TABLE `segnalazione` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_stanza` int(11) NOT NULL,
  `id_dispositivo` int(11) DEFAULT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `tipo` enum('pulizia','guasto_tecnico','guasto_aula') NOT NULL,
  `stato` enum('eseguita','in_attesa','fallita') DEFAULT 'in_attesa',
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `segnalazione`
--

INSERT INTO `segnalazione` (`id`, `id_utente`, `id_stanza`, `id_dispositivo`, `data`, `tipo`, `stato`, `descrizione`) VALUES
(1, 2, 1, NULL, '2024-04-30 17:36:47', 'pulizia', 'in_attesa', 'Pavimento Sporco '),
(2, 2, 3, NULL, '2024-04-30 17:36:57', 'guasto_aula', 'in_attesa', 'Buco nel muro '),
(3, 2, 42, 20, '2024-04-30 17:37:23', 'guasto_tecnico', 'in_attesa', 'Errore di Windows '),
(4, 2, 1, NULL, '2024-05-01 16:44:41', 'pulizia', 'in_attesa', 'Sporco '),
(5, 2, 3, 93, '2024-05-01 16:53:50', 'guasto_tecnico', 'in_attesa', 'Schermo'),
(6, 2, 12, 62, '2024-05-02 10:14:49', 'guasto_tecnico', 'in_attesa', 'Schermo non funziona'),
(7, 2, 3, 93, '2024-05-02 18:08:46', 'guasto_tecnico', 'in_attesa', 'Il dispositivo non si accende '),
(8, 2, 59, NULL, '2024-05-03 17:18:52', 'pulizia', 'in_attesa', 'Macchia su pavimento '),
(9, 6, 3, NULL, '2024-05-07 11:38:02', 'pulizia', 'in_attesa', 'Esploso'),
(10, 2, 7, NULL, '2024-05-10 16:24:44', 'guasto_aula', 'in_attesa', 'C\'è un buco nel muro'),
(13, 2, 3, NULL, '2024-05-14 21:01:05', 'pulizia', 'in_attesa', 'aa'),
(14, 2, 2, 92, '2024-05-15 15:36:53', 'guasto_tecnico', 'in_attesa', 'Non funziona più la lim associata'),
(15, 2, 2, NULL, '2024-05-15 16:00:21', 'pulizia', 'in_attesa', 'Unto '),
(16, 2, 2, NULL, '2024-05-15 16:01:09', 'pulizia', 'in_attesa', 'Unto '),
(18, 2, 27, NULL, '2024-05-15 18:02:23', 'pulizia', 'in_attesa', 'C\'è un ragno morto'),
(20, 2, 6, 96, '2024-05-15 18:26:59', 'pulizia', 'fallita', 'Tastiera '),
(21, 6, 2, 92, '2024-05-15 19:09:16', 'guasto_tecnico', 'in_attesa', 'Non c\'è connessione ad internet'),
(22, 2, 32, NULL, '2024-05-16 10:34:32', 'pulizia', 'in_attesa', 'Formiche '),
(23, 2, 12, 64, '2024-05-16 11:32:04', 'pulizia', 'in_attesa', 'Tastiera con briciole'),
(24, 2, 32, 109, '2024-05-16 15:23:54', 'pulizia', 'in_attesa', 'Ciao'),
(25, 2, 3, NULL, '2024-05-16 15:47:39', 'guasto_aula', 'eseguita', 'Finestra non si chiude '),
(26, 2, 1, NULL, '2024-05-16 15:51:35', 'pulizia', 'eseguita', 'a'),
(27, 2, 1, NULL, '2024-05-16 15:52:40', 'pulizia', 'eseguita', 'a'),
(28, 2, 24, NULL, '2024-05-16 15:52:59', 'pulizia', 'in_attesa', 'v'),
(29, 2, 3, NULL, '2024-05-16 15:58:22', 'pulizia', 'eseguita', 'a');

-- --------------------------------------------------------

--
-- Struttura della tabella `stanza`
--

CREATE TABLE `stanza` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `piano` enum('terra','primo','secondo') NOT NULL,
  `tipo` enum('aula','laboratorio','bagno','spogliatoio','palestra','ufficio') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `stanza`
--

INSERT INTO `stanza` (`id`, `nome`, `numero`, `piano`, `tipo`) VALUES
(1, '3IA', 7, 'terra', 'aula'),
(2, '4IA', 8, 'terra', 'aula'),
(3, '5IA', 9, 'terra', 'aula'),
(4, '3IB', 10, 'terra', 'aula'),
(5, '4IB', 11, 'terra', 'aula'),
(6, '5IB', 12, 'terra', 'aula'),
(7, 'AULA RELAX', 13, 'terra', 'aula'),
(8, '3ID', 14, 'terra', 'aula'),
(9, '3IE', 15, 'terra', 'aula'),
(10, 'LAS', NULL, 'terra', 'laboratorio'),
(11, 'LOCALE A.T. LAS', NULL, 'terra', 'laboratorio'),
(12, 'LLM', NULL, 'terra', 'laboratorio'),
(13, 'LAP2', NULL, 'terra', 'laboratorio'),
(14, 'LAM', NULL, 'terra', 'laboratorio'),
(15, 'WC', NULL, 'terra', 'bagno'),
(16, 'WC', NULL, 'terra', 'bagno'),
(17, 'LASA', NULL, 'terra', 'laboratorio'),
(18, 'AULA MAGNA', NULL, 'terra', 'aula'),
(19, 'OEN1', 41, 'terra', 'laboratorio'),
(20, 'PALESTRA', NULL, 'terra', 'palestra'),
(21, 'SPOGLIATOIO U', NULL, 'terra', 'spogliatoio'),
(22, 'SPOGLIATOIO F', NULL, 'terra', 'spogliatoio'),
(23, '4EA-TA', 21, 'primo', 'aula'),
(24, '4TA', 22, 'primo', 'aula'),
(25, '5EA-TA', 23, 'primo', 'aula'),
(26, '5TA', 24, 'primo', 'aula'),
(27, '3EA', 25, 'primo', 'aula'),
(28, '4AB', 26, 'primo', 'aula'),
(29, '5AB', 27, 'primo', 'aula'),
(30, '4IC', 28, 'primo', 'aula'),
(31, '3IC', 29, 'primo', 'aula'),
(32, '5IC', 30, 'primo', 'aula'),
(33, '3AA', 31, 'primo', 'aula'),
(34, '4AA', 32, 'primo', 'aula'),
(35, '5AA', 33, 'primo', 'aula'),
(36, 'AULA MUSICA', NULL, 'primo', 'aula'),
(37, 'WC', NULL, 'primo', 'bagno'),
(38, 'WC', NULL, 'primo', 'bagno'),
(39, 'SALA LETTURA', NULL, 'primo', 'aula'),
(40, 'DEPOSITO LIBRI', NULL, 'primo', 'aula'),
(41, 'AULA INSEGNANTI', NULL, 'primo', 'aula'),
(42, 'LAP1', NULL, 'primo', 'laboratorio'),
(43, 'LOCALE A.T. LAP1', NULL, 'primo', 'laboratorio'),
(44, 'SALA SERVER', NULL, 'primo', 'ufficio'),
(45, 'OEN2', NULL, 'primo', 'laboratorio'),
(46, 'AULA EMERGENZE', NULL, 'primo', 'aula'),
(47, 'WC', NULL, 'primo', 'bagno'),
(48, 'WC', NULL, 'primo', 'bagno'),
(49, 'BAR', NULL, 'primo', 'aula'),
(50, 'UFFICIO TECNICO', 43, 'secondo', 'ufficio'),
(51, 'PCTO', 44, 'secondo', 'ufficio'),
(52, 'UFFICIO PERSONALE', 45, 'secondo', 'ufficio'),
(53, 'SEGRETERIA DIDATTICA', 46, 'secondo', 'ufficio'),
(54, 'PRESIDENZA', 47, 'secondo', 'ufficio'),
(55, 'VICE PRESIDENZA', 48, 'secondo', 'ufficio'),
(56, 'MAGAZZINO', 50, 'secondo', 'aula'),
(57, 'UFFICIO DSGA', NULL, 'secondo', 'ufficio'),
(58, 'LOCALE', NULL, 'secondo', 'ufficio'),
(59, 'LEN4', 51, 'secondo', 'laboratorio'),
(60, 'LOCALE A.T.', 52, 'secondo', 'laboratorio'),
(61, 'LEN5', 53, 'secondo', 'laboratorio'),
(62, 'PROVA', 54, 'secondo', 'ufficio');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(319) NOT NULL,
  `ruolo` enum('utente','tecnico','personaleATA','amministratore') DEFAULT 'utente',
  `piano` enum('terra','primo','secondo') DEFAULT NULL,
  `sospensione` enum('true','false') DEFAULT 'false',
  `ban` enum('true','false') DEFAULT 'false',
  `fine_sospensione` date DEFAULT NULL,
  `foto_profilo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `email`, `ruolo`, `piano`, `sospensione`, `ban`, `fine_sospensione`, `foto_profilo`) VALUES
(1, 'Fiorenzo', 'D Onofrio', 'fiorenzo.donofrio@itiszuccante.edu.it', 'tecnico', 'primo', 'false', 'false', NULL, NULL),
(2, 'Alessandro', 'Corliano', 'alessandro.corliano@itiszuccante.edu.it', 'amministratore', NULL, 'false', 'false', NULL, NULL),
(3, 'Massimo', 'Ballin', 'massimo.ballin@itiszuccante.edu.it', 'tecnico', 'terra', 'false', '', NULL, NULL),
(6, 'Matteo', 'Valerii', 'matteo.valerii@itiszuccante.edu.it', 'tecnico', 'terra', 'false', '', NULL, NULL),
(7, 'Matteo', 'Baldan', 'matteo.baldan@itiszuccante.edu.it', 'tecnico', 'terra', 'false', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente_in_stanza`
--

CREATE TABLE `utente_in_stanza` (
  `id_utente` int(11) NOT NULL,
  `id_stanza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente_notifica`
--

CREATE TABLE `utente_notifica` (
  `id_utente` int(11) NOT NULL,
  `id_notifica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `utente_notifica`
--

INSERT INTO `utente_notifica` (`id_utente`, `id_notifica`) VALUES
(1, 9),
(1, 13),
(1, 15),
(1, 19),
(2, 16),
(2, 17),
(2, 18),
(3, 7),
(3, 11),
(3, 12),
(3, 14),
(3, 16),
(3, 17),
(3, 18),
(3, 20),
(6, 11),
(6, 12),
(6, 13),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(6, 20);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stanza` (`id_stanza`),
  ADD KEY `id_dispositivo` (`id_dispositivo`);

--
-- Indici per le tabelle `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_stanza` (`id_stanza`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_stanza` (`id_stanza`),
  ADD KEY `id_dispositivo` (`id_dispositivo`),
  ADD KEY `id_segnalazione` (`id_segnalazione`);

--
-- Indici per le tabelle `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_stanza` (`id_stanza`),
  ADD KEY `id_dispositivo` (`id_dispositivo`);

--
-- Indici per le tabelle `stanza`
--
ALTER TABLE `stanza`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utente_in_stanza`
--
ALTER TABLE `utente_in_stanza`
  ADD PRIMARY KEY (`id_utente`,`id_stanza`),
  ADD KEY `id_stanza` (`id_stanza`);

--
-- Indici per le tabelle `utente_notifica`
--
ALTER TABLE `utente_notifica`
  ADD PRIMARY KEY (`id_utente`,`id_notifica`),
  ADD KEY `id_notifica` (`id_notifica`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `alert`
--
ALTER TABLE `alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT per la tabella `dispositivo`
--
ALTER TABLE `dispositivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT per la tabella `stanza`
--
ALTER TABLE `stanza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `alert`
--
ALTER TABLE `alert`
  ADD CONSTRAINT `alert_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alert_ibfk_2` FOREIGN KEY (`id_stanza`) REFERENCES `stanza` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alert_ibfk_3` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivo` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `dispositivo`
--
ALTER TABLE `dispositivo`
  ADD CONSTRAINT `dispositivo_ibfk_1` FOREIGN KEY (`id_stanza`) REFERENCES `stanza` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`id_stanza`) REFERENCES `stanza` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifica_ibfk_2` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifica_ibfk_3` FOREIGN KEY (`id_segnalazione`) REFERENCES `segnalazione` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD CONSTRAINT `segnalazione_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `segnalazione_ibfk_2` FOREIGN KEY (`id_stanza`) REFERENCES `stanza` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `segnalazione_ibfk_3` FOREIGN KEY (`id_dispositivo`) REFERENCES `dispositivo` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `utente_in_stanza`
--
ALTER TABLE `utente_in_stanza`
  ADD CONSTRAINT `utente_in_stanza_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `utente_in_stanza_ibfk_2` FOREIGN KEY (`id_stanza`) REFERENCES `stanza` (`id`);

--
-- Limiti per la tabella `utente_notifica`
--
ALTER TABLE `utente_notifica`
  ADD CONSTRAINT `utente_notifica_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `utente_notifica_ibfk_2` FOREIGN KEY (`id_notifica`) REFERENCES `notifica` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
