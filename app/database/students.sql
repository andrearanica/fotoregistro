-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 04, 2023 alle 14:43
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
-- Struttura della tabella `students`
--

CREATE TABLE `students` (
  `student_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `photo_path` varchar(50) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `students`
--

INSERT INTO `students` (`student_id`, `name`, `surname`, `photo_path`, `class_id`, `email`, `password`, `enabled`) VALUES
('0', 'Carlo', 'Riva', NULL, NULL, 'wolf@gmail.com', 'carlo', 0),
('1', 'Mario', 'Rossi', NULL, NULL, 'mariorossi@gmail.com', 'mariorossi', 0),
('10', 'Alberto', 'Fagioli', NULL, NULL, 'alberto@gmail.com', 'fagioli', 0),
('st_64034ada04103', 'Edoardo', 'Rebussi', NULL, NULL, 'edo@gmail.com', 'edo', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
