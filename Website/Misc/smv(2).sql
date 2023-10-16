-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 15, 2023 at 12:27 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smv`
--

-- --------------------------------------------------------

--
-- Table structure for table `gradiva`
--

CREATE TABLE `gradiva` (
  `id_gradiva` int(11) NOT NULL,
  `oddaja` enum('1','0') NOT NULL DEFAULT '0',
  `datum_do` date DEFAULT NULL,
  `format` varchar(100) NOT NULL,
  `naslov` varchar(100) NOT NULL,
  `opis` text NOT NULL,
  `id_modula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `id_modula` int(11) NOT NULL,
  `id_predmet` int(11) DEFAULT NULL,
  `Naslov` varchar(255) NOT NULL,
  `Opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id_modula`, `id_predmet`, `Naslov`, `Opis`) VALUES
(1, 1, 'Vaja1SLO', 'nn'),
(2, 2, 'Vaja1MAT', 'nn'),
(3, 1, 'Vaja2SLO', 'nn'),
(4, 1, 'Vaja3SLO', 'nn'),
(5, 3, 'Vaja1SOC', 'nn'),
(6, 4, 'Vaja1NUP', 'nn');

-- --------------------------------------------------------

--
-- Table structure for table `oddaja`
--

CREATE TABLE `oddaja` (
  `id_oddaja` int(11) NOT NULL,
  `id_gradiva` int(11) NOT NULL,
  `ocena` int(11) DEFAULT NULL,
  `datum_oddaje` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `file_ext` varchar(10) NOT NULL,
  `priloga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE `predmeti` (
  `id_predmet` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `kratica` varchar(5) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `predmeti`
--

INSERT INTO `predmeti` (`id_predmet`, `ime`, `kratica`, `opis`) VALUES
(1, 'Slovenščina', 'SLO', NULL),
(2, 'Matematika', 'MAT', NULL),
(3, 'Sociologija', 'SOC', NULL),
(4, 'Napredna Uporaba Podatkovnih Baz', 'NUP', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ucilnica`
--

CREATE TABLE `ucilnica` (
  `id_predmet` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_type` int(11) DEFAULT 2 CHECK (`user_type` in (0,1,2)),
  `ime` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `priimek` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `geslo` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `img_ext` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`, `img_ext`) VALUES
(134, 2, 'Kevin', 'Zlodej', '$2y$10$tQnH9CHCY.wF5wxvh7QNieViJuRLfH08aE/mBTXnoS2DAdKpwuwDa', 'KevinZlodej', NULL, NULL),
(135, 0, 'Mark', 'Sadnik', '$2y$10$sNRwbz/lctZdrjUNwGxCVewHACD.ih2HGqku7.Ko5PolFl/7DE/Mu', 'MarkSadnik', '[uporabnik ni dodal dodatnih informacij]', 'png'),
(136, 2, 'Liam', 'Smith', '$2y$10$f.Z3VP5tlNFIBtpN3QYMC.UijXYFiYPOvLQh4TuJc02ck7P9tJhqi', 'LiamSmith', NULL, NULL),
(137, 2, 'Markku', 'Allen', '$2y$10$EpSGk4t0NskHCdok5FomW.AYFyIyJ0redZ5ZKaxzv.zCrICSw74ru', 'MarkkuAllen', NULL, NULL),
(138, 2, 'Baba', 'Baba', '$2y$10$vtwWLHyTuv66dVqbN9P2ROW2ggCkvziNnuyex0BJUjpayK87Y6rZS', 'BabaBaba', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(139, 2, 'Jan', 'Janko', '$2y$10$el5wfBowldkJDPSwgwIQFOVxdyvKBBqg1zrnttg.vDcyzHEsBOWam', 'JanJanko', NULL, NULL),
(140, 0, 'Žan', 'Šuperger', '$2y$10$hbx0j5KmfOXjOIyZAzdDC.iibC5ujlnZEmNMhDRQ2qSAFnihbRGoa', 'ŽanSuperger', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(141, 2, 'Žan', 'Župa', '$2y$10$SLE/8CkvoVokzp6M0x5/5eQtF2rBs1dXEuTxBIeOamSPnRigaX1JK', 'ŽanŽupa', NULL, NULL),
(142, 1, 'Alan', 'Jackson', '$2y$10$41sJlDfFKiE5my5Xyhtf0ePIbx1SEmPsMJ0Y2vxwO.5noUJeD3SPe', 'AlanJackson', NULL, 'png'),
(143, 2, 'bobi', 'bošnjak', '$2y$10$RjdTXiQuizWqykzDwq69PO9x.4iJ2IBu2anFVRgHE2OSD1Wg3BruW', 'BobiBošnjak', 'A friendly account with ID 143.', 'png'),
(144, 2, 'Maj', 'Zabukovnik', '$2y$10$YyJctyRWRxVmxo6bGteRyeR/mRafn6cL5sDWH7rKqV5aID7fJ2/LS', 'MajZabukovnik', '[uporabnik ni dodal dodatnih informacij]', 'png'),
(145, 2, 'Niggi', 'Siptar', '$2y$10$3oRbFi5PF/TOrcq/Vx71YODE88yovVWERaaxE.acZWLdH7505I8Zi', 'NiggiSiptar', NULL, NULL),
(146, 0, 'Faruk', 'Užičanin', '$2y$10$QtpBlp9kNrItA6424JvmH.u0kZgyKRQ5datlkMZ8rkVV9xHJrO/x.', 'FarukUžičanin', '[ 8:25\r\n10/11\r\n:) ]', 'png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradiva`
--
ALTER TABLE `gradiva`
  ADD PRIMARY KEY (`id_gradiva`),
  ADD KEY `id_modula` (`id_modula`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_modula`),
  ADD KEY `id_predmet` (`id_predmet`);

--
-- Indexes for table `oddaja`
--
ALTER TABLE `oddaja`
  ADD PRIMARY KEY (`id_oddaja`),
  ADD KEY `ID_GRADIVO_ODDAJA_FK` (`id_gradiva`) USING BTREE,
  ADD KEY `ID_USER_ODDAJA_FK` (`id_user`) USING BTREE;

--
-- Indexes for table `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id_predmet`);

--
-- Indexes for table `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD PRIMARY KEY (`id_predmet`),
  ADD KEY `fk_user_id` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gradiva`
--
ALTER TABLE `gradiva`
  MODIFY `id_gradiva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `id_modula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `oddaja`
--
ALTER TABLE `oddaja`
  MODIFY `id_oddaja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ucilnica`
--
ALTER TABLE `ucilnica`
  MODIFY `id_predmet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gradiva`
--
ALTER TABLE `gradiva`
  ADD CONSTRAINT `id_modula` FOREIGN KEY (`id_modula`) REFERENCES `model` (`id_modula`);

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);

--
-- Constraints for table `oddaja`
--
ALTER TABLE `oddaja`
  ADD CONSTRAINT `id_gradiva` FOREIGN KEY (`id_gradiva`) REFERENCES `gradiva` (`id_gradiva`),
  ADD CONSTRAINT `oddaja_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `id_predmet` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
