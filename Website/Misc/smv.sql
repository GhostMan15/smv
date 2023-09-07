-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2023 at 08:30 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
  `id_modela` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `id_modela` int(11) NOT NULL,
  `id_predmet` int(11) DEFAULT NULL,
  `Naslov` varchar(255) NOT NULL,
  `Opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predmeti`
--

CREATE TABLE `predmeti` (
  `id_predmet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ucilnica`
--

CREATE TABLE `ucilnica` (
  `id_predmet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_type` int(11) DEFAULT NULL CHECK (`user_type` in (0,1,2)),
  `ime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `priimek` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `geslo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`) VALUES
(1, 2, 'Liam', 'Smith', 'password1'),
(2, 2, 'Olivia', 'Johnson', 'password1'),
(3, 2, 'Noah', 'Williams', 'password1'),
(4, 2, 'Emma', 'Brown', 'password1'),
(5, 2, 'Sophia', 'Jones', 'password1'),
(6, 2, 'Mason', 'Garcia', 'password1'),
(7, 2, 'Isabella', 'Davis', 'password1'),
(8, 2, 'Logan', 'Miller', 'password1'),
(9, 2, 'Oliver', 'Martinez', 'password1'),
(10, 2, 'Ava', 'Hernandez', 'password1'),
(11, 2, 'Elijah', 'Lopez', 'password1'),
(12, 2, 'Charlotte', 'Gonzalez', 'password1'),
(13, 2, 'Aiden', 'Perez', 'password1'),
(14, 2, 'Grace', 'Wilson', 'password1'),
(15, 2, 'Lucas', 'Anderson', 'password1'),
(16, 2, 'Harper', 'Taylor', 'password1'),
(17, 2, 'Henry', 'Moore', 'password1'),
(18, 2, 'Ella', 'Jackson', 'password1'),
(19, 2, 'Benjamin', 'Garcia', 'password1'),
(20, 2, 'Scarlett', 'Brown', 'password1'),
(21, 1, 'John', 'Doe', 'password2'),
(22, 1, 'Alice', 'Smith', 'password2'),
(23, 1, 'Michael', 'Johnson', 'password2'),
(24, 1, 'Emily', 'Brown', 'password2'),
(25, 1, 'Daniel', 'Lee', 'password2'),
(26, 1, 'Sarah', 'Davis', 'password2'),
(27, 1, 'Matthew', 'Miller', 'password2'),
(28, 1, 'Olivia', 'Wilson', 'password2'),
(29, 1, 'Christopher', 'Moore', 'password2'),
(30, 1, 'Ava', 'Taylor', 'password2'),
(31, 1, 'Andrew', 'Anderson', 'password2'),
(32, 1, 'Sophia', 'Jackson', 'password2'),
(33, 1, 'William', 'Martinez', 'password2'),
(34, 1, 'Isabella', 'Hernandez', 'password2'),
(35, 1, 'Joseph', 'Garcia', 'password2'),
(36, 1, 'Emma', 'Lopez', 'password2'),
(37, 1, 'James', 'Perez', 'password2'),
(38, 1, 'Mia', 'Gonzalez', 'password2'),
(39, 1, 'David', 'Rodriguez', 'password2'),
(40, 1, 'Ella', 'Wilson', 'password2'),
(41, 2, 'Isabella ', 'Hunt', 'password2'),
(42, 2, 'Halima ', 'Hubbard', 'password2'),
(43, 2, 'Hazel', 'Farley', 'password2'),
(44, 2, 'Xander', 'Barber', 'password2'),
(45, 2, 'Deacon ', 'Rodgers', 'password2'),
(46, 2, 'Kacper', 'Petersen', 'password2'),
(47, 2, 'Mikey ', ' Bean', 'password2'),
(48, 2, 'Florence', 'Cruz', 'password2'),
(49, 2, 'Gethin ', 'Stephens', 'password2'),
(50, 2, 'Dale', 'Solomon', 'password2'),
(51, 2, 'Chelsea', 'Cox', 'password2'),
(52, 2, 'Bruno ', 'Joyce', 'password2'),
(53, 2, 'Keaton ', 'Griffin', 'password2'),
(54, 2, 'Habiba', ' Crawford', 'password2'),
(55, 2, 'Freya', 'Hahn', 'password2'),
(56, 2, 'Myles', 'Kirby', 'password2'),
(57, 2, 'Ruben ', 'Mckinney', 'password2'),
(58, 2, 'Chaya', 'Fields', 'password2'),
(59, 2, 'Kirsty ', ' Jones', 'password2'),
(60, 2, 'Kiran', 'Klein', 'password2'),
(61, 2, 'Joao', 'Graham', 'password2'),
(62, 2, 'Lucie ', 'Villegas', 'password2'),
(63, 2, 'Richie ', 'Meyer', 'password2'),
(64, 2, 'Adele ', 'Grant', 'password2'),
(65, 2, 'Milton', 'Greer', 'password2'),
(66, 2, 'Wyatt', 'Hunter', 'password2'),
(67, 2, 'Zaynah ', ' Barnes', 'password2'),
(68, 2, 'Syeda', ' Hendricks', 'password2'),
(69, 2, 'Meredith', 'Santiago', 'password2'),
(70, 2, 'Abigail ', ' Mullen', 'password2'),
(71, 2, 'Zaara', 'Conway', 'password2'),
(73, 2, 'Travis ', 'Kelley', 'password2'),
(74, 2, 'Muhammad', 'Patton', 'password2'),
(75, 2, 'Kira', 'Mitchell', 'password2'),
(76, 2, 'Iestyn ', 'Iestyn', 'password2'),
(77, 2, 'Danielle ', 'Logan', 'password2'),
(78, 2, 'Aaliyah', 'Dunlap', 'password2'),
(79, 2, 'Juan ', 'Blaese', 'password2'),
(80, 2, 'Malachy ', 'Williamson', 'password2'),
(81, 2, 'Celine', 'Blake', 'password2'),
(82, 2, 'Joshua', ' Lucero', 'password2'),
(83, 2, 'Marilyn', 'Duke', 'password2'),
(84, 2, 'Lorna ', 'Johns', 'password2'),
(85, 2, 'Adam ', ' Willis', 'password2'),
(86, 2, 'Neha ', 'Owens', 'password2'),
(87, 2, 'Sahar', ' Riggs', 'password2'),
(88, 2, 'Dexter', 'Thomson', 'password2'),
(89, 2, 'Rocco ', 'Friedman', 'password2'),
(90, 2, 'Keira ', 'Crane', 'password2'),
(91, 2, 'Krish', 'Hines', 'password2'),
(92, 2, 'Niamh ', 'Palmer', 'password2'),
(93, 2, 'Teddy', ' Gaines', 'password2'),
(94, 2, 'Philip ', 'Norton', 'password2'),
(95, 2, 'Kelsey', ' Booth', 'password2'),
(96, 2, 'Kaleb', ' Walls', 'password2'),
(97, 2, 'Valentina', 'Phillips', 'password2'),
(98, 2, 'Lily-Mae', 'Bolton', 'password2'),
(99, 2, 'Kaitlin', 'Dickson', 'password2'),
(100, 2, 'Adrian', 'Baldwin', 'password2'),
(101, 2, 'Iwan ', ' Sosa', 'password2'),
(102, 2, 'Constance', 'Khan', 'password2'),
(103, 2, 'Erik', 'Jenkins', 'password2'),
(104, 2, 'Clayton ', 'Valenzuela', 'password2'),
(105, 2, 'Keeley', 'Hernandez', 'password2'),
(106, 2, 'Raymond', 'Ramos', 'password2'),
(107, 2, 'Lara ', 'Shannon', 'password2'),
(108, 2, 'Oliwier ', 'Mccann', 'password2'),
(109, 2, 'Louise ', 'Ball', 'password2'),
(110, 2, 'Dennis', 'Romero', 'password2'),
(111, 2, 'Leslie ', ' Adams', 'password2'),
(112, 2, 'Aliyah', 'York', 'password2'),
(113, 2, 'Eliot ', 'Phelps', 'password2'),
(114, 2, 'Regan', 'Mcknight', 'password2'),
(115, 2, 'Bryony', ' Diaz', 'password2'),
(116, 2, 'Shannon', 'Mason', 'password2'),
(117, 2, 'Nia', 'Coleman', 'password2'),
(118, 2, 'Monty', 'Russo', 'password2'),
(119, 2, 'Luke ', 'Barr', 'password2'),
(120, 2, 'Kelly ', 'John', 'password2'),
(121, 0, 'Mark', 'Sadnk', 'markec'),
(122, 0, 'Žan', 'Šuperger', 'zanci'),
(123, 0, 'Faruk', 'Užičanin', 'rofl');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradiva`
--
ALTER TABLE `gradiva`
  ADD PRIMARY KEY (`id_gradiva`),
  ADD KEY `id_modela` (`id_modela`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_modela`),
  ADD KEY `id_predmet` (`id_predmet`);

--
-- Indexes for table `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id_predmet`);

--
-- Indexes for table `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD PRIMARY KEY (`id_predmet`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gradiva`
--
ALTER TABLE `gradiva`
  ADD CONSTRAINT `gradiva_ibfk_1` FOREIGN KEY (`id_modela`) REFERENCES `model` (`id_modela`);

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);

--
-- Constraints for table `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD CONSTRAINT `ucilnica_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
