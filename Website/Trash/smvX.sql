-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2023 at 09:47 AM
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
(146, 0, 'Faruk', 'Užičanin', '$2y$10$QtpBlp9kNrItA6424JvmH.u0kZgyKRQ5datlkMZ8rkVV9xHJrO/x.', 'FarukUžičanin', '[ 8:25\r\n10/11\r\n:) ]', 'png'),
(147, 1, 'Toby', 'Keith', '$2y$10$3d4K8jpnw3KlGfQn.nc5oObZFRgcyw7/zGOSVEzx5duvkw5aHufX.', 'TobyKeith', NULL, NULL),
(148, 1, 'Morgan', 'Wallen', '$2y$10$OSNUzOIp2joG6DrRGrDwjO0Oh8EqxyHFYf58VSLLeuQOJs7VrASEa', 'MorganWallen', NULL, NULL),
(149, 2, 'Don', 'Williams', '$2y$10$IXNoBAAZJd037uQLmsBtjeriT8WRE9TuigT1nq4j22eH6ZDW5rqTK', 'DonWilliams', NULL, NULL),
(150, 1, 'George', 'Strait', '$2y$10$A/WIo1Ev2eauGyPiW4mfvufG6F22/VJcugM1anYIk74ftlIWctFxC', 'GeorgeStrait', NULL, NULL),
(151, 1, 'Aaron', 'Watson', '$2y$10$68vIz8Eh.5R8W10Z8NX.jOAvOM/YJopoPiwaNgj6MWcp14Gd5VIOC', 'AaronWatson', NULL, NULL),
(152, 1, 'Luke', 'Brayn', '$2y$10$RZw2q1prfz7s/V11BnQ3u.mW9yXONeBtusw5e6BdgVroowX1/0RzO', 'LukeBrayn', NULL, NULL),
(153, 1, 'Wheeler', 'Walker', '$2y$10$fkgmDbA9W/1pv3yWlRGZDuJlh9OrsX8qhjiQHh0Yqb4zyQF913jee', 'WheelerWalker', NULL, NULL),
(154, 1, 'Jimmy', 'Clifton', '$2y$10$ZkWuzU35UEzZ/AvjiGggw.U3sje9p5pCMMyVAPWAcHo2s0fWQmUnW', 'JimmyClifton', NULL, NULL),
(155, 1, 'Matt', 'Manson', '$2y$10$WqI502InIHj4ANwHv87So.P50MngOsvOZ97z9THJm3lowUKF1TrEq', 'MattManson', NULL, NULL),
(156, 1, 'Ryan', 'Curtis', '$2y$10$6KEFVXD8hUg1Gh8zTOYED.RjChEMz4XIgXtcxq7m4EJ96Z2em.SZ.', 'RyanCurtis', NULL, NULL),
(157, 2, 'Chris', 'Tolmin', '$2y$10$95wzjdLIODY5MwOBSavlKOxyWajaCAD8npTJk7uIMpD6tIxvPsOS6', 'ChrisTolmin', NULL, NULL),
(158, 2, 'Sandor', 'Gavin', '$2y$10$UzBXv3aPIiQVbxn7rFG3husrWi36.hkww./QPZ7n/u/JLHZpzxrXC', 'SandorGavin', NULL, NULL),
(159, 2, 'Clay', 'Walker', '$2y$10$31lz7L/orp9X9aansEYulefcaTQ5Q380DUTJbRKsTo4A9gUOyHZ7q', 'ClayWalker', NULL, NULL),
(160, 2, 'Randy', 'Houser', '$2y$10$yhC3YyIt9zwbvpaG65IeL.BzgxwaDVJkcRlAxXDeC2AQfgbWeI0tW', 'RandyHouser', NULL, NULL),
(161, 2, 'Travis', 'Tritt', '$2y$10$NAuvxkgxe5IFTWwc2sBkS.1nq.6MSmUNJdIzJPI6zKqpd2QvDYbKW', 'TravisTritt', NULL, NULL),
(162, 2, 'Eston', 'Corbin', '$2y$10$2XT7gEY4O9w8crE2eBk9dOUeGqJY/MbS8GIB1zC1dq.Zce2Yn5Jey', 'EstonCorbin', NULL, NULL),
(163, 2, 'Casey', 'Donahew', '$2y$10$VH1U44ifuLhipuhigR6mreOkWbQgXTAjrIyIL0dSWUA4HXG34EBBe', 'CaseyDonahew', NULL, NULL),
(164, 2, 'Craig', 'Morgan', '$2y$10$FTqIJjfUlz2BCRpbhJucG.mFhv8Rt8OwzgHWNo8pM6XUEEvY8WBOK', 'CraigMorgan', NULL, NULL),
(165, 2, 'Riley', 'Green', '$2y$10$ykxiCw464ofSstVLcshlBeeDvb4cDU3R8zz/mmN.2obeIH8jLgP9a', 'RileyGreen', NULL, NULL),
(166, 2, 'Josh', 'Ward', '$2y$10$NCz1LoVhxY1YbulOftePnea50Q0eWDlp4pw3oUzzGtGwF4gRaEa4i', 'JoshWard', NULL, NULL),
(167, 2, 'Rodney', 'Atkins', '$2y$10$2uiUJp68CC4m72w120HhhOHj.cv64r0PLIJOpVJJrjlCPRqlydjda', 'RodneyAtkins', NULL, NULL),
(168, 2, 'Cody', 'Jinks', '$2y$10$EK6.//.poZmkuqhtXk36juMdmLAHSM7.FDCUGYPLfYM6p1H5SjV/a', 'CodyJinks', NULL, NULL),
(169, 2, 'Dierks', 'Benetley', '$2y$10$/x81io58NQ3shldIXSf5J.oGKE8tmNrbmioleEvTGiW/SRbKR2CGS', 'DierksBenetley', NULL, NULL),
(170, 2, 'Gray', 'Allan', '$2y$10$l8lYNW2OKTZnyMlc6Jf9MebcL0w9N3lz2Z1WCNJ./TH8qymvj3/tK', 'GrayAllan', NULL, NULL),
(171, 2, 'Pat', 'Green', '$2y$10$xjQmAFpy16dvynhq9EJFUO.JEbJZjVmYMl9a2YTbU7gPRp8T7hFZe', 'PatGreen', NULL, NULL),
(172, 2, 'Chris', 'Patt', '$2y$10$dQofg6XpTJ/R5PMBQVL5AuunliqMGG/dw7Qmd71Bcw2Dn8hSz8ft2', 'ChrisPatt', NULL, NULL),
(173, 2, 'Cody', 'Hibbard', '$2y$10$xLxmY0iRSgyngIgDPcCEiOTwrinP8nnNBJVODcYR8nX8AIH8XKAcy', 'CodyHibbard', NULL, NULL),
(174, 2, 'Randall', 'King', '$2y$10$.aGHtfxKdgcnFzoz.duPl.COhy2pIlsqQstkY2HKgkO.Txm/uA/uC', 'RandallKing', NULL, NULL),
(175, 2, 'Jamey', 'Johnson', '$2y$10$0qdcmGv3zYEykfTacQ/i9ORpw8AnEvm38E.B6Jh4yO3bJn1cnA.UK', 'JameyJohnson', NULL, NULL),
(176, 2, 'Chris', 'Young', '$2y$10$9V5RNehgjqDRzF7Nw5Y6.euyIEav75IfSoWifBlH1Xu6M6PLbI34C', 'ChrisYoung', NULL, NULL);

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
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

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
