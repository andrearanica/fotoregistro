-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 14, 2023 alle 23:28
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

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
-- Struttura della tabella `blacklist`
--

CREATE TABLE `blacklist` (
  `student_id` varchar(255) NOT NULL,
  `class_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `classes`
--

CREATE TABLE `classes` (
  `class_id` varchar(255) NOT NULL,
  `class_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`) VALUES
('1', '5ID'),
('2', '5IA'),
('3', '5IA'),
('4', '5EA'),
('5', '5EA'),
('6', '5EB'),
('cl_6425d7bd508a0', '5IB'),
('cl_6426bac4ba51a', '5EA'),
('cl_6426bbb38236e', 'daf'),
('cl_6426bc62c71e6', 'dia'),
('cl_6426bf5d82a19', 'wa'),
('cl_6426bf8b3f7c6', 'wa'),
('cl_6426bfa3cb7dd', 'wa'),
('cl_6437c356db6f1', 'Loris'),
('cl_643cf8c74c129', '5FF');

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
  `evaluation_id` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 1,
  `author` int(11) DEFAULT NULL,
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

INSERT INTO `evaluations` (`evaluation_id`, `valid`, `author`, `businessName`, `cost`, `date`, `realWeight`, `heightFromGround`, `verticalDistance`, `horizontalDistance`, `angularDisplacement`, `gripValue`, `frequency`, `duration`, `oneHand`, `twoPeople`, `maximumWeight`, `IR`) VALUES
(94, 0, 1, 'Castelli', 10, '2023-04-26', 4, 75, 40, 30, 0, 'Buono', 1, 'da 2 a 8 ore', 0, 0, 11.5785, 0.345468),
(97, 1, 1, 'Castelli', 100, '2023-04-26', 4, 75, 25, 30, 0, 'Buono', 0.2, '< 1 ora', 0, 0, 16.6, 0.240964);

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
  `photo` tinyint(1) DEFAULT 0,
  `photo_type` varchar(255) DEFAULT NULL,
  `class_id` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `activation_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `students`
--

INSERT INTO `students` (`student_id`, `name`, `surname`, `photo`, `photo_type`, `class_id`, `email`, `password`, `enabled`, `activation_code`) VALUES
('0', 'Carlo', 'Riva', NULL, '', NULL, 'wolf@gmail.com', 'carlo', 1, ''),
('1', 'Mario', 'Rossi', NULL, '', NULL, 'mariorossi@gmail.com', 'mariorossi', 1, ''),
('st_64034ada04103', 'Edoardo', 'Rebussi', 0, '', NULL, 'edo@gmail.com', 'edo', 1, ''),
('st_644a500c6eae6', 'Edoardo', 'Stroppa', 0, 'png', '3', 'stroppa.edoardo4@gmail.com', '$2y$10$QfvWZMHkhwt32KRQbWH.KOl/PXOPiOMqiP3mKKlA7GxwDoxaoH5oq', 1, ''),
('st_645960d7ad477', 'f', 'ougf', 1, '', NULL, 'e@e', '$2y$10$6SB1oF3vbN1yvgrpSMSvYuRk3kx3uWUcZjsdWp2X4TDoAtEDenU16', 1, ''),
('st_645a56c90e57a', 'Loris', 'Rota', 0, 'jpeg', '3', 'lorisrota@gmail.com', '$2y$10$Kl6q2zE/6365S1jX/jK1x.l52.G3u7qpsgXRO1cV1VDZdhUlHt/7G', 1, ''),
('st_645a5731c528b', 'Mattia', 'Rocchi', 0, 'jpeg', NULL, 'mattiarocchi@gmail.com', '$2y$10$AvByhGcv5ROEyOUvdZT/ReZViMYL.WE.OPUrPaxCXcYS6ZEQcaP0.', 1, ''),
('st_645a576a04b55', 'Simone', 'Milesi', 1, 'jpeg', NULL, 'simonemilesi@gmail.com', '$2y$10$OnkTHFTwzX.Ec9I.nHbTIu63RkEcwqkwPQ2t7WhGGpzF78kE0giBy', 1, ''),
('st_645a57b5121ab', 'Alessandro', 'Bassi', 1, 'jpeg', NULL, 'bassi@gmail.com', '$2y$10$KwPkGBJI7LKLBM4eYo3IIOSnrFj7bspV4M/Z/S4MhMVly70Nju.46', 1, ''),
('st_645a58fab3b99', 'Filippo Giovanni', 'Graziano', 1, 'jpg', NULL, 'graziano@gmail.com', '$2y$10$Xw1gt39K8SE.dsuq9.fj8etfLksXnR5NrsjNeSx.xvC2QhyHdu4BS', 1, ''),
('st_645a5975b620a', 'Chengzhou', 'Hu', 0, 'jpg', NULL, 'hu@gmail.com', '$2y$10$RuOvQn9rGMZ2LhUF16qzquNDWf9mjGOnRJUJFsDr1Jcte3QYZbNa6', 1, ''),
('st_645a59ac6f80c', 'Francesco', 'Vavassori', 1, 'jpg', NULL, 'vava@gmail.com', '$2y$10$fx3aDpkIxNojIAchwPQdyuHEj46Af5hp.yiuCqWszu4DWiDwH4mEy', 1, ''),
('st_645a8e68adfd7', 'Oscar', 'Mazzoni', 1, 'jpg', NULL, 'oscarmazzoni@gmail.com', '$2y$10$EfA1d4HA4T2MDTxPzmuB/.Y6qA1RsutGihaG7B3iykKs.IsMPFvvG', 1, ''),
('st_64614bc9c7ed9', 'p', 'p', 0, NULL, NULL, 'p@p', '$2y$10$r5V53k2bzG6YPXtFQxmkBetBd/9rmgG0b0CqG9oU57zNZ0dRcAM8y', 1, '64614bc9d5dfe');

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
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `activation_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `surname`, `email`, `password`, `enabled`, `activation_code`) VALUES
('0', '', '', '', '', 0, ''),
('1', 'Diego', 'Bernini', 'diego.bernini@itispaleocapa.it', 'diegobernini', 1, ''),
('2', '', '', '', '', 0, ''),
('3', '', '', '', '', 0, ''),
('tc_64061fe1d18ed', 'Mirko', 'Togni', 'mirko.togni@itispaleocapa.it', 'mirkotogni', 1, ''),
('tc_644271e4b25a8', 'Luigi', 'Cisana', 'luigi.cisana@itispaleocapa.it', '$2y$10$/mTC.9ZgUuwKEBPAaqL8LeB0OGkeuBtcEeSikwoPIJiSt8LMC.xlG', 1, ''),
('tc_644a3d64cdc38', 'Andrea', 'Ranica', 'andrearanica2004@gmail.com', '$2y$10$IuO25S2kXYdOepJzHwziKu.Hrz9q5ySy0590FjE.2CCr1MR4uLyOq', 1, '');

-- --------------------------------------------------------

--
-- Struttura della tabella `teaches`
--

CREATE TABLE `teaches` (
  `class_id` varchar(255) NOT NULL,
  `teacher_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `teaches`
--

INSERT INTO `teaches` (`class_id`, `teacher_id`) VALUES
('3', 'tc_644271e4b25a8');

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
(6, 'Amadeus Sebastiani', 'olamadeus', '7fa492d29d0e7ddfdc0dbf09b3ddbf1272abb3a73ad595ae23574b5b210a197b', 2),
(7, 'Admin  ', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1),
(8, ' ', '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 1),
(9, ' ', '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 0),
(12, 'Mario Masse', 'mariomasse', '5fa8b6113426cdd5d27951f74c2fd44646674cb93aa6a95053f08fbfd38a275e', 0),
(13, 'oscar mazzoni', 'mazzoni ', 'd32ea12e4335a0624570d2df7c6640aa7d209688cbc87163cb6f7f5660e316e6', 0),
(14, 'Oscar Mazzoni', 'mazzoni', 'd32ea12e4335a0624570d2df7c6640aa7d209688cbc87163cb6f7f5660e316e6', 0),
(16, 'Operatore Operatore', 'operatore', '7e1d5a895ce6c831e646c19cb875e67c8a0f22d4d9d688a53c233d64eb84fff8', 2),
(17, 'Chengzhou Hu', 'cheng', '211c963a9272a1405a2ae77464235dd515f0fb086fed0cf785e0ce5c13c07477', 2),
(18, 'Rota Rota', 'Rota', '7c81b807e573b9e2efc7169af5ecf94ab18e71a0b8d2904a457b5e4713168071', 0),
(19, 'Mario Mario', 'mario', '59195c6c541c8307f1da2d1e768d6f2280c984df217ad5f4c64c3542b04111a4', 0),
(20, 'Castelli  ', 'Castelli', 'e7b5072d1fcf141ec44bdb8784a26e30fc74ff4800f2e8be6d1495534bb3f92c', 0),
(21, 'Castelli  ', 'Castelli', 'e7b5072d1fcf141ec44bdb8784a26e30fc74ff4800f2e8be6d1495534bb3f92c', 0);

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
-- Indici per le tabelle `blacklist`
--
ALTER TABLE `blacklist`
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indici per le tabelle `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indici per le tabelle `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `author` (`author`);

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
-- Indici per le tabelle `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`teacher_id`,`class_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `class_id` (`class_id`);

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
-- AUTO_INCREMENT per la tabella `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT per la tabella `schools`
--
ALTER TABLE `schools`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `blacklist`
--
ALTER TABLE `blacklist`
  ADD CONSTRAINT `blacklist_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `blacklist_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Limiti per la tabella `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Limiti per la tabella `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`),
  ADD CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
