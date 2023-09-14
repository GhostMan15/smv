-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 14. sep 2023 ob 18.44
-- Različica strežnika: 10.4.27-MariaDB
-- Različica PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `smv`
--

-- --------------------------------------------------------

--
-- Struktura tabele `gradiva`
--

CREATE TABLE `gradiva` (
  `id_gradiva` int(11) NOT NULL,
  `id_modela` int(11) DEFAULT NULL,
  `oddaja` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `model`
--

CREATE TABLE `model` (
  `id_modula` int(11) NOT NULL,
  `id_predmet` int(11) DEFAULT NULL,
  `Naslov` varchar(255) NOT NULL,
  `Opis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `predmeti`
--

CREATE TABLE `predmeti` (
  `id_predmet` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `kratica` varchar(5) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `ucilnica`
--

CREATE TABLE `ucilnica` (
  `id_predmet` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_type` int(11) DEFAULT 2 CHECK (`user_type` in (0,1,2)),
  `ime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `priimek` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `geslo` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`) VALUES
(1, 2, 'Liam', 'Smith', 'password1', 'LiamSmith', NULL),
(2, 2, 'Olivia', 'Johnson', 'password1', 'OliviaJohnson', NULL),
(3, 2, 'Noah', 'Williams', 'password1', 'NoahWilliams', NULL),
(4, 2, 'Emma', 'Brown', 'password1', 'EmmaBrown', NULL),
(5, 2, 'Sophia', 'Jones', 'password1', 'SophiaJones', NULL),
(6, 2, 'Mason', 'Garcia', 'password1', 'MasonGarcia', NULL),
(7, 2, 'Isabella', 'Davis', 'password1', 'IsabellaDavis', NULL),
(8, 2, 'Logan', 'Miller', 'password1', 'LoganMiller', NULL),
(9, 2, 'Oliver', 'Martinez', 'password1', 'OliverMartinez', NULL),
(10, 2, 'Ava', 'Hernandez', 'password1', 'AvaHernandez', NULL),
(11, 2, 'Elijah', 'Lopez', 'password1', 'ElijahLopez', NULL),
(12, 2, 'Charlotte', 'Gonzalez', 'password1', 'CharlotteGonzalez', NULL),
(13, 2, 'Aiden', 'Perez', 'password1', 'AidenPerez', NULL),
(14, 2, 'Grace', 'Wilson', 'password1', 'GraceWilson', NULL),
(15, 2, 'Lucas', 'Anderson', 'password1', 'LucasAnderson', NULL),
(16, 2, 'Harper', 'Taylor', 'password1', 'HarperTaylor', NULL),
(17, 2, 'Henry', 'Moore', 'password1', 'HenryMoore', NULL),
(18, 2, 'Ella', 'Jackson', 'password1', 'EllaJackson', NULL),
(19, 2, 'Benjamin', 'Garcia', 'password1', 'BenjaminGarcia', NULL),
(20, 2, 'Scarlett', 'Brown', 'password1', 'ScarlettBrown', NULL),
(21, 1, 'John', 'Doe', 'password2', 'JohnDoe', NULL),
(22, 1, 'Alice', 'Smith', 'password2', 'AliceSmith', NULL),
(23, 1, 'Michael', 'Johnson', 'password2', 'MichaelJohnson', NULL),
(24, 1, 'Emily', 'Brown', 'password2', 'EmilyBrown', NULL),
(25, 1, 'Daniel', 'Lee', 'password2', 'DanielLee', NULL),
(26, 1, 'Sarah', 'Davis', 'password2', 'SarahDavis', NULL),
(27, 1, 'Matthew', 'Miller', 'password2', 'MatthewMiller', NULL),
(28, 1, 'Olivia', 'Wilson', 'password2', 'OliviaWilson', NULL),
(29, 1, 'Christopher', 'Moore', 'password2', 'ChristopherMoore', NULL),
(30, 1, 'Ava', 'Taylor', 'password2', 'AvaTaylor', NULL),
(31, 1, 'Andrew', 'Anderson', 'password2', 'AndrewAnderson', NULL),
(32, 1, 'Sophia', 'Jackson', 'password2', 'SophiaJackson', NULL),
(33, 1, 'William', 'Martinez', 'password2', 'WilliamMartinez', NULL),
(34, 1, 'Isabella', 'Hernandez', 'password2', 'IsabellaHernandez', NULL),
(35, 1, 'Joseph', 'Garcia', 'password2', 'JosephGarcia', NULL),
(36, 1, 'Emma', 'Lopez', 'password2', 'EmmaLopez', NULL),
(37, 1, 'James', 'Perez', 'password2', 'JamesPerez', NULL),
(38, 1, 'Mia', 'Gonzalez', 'password2', 'MiaGonzalez', NULL),
(39, 1, 'David', 'Rodriguez', 'password2', 'DavidRodriguez', NULL),
(40, 1, 'Ella', 'Wilson', 'password2', 'EllaWilson', NULL),
(41, 2, 'Isabella ', 'Hunt', 'password2', 'Isabella Hunt', NULL),
(42, 2, 'Halima ', 'Hubbard', 'password2', 'Halima Hubbard', NULL),
(43, 2, 'Hazel', 'Farley', 'password2', 'HazelFarley', NULL),
(44, 2, 'Xander', 'Barber', 'password2', 'XanderBarber', NULL),
(45, 2, 'Deacon ', 'Rodgers', 'password2', 'Deacon Rodgers', NULL),
(46, 2, 'Kacper', 'Petersen', 'password2', 'KacperPetersen', NULL),
(47, 2, 'Mikey ', ' Bean', 'password2', 'Mikey  Bean', NULL),
(48, 2, 'Florence', 'Cruz', 'password2', 'FlorenceCruz', NULL),
(49, 2, 'Gethin ', 'Stephens', 'password2', 'Gethin Stephens', NULL),
(50, 2, 'Dale', 'Solomon', 'password2', 'DaleSolomon', NULL),
(51, 2, 'Chelsea', 'Cox', 'password2', 'ChelseaCox', NULL),
(52, 2, 'Bruno ', 'Joyce', 'password2', 'Bruno Joyce', NULL),
(53, 2, 'Keaton ', 'Griffin', 'password2', 'Keaton Griffin', NULL),
(54, 2, 'Habiba', ' Crawford', 'password2', 'Habiba Crawford', NULL),
(55, 2, 'Freya', 'Hahn', 'password2', 'FreyaHahn', NULL),
(56, 2, 'Myles', 'Kirby', 'password2', 'MylesKirby', NULL),
(57, 2, 'Ruben ', 'Mckinney', 'password2', 'Ruben Mckinney', NULL),
(58, 2, 'Chaya', 'Fields', 'password2', 'ChayaFields', NULL),
(59, 2, 'Kirsty ', ' Jones', 'password2', 'Kirsty  Jones', NULL),
(60, 2, 'Kiran', 'Klein', 'password2', 'KiranKlein', NULL),
(61, 2, 'Joao', 'Graham', 'password2', 'JoaoGraham', NULL),
(62, 2, 'Lucie ', 'Villegas', 'password2', 'Lucie Villegas', NULL),
(63, 2, 'Richie ', 'Meyer', 'password2', 'Richie Meyer', NULL),
(64, 2, 'Adele ', 'Grant', 'password2', 'Adele Grant', NULL),
(65, 2, 'Milton', 'Greer', 'password2', 'MiltonGreer', NULL),
(66, 2, 'Wyatt', 'Hunter', 'password2', 'WyattHunter', NULL),
(67, 2, 'Zaynah ', ' Barnes', 'password2', 'Zaynah  Barnes', NULL),
(68, 2, 'Syeda', ' Hendricks', 'password2', 'Syeda Hendricks', NULL),
(69, 2, 'Meredith', 'Santiago', 'password2', 'MeredithSantiago', NULL),
(70, 2, 'Abigail ', ' Mullen', 'password2', 'Abigail  Mullen', NULL),
(71, 2, 'Zaara', 'Conway', 'password2', 'ZaaraConway', NULL),
(73, 2, 'Travis ', 'Kelley', 'password2', 'Travis Kelley', NULL),
(74, 2, 'Muhammad', 'Patton', 'password2', 'MuhammadPatton', NULL),
(75, 2, 'Kira', 'Mitchell', 'password2', 'KiraMitchell', NULL),
(76, 2, 'Iestyn ', 'Iestyn', 'password2', 'Iestyn Iestyn', NULL),
(77, 2, 'Danielle ', 'Logan', 'password2', 'Danielle Logan', NULL),
(78, 2, 'Aaliyah', 'Dunlap', 'password2', 'AaliyahDunlap', NULL),
(79, 2, 'Juan ', 'Blaese', 'password2', 'Juan Blaese', NULL),
(80, 2, 'Malachy ', 'Williamson', 'password2', 'Malachy Williamson', NULL),
(81, 2, 'Celine', 'Blake', 'password2', 'CelineBlake', NULL),
(82, 2, 'Joshua', ' Lucero', 'password2', 'Joshua Lucero', NULL),
(83, 2, 'Marilyn', 'Duke', 'password2', 'MarilynDuke', NULL),
(84, 2, 'Lorna ', 'Johns', 'password2', 'Lorna Johns', NULL),
(85, 2, 'Adam ', ' Willis', 'password2', 'Adam  Willis', NULL),
(86, 2, 'Neha ', 'Owens', 'password2', 'Neha Owens', NULL),
(87, 2, 'Sahar', ' Riggs', 'password2', 'Sahar Riggs', NULL),
(88, 2, 'Dexter', 'Thomson', 'password2', 'DexterThomson', NULL),
(89, 2, 'Rocco ', 'Friedman', 'password2', 'Rocco Friedman', NULL),
(90, 2, 'Keira ', 'Crane', 'password2', 'Keira Crane', NULL),
(91, 2, 'Krish', 'Hines', 'password2', 'KrishHines', NULL),
(92, 2, 'Niamh ', 'Palmer', 'password2', 'Niamh Palmer', NULL),
(93, 2, 'Teddy', ' Gaines', 'password2', 'Teddy Gaines', NULL),
(94, 2, 'Philip ', 'Norton', 'password2', 'Philip Norton', NULL),
(95, 2, 'Kelsey', ' Booth', 'password2', 'Kelsey Booth', NULL),
(96, 2, 'Kaleb', ' Walls', 'password2', 'Kaleb Walls', NULL),
(97, 2, 'Valentina', 'Phillips', 'password2', 'ValentinaPhillips', NULL),
(98, 2, 'Lily-Mae', 'Bolton', 'password2', 'Lily-MaeBolton', NULL),
(99, 2, 'Kaitlin', 'Dickson', 'password2', 'KaitlinDickson', NULL),
(100, 2, 'Adrian', 'Baldwin', 'password2', 'AdrianBaldwin', NULL),
(101, 2, 'Iwan ', ' Sosa', 'password2', 'Iwan  Sosa', NULL),
(102, 2, 'Constance', 'Khan', 'password2', 'ConstanceKhan', NULL),
(103, 2, 'Erik', 'Jenkins', 'password2', 'ErikJenkins', NULL),
(104, 2, 'Clayton ', 'Valenzuela', 'password2', 'Clayton Valenzuela', NULL),
(105, 2, 'Keeley', 'Hernandez', 'password2', 'KeeleyHernandez', NULL),
(106, 2, 'Raymond', 'Ramos', 'password2', 'RaymondRamos', NULL),
(107, 2, 'Lara ', 'Shannon', 'password2', 'Lara Shannon', NULL),
(108, 2, 'Oliwier ', 'Mccann', 'password2', 'Oliwier Mccann', NULL),
(109, 2, 'Louise ', 'Ball', 'password2', 'Louise Ball', NULL),
(110, 2, 'Dennis', 'Romero', 'password2', 'DennisRomero', NULL),
(111, 2, 'Leslie ', ' Adams', 'password2', 'Leslie  Adams', NULL),
(112, 2, 'Aliyah', 'York', 'password2', 'AliyahYork', NULL),
(113, 2, 'Eliot ', 'Phelps', 'password2', 'Eliot Phelps', NULL),
(114, 2, 'Regan', 'Mcknight', 'password2', 'ReganMcknight', NULL),
(115, 2, 'Bryony', ' Diaz', 'password2', 'Bryony Diaz', NULL),
(116, 2, 'Shannon', 'Mason', 'password2', 'ShannonMason', NULL),
(117, 2, 'Nia', 'Coleman', 'password2', 'NiaColeman', NULL),
(118, 2, 'Monty', 'Russo', 'password2', 'MontyRusso', NULL),
(119, 2, 'Luke ', 'Barr', 'password2', 'Luke Barr', NULL),
(120, 2, 'Kelly ', 'John', 'password2', 'Kelly John', NULL),
(121, 0, 'Mark', 'Sadnk', 'markec', 'MarkSadnk', NULL),
(122, 0, 'Žan', 'Šuperger', 'zanci', 'ŽanŠuperger', NULL),
(123, 0, 'Faruk', 'Užičanin', 'rofl', 'FarukUžičanin', NULL);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `gradiva`
--
ALTER TABLE `gradiva`
  ADD PRIMARY KEY (`id_gradiva`),
  ADD KEY `id_modela` (`id_modela`);

--
-- Indeksi tabele `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_modula`),
  ADD KEY `id_predmet` (`id_predmet`);

--
-- Indeksi tabele `predmeti`
--
ALTER TABLE `predmeti`
  ADD PRIMARY KEY (`id_predmet`);

--
-- Indeksi tabele `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD PRIMARY KEY (`id_predmet`),
  ADD KEY `fk_user_id` (`id_user`);

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `gradiva`
--
ALTER TABLE `gradiva`
  ADD CONSTRAINT `gradiva_ibfk_1` FOREIGN KEY (`id_modela`) REFERENCES `model` (`id_modula`);

--
-- Omejitve za tabelo `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);

--
-- Omejitve za tabelo `ucilnica`
--
ALTER TABLE `ucilnica`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `ucilnica_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
