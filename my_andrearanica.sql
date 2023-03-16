-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 16, 2023 alle 09:03
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_andrearanica`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `angulardisplacement`
--

CREATE TABLE `angulardisplacement` (
  `displacement` int(11) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `angulardisplacement`
--

INSERT INTO `angulardisplacement` (`displacement`, `factor`) VALUES
(0, 1),
(30, 0.9),
(60, 0.81),
(90, 0.71),
(120, 0.52),
(135, 0.57),
(136, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_key` varchar(5) NOT NULL,
  `name` varchar(5) NOT NULL,
  `access_type` bit(1) NOT NULL,
  `school_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `classes`
--

INSERT INTO `classes` (`class_id`, `class_key`, `name`, `access_type`, `school_id`) VALUES
(1, '', '5ID', b'0', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 1,
  `businessName` varchar(255) NOT NULL,
  `cost` float NOT NULL,
  `date` varchar(255) NOT NULL,
  `realWeight` float NOT NULL,
  `heightFromGround` float NOT NULL,
  `verticalDistance` float NOT NULL,
  `horizontalDistance` float NOT NULL,
  `angularDisplacement` float NOT NULL,
  `gripValue` varchar(10) NOT NULL,
  `frequency` float NOT NULL,
  `duration` varchar(255) NOT NULL,
  `oneHand` tinyint(1) NOT NULL DEFAULT 0,
  `twoPeople` tinyint(1) NOT NULL DEFAULT 0,
  `maximumWeight` float NOT NULL,
  `IR` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `evaluations`
--

INSERT INTO `evaluations` (`id`, `valid`, `businessName`, `cost`, `date`, `realWeight`, `heightFromGround`, `verticalDistance`, `horizontalDistance`, `angularDisplacement`, `gripValue`, `frequency`, `duration`, `oneHand`, `twoPeople`, `maximumWeight`, `IR`) VALUES
(55, 1, 'HP', 250, '2023-02-22', 30, 0, 25, 25, 0, 'Buono', 1, '< 1 ora', 1, 0, 9.98844, 3.00347);

-- --------------------------------------------------------

--
-- Struttura della tabella `frequency`
--

CREATE TABLE `frequency` (
  `frequency` float NOT NULL,
  `duration` varchar(255) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `frequency`
--

INSERT INTO `frequency` (`frequency`, `duration`, `factor`) VALUES
(0.2, '< 1 ora', 1),
(1, '< 1 ora', 0.94),
(4, '< 1 ora', 0.84),
(6, '< 1 ora', 0.75),
(9, '< 1 ora', 0.52),
(12, '< 1 ora', 0.37),
(15, '< 1 ora', 0),
(0.2, 'da 1 a 2 ore', 0.95),
(1, 'da 1 a 2 ore', 0.88),
(4, 'da 1 a 2 ore', 0.72),
(6, 'da 1 a 2 ore', 0.5),
(9, 'da 1 a 2 ore', 0.3),
(12, 'da 1 a 2 ore', 0.21),
(15, 'da 1 a 2 ore', 0),
(0.2, 'da 2 a 8 ore', 0.85),
(1, 'da 2 a 8 ore', 0.75),
(4, 'da 2 a 8 ore', 0.45),
(6, 'da 2 a 8 ore', 0.27),
(9, 'da 2 a 8 ore', 0.52),
(12, 'da 2 a 8 ore', 0),
(15, 'da 2 a 8 ore', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `gripvalue`
--

CREATE TABLE `gripvalue` (
  `value` varchar(255) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `gripvalue`
--

INSERT INTO `gripvalue` (`value`, `factor`) VALUES
('Buono', 1),
('Scarso', 0.9);

-- --------------------------------------------------------

--
-- Struttura della tabella `heightfromground`
--

CREATE TABLE `heightfromground` (
  `height` int(11) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `heightfromground`
--

INSERT INTO `heightfromground` (`height`, `factor`) VALUES
(0, 0.77),
(25, 0.85),
(50, 0.93),
(75, 1),
(100, 0.93),
(125, 0.85),
(150, 0.78),
(175, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `horizontaldistance`
--

CREATE TABLE `horizontaldistance` (
  `distance` int(11) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `horizontaldistance`
--

INSERT INTO `horizontaldistance` (`distance`, `factor`) VALUES
(25, 1),
(30, 0.83),
(40, 0.63),
(50, 0.5),
(55, 0.45),
(60, 0.42),
(63, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `schools`
--

CREATE TABLE `schools` (
  `school_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `schools`
--

INSERT INTO `schools` (`school_id`, `name`) VALUES
(1, 'I.T.I.S. Paleocapa');

-- --------------------------------------------------------

--
-- Struttura della tabella `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `photo` bit(50) DEFAULT b'0',
  `class_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `students`
--

INSERT INTO `students` (`student_id`, `name`, `surname`, `photo`, `class_id`, `email`, `password`, `enabled`) VALUES
('0', 'Carlo', 'Riva', NULL, NULL, 'wolf@gmail.com', 'carlo', 0),
('1', 'Mario', 'Rossi', NULL, NULL, 'mariorossi@gmail.com', 'mariorossi', 1),
('10', 'Alberto', 'Fagioli', NULL, NULL, 'alberto@gmail.com', 'fagioli', 0),
('st_64034ada04103', 'Edoardo', 'Rebussi', b'00000000000000000000000000000000000000000000000000', NULL, 'edo@gmail.com', 'edo', 1),
('st_6406191ec90e1', 'Riccardo', 'Nasatti', b'00000000000000000000000000000000000000000000000000', NULL, 'riccardonasatti@gmail.com', 'riccardonasatti', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `surname`, `email`, `password`, `enabled`) VALUES
('0', '', '', '', '', 0),
('1', 'Diego', 'Bernini', 'diego.bernini@itispaleocapa.it', 'diegobernini', 1),
('2', '', '', '', '', 0),
('3', '', '', '', '', 0),
('tc_64061fe1d18ed', 'Mirko', 'Togni', 'mirko.togni@itispaleocapa.it', 'mirkotogni', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name_surname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name_surname`, `username`, `password`, `role`) VALUES
(1, 'Maurizio Gaffuri', 'mauriziogaffuri', 'cef5c0b4e729d8a2d4e60505d9e61d3896b4d9e49a0567a06ba2447be1dc94a5', 1),
(2, 'Diego Bernini', 'diegobernini', 'diegobernini', 0),
(4, 'Stefano Pezzotta', 'stefanopezzotta', 'stefanopezzotta', 0),
(5, 'Marcella Falzone', 'marcellafalzone', 'a6b5a20875439723a23c5300d3ce30be66fbc9a284f1d3e182feed398aad2550', 0),
(6, 'Amadeus Sebastiani', 'olamadeus', '7fa492d29d0e7ddfdc0dbf09b3ddbf1272abb3a73ad595ae23574b5b210a197b', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `verticaldistance`
--

CREATE TABLE `verticaldistance` (
  `dislocation` int(11) NOT NULL,
  `factor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `verticaldistance`
--

INSERT INTO `verticaldistance` (`dislocation`, `factor`) VALUES
(25, 1),
(30, 0.97),
(40, 0.93),
(50, 0.91),
(70, 0.88),
(100, 0.87),
(150, 0.86),
(175, 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `angulardisplacement`
--
ALTER TABLE `angulardisplacement`
  ADD PRIMARY KEY (`displacement`);

--
-- Indici per le tabelle `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indici per le tabelle `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `gripvalue`
--
ALTER TABLE `gripvalue`
  ADD PRIMARY KEY (`value`);

--
-- Indici per le tabelle `heightfromground`
--
ALTER TABLE `heightfromground`
  ADD PRIMARY KEY (`height`);

--
-- Indici per le tabelle `horizontaldistance`
--
ALTER TABLE `horizontaldistance`
  ADD PRIMARY KEY (`distance`);

--
-- Indici per le tabelle `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indici per le tabelle `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indici per le tabelle `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `verticaldistance`
--
ALTER TABLE `verticaldistance`
  ADD PRIMARY KEY (`dislocation`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT per la tabella `schools`
--
ALTER TABLE `schools`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`);

--
-- Limiti per la tabella `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
