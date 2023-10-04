-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 26. sep 2023 ob 08.45
-- Različica strežnika: 10.4.27-MariaDB
-- Različica PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `smv1`
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
  `geslo` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `img_ext` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`, `img_ext`) VALUES
(1, 2, 'Liam', 'Smith', 'password1', 'LiamSmith', 'LiamSmith opis', 'png'),
(2, 2, 'Olivia', 'Johnson', 'password1', 'OliviaJohnson', 'Ba', 'png'),
(3, 2, 'Noah', 'Williams', 'password1', 'NoahWilliams', 'Ba', 'png'),
(4, 2, 'Emma', 'Brown', 'password1', 'EmmaBrown', 'Ba', 'png'),
(5, 2, 'Sophia', 'Jones', 'password1', 'SophiaJones', 'Ba', 'png'),
(6, 2, 'Mason', 'Garcia', 'password1', 'MasonGarcia', 'Ba', 'png'),
(7, 2, 'Isabella', 'Davis', 'password1', 'IsabellaDavis', 'Ba', 'png'),
(8, 2, 'Logan', 'Miller', 'password1', 'LoganMiller', 'Ba', 'png'),
(9, 2, 'Oliver', 'Martinez', 'password1', 'OliverMartinez', 'Ba', 'png'),
(10, 2, 'Ava', 'Hernandez', 'password1', 'AvaHernandez', 'Ba', 'png'),
(11, 2, 'Elijah', 'Lopez', 'password1', 'ElijahLopez', 'Ba', 'png'),
(12, 2, 'Charlotte', 'Gonzalez', 'password1', 'CharlotteGonzalez', 'Ba', 'png'),
(13, 2, 'Aiden', 'Perez', 'password1', 'AidenPerez', 'Ba', 'png'),
(14, 2, 'Grace', 'Wilson', 'password1', 'GraceWilson', 'Ba', 'png'),
(15, 2, 'Lucas', 'Anderson', 'password1', 'LucasAnderson', 'Ba', 'png'),
(16, 2, 'Harper', 'Taylor', 'password1', 'HarperTaylor', 'Ba', 'png'),
(17, 2, 'Henry', 'Moore', 'password1', 'HenryMoore', 'Ba', 'png'),
(18, 2, 'Ella', 'Jackson', 'password1', 'EllaJackson', 'Ba', 'png'),
(19, 2, 'Benjamin', 'Garcia', 'password1', 'BenjaminGarcia', 'Ba', 'png'),
(20, 2, 'Scarlett', 'Brown', 'password1', 'ScarlettBrown', 'Ba', 'png'),
(21, 1, 'John', 'Doe', 'password1', 'JohnDoe', 'Ba', 'png'),
(22, 1, 'Alice', 'Smith', 'password1', 'AliceSmith', 'Ba', 'png'),
(23, 1, 'Michael', 'Johnson', 'password1', 'MichaelJohnson', 'Ba', 'png'),
(24, 1, 'Emily', 'Brown', 'password1', 'EmilyBrown', 'Ba', 'png'),
(25, 1, 'Daniel', 'Lee', 'password1', 'DanielLee', 'Ba', 'png'),
(26, 1, 'Sarah', 'Davis', 'password1', 'SarahDavis', 'Ba', 'png'),
(27, 1, 'Matthew', 'Miller', 'password1', 'MatthewMiller', 'Ba', 'png'),
(28, 1, 'Olivia', 'Wilson', 'password1', 'OliviaWilson', 'Ba', 'png'),
(29, 1, 'Christopher', 'Moore', 'password1', 'ChristopherMoore', 'Ba', 'png'),
(30, 1, 'Ava', 'Taylor', 'password1', 'AvaTaylor', 'Ba', 'png'),
(31, 1, 'Andrew', 'Anderson', 'password1', 'AndrewAnderson', 'Ba', 'png'),
(32, 1, 'Sophia', 'Jackson', 'password1', 'SophiaJackson', 'Ba', 'png'),
(33, 1, 'William', 'Martinez', 'password1', 'WilliamMartinez', 'Ba', 'png'),
(34, 1, 'Isabella', 'Hernandez', 'password1', 'IsabellaHernandez', 'Ba', 'png'),
(35, 1, 'Joseph', 'Garcia', 'password1', 'JosephGarcia', 'Ba', 'png'),
(36, 1, 'Emma', 'Lopez', 'password1', 'EmmaLopez', 'Ba', 'png'),
(37, 1, 'James', 'Perez', 'password1', 'JamesPerez', 'Ba', 'png'),
(38, 1, 'Mia', 'Gonzalez', 'password1', 'MiaGonzalez', 'Ba', 'png'),
(39, 1, 'David', 'Rodriguez', 'password1', 'DavidRodriguez', 'Ba', 'png'),
(40, 1, 'Ella', 'Wilson', 'password1', 'EllaWilson', 'Ba', 'png'),
(41, 2, 'Isabella ', 'Hunt', 'password1', 'Isabella Hunt', 'Ba', 'png'),
(42, 2, 'Halima ', 'Hubbard', 'password1', 'Halima Hubbard', 'Ba', 'png'),
(43, 2, 'Hazel', 'Farley', 'password1', 'HazelFarley', 'Ba', 'png'),
(44, 2, 'Xander', 'Barber', 'password1', 'XanderBarber', 'Ba', 'png'),
(45, 2, 'Deacon ', 'Rodgers', 'password1', 'Deacon Rodgers', 'Ba', 'png'),
(46, 2, 'Kacper', 'Petersen', 'password1', 'KacperPetersen', 'Ba', 'png'),
(47, 2, 'Mikey ', ' Bean', 'password1', 'Mikey  Bean', 'Ba', 'png'),
(48, 2, 'Florence', 'Cruz', 'password1', 'FlorenceCruz', 'Ba', 'png'),
(49, 2, 'Gethin ', 'Stephens', 'password1', 'Gethin Stephens', 'Ba', 'png'),
(50, 2, 'Dale', 'Solomon', 'password1', 'DaleSolomon', 'Ba', 'png'),
(51, 2, 'Chelsea', 'Cox', 'password1', 'ChelseaCox', 'Ba', 'png'),
(52, 2, 'Bruno ', 'Joyce', 'password1', 'Bruno Joyce', 'Ba', 'png'),
(53, 2, 'Keaton ', 'Griffin', 'password1', 'Keaton Griffin', 'Ba', 'png'),
(54, 2, 'Habiba', ' Crawford', 'password1', 'Habiba Crawford', 'Ba', 'png'),
(55, 2, 'Freya', 'Hahn', 'password1', 'FreyaHahn', 'Ba', 'png'),
(56, 2, 'Myles', 'Kirby', 'password1', 'MylesKirby', 'Ba', 'png'),
(57, 2, 'Ruben ', 'Mckinney', 'password1', 'Ruben Mckinney', 'Ba', 'png'),
(58, 2, 'Chaya', 'Fields', 'password1', 'ChayaFields', 'Ba', 'png'),
(59, 2, 'Kirsty ', ' Jones', 'password1', 'Kirsty  Jones', 'Ba', 'png'),
(60, 2, 'Kiran', 'Klein', 'password1', 'KiranKlein', 'Ba', 'png'),
(61, 2, 'Joao', 'Graham', 'password1', 'JoaoGraham', 'Ba', 'png'),
(62, 2, 'Lucie ', 'Villegas', 'password1', 'Lucie Villegas', 'Ba', 'png'),
(63, 2, 'Richie ', 'Meyer', 'password1', 'Richie Meyer', 'Ba', 'png'),
(64, 2, 'Adele ', 'Grant', 'password1', 'Adele Grant', 'Ba', 'png'),
(65, 2, 'Milton', 'Greer', 'password1', 'MiltonGreer', 'Ba', 'png'),
(66, 2, 'Wyatt', 'Hunter', 'password1', 'WyattHunter', 'Ba', 'png'),
(67, 2, 'Zaynah ', ' Barnes', 'password1', 'Zaynah  Barnes', 'Ba', 'png'),
(68, 2, 'Syeda', ' Hendricks', 'password1', 'Syeda Hendricks', 'Ba', 'png'),
(69, 2, 'Meredith', 'Santiago', 'password1', 'MeredithSantiago', 'Ba', 'png'),
(70, 2, 'Abigail ', ' Mullen', 'password1', 'Abigail  Mullen', 'Ba', 'png'),
(71, 2, 'Zaara', 'Conway', 'password1', 'ZaaraConway', 'Ba', 'png'),
(73, 2, 'Travis ', 'Kelley', 'password1', 'Travis Kelley', 'Ba', 'png'),
(74, 2, 'Muhammad', 'Patton', 'password1', 'MuhammadPatton', 'Ba', 'png'),
(75, 2, 'Kira', 'Mitchell', 'password1', 'KiraMitchell', 'Ba', 'png'),
(76, 2, 'Iestyn ', 'Iestyn', 'password1', 'Iestyn Iestyn', 'Ba', 'png'),
(77, 2, 'Danielle ', 'Logan', 'password1', 'Danielle Logan', 'Ba', 'png'),
(78, 2, 'Aaliyah', 'Dunlap', 'password1', 'AaliyahDunlap', 'Ba', 'png'),
(79, 2, 'Juan ', 'Blaese', 'password1', 'Juan Blaese', 'Ba', 'png'),
(80, 2, 'Malachy ', 'Williamson', 'password1', 'Malachy Williamson', 'Ba', 'png'),
(81, 2, 'Celine', 'Blake', 'password1', 'CelineBlake', 'Ba', 'png'),
(82, 2, 'Joshua', ' Lucero', 'password1', 'Joshua Lucero', 'Ba', 'png'),
(83, 2, 'Marilyn', 'Duke', 'password1', 'MarilynDuke', 'Ba', 'png'),
(84, 2, 'Lorna ', 'Johns', 'password1', 'Lorna Johns', 'Ba', 'png'),
(85, 2, 'Adam ', ' Willis', 'password1', 'Adam  Willis', 'Ba', 'png'),
(86, 2, 'Neha ', 'Owens', 'password1', 'Neha Owens', 'Ba', 'png'),
(87, 2, 'Sahar', ' Riggs', 'password1', 'Sahar Riggs', 'Ba', 'png'),
(88, 2, 'Dexter', 'Thomson', 'password1', 'DexterThomson', 'Ba', 'png'),
(89, 2, 'Rocco ', 'Friedman', 'password1', 'Rocco Friedman', 'Ba', 'png'),
(90, 2, 'Keira ', 'Crane', 'password1', 'Keira Crane', 'Ba', 'png'),
(91, 2, 'Krish', 'Hines', 'password1', 'KrishHines', 'Ba', 'png'),
(92, 2, 'Niamh ', 'Palmer', 'password1', 'Niamh Palmer', 'Ba', 'png'),
(93, 2, 'Teddy', ' Gaines', 'password1', 'Teddy Gaines', 'Ba', 'png'),
(94, 2, 'Philip ', 'Norton', 'password1', 'Philip Norton', 'Ba', 'png'),
(95, 2, 'Kelsey', ' Booth', 'password1', 'Kelsey Booth', 'Ba', 'png'),
(96, 2, 'Kaleb', ' Walls', 'password1', 'Kaleb Walls', 'Ba', 'png'),
(97, 2, 'Valentina', 'Phillips', 'password1', 'ValentinaPhillips', 'Ba', 'png'),
(98, 2, 'Lily-Mae', 'Bolton', 'password1', 'Lily-MaeBolton', 'Ba', 'png'),
(99, 2, 'Kaitlin', 'Dickson', 'password1', 'KaitlinDickson', 'Ba', 'png'),
(100, 2, 'Adrian', 'Baldwin', 'password1', 'AdrianBaldwin', 'Ba', 'png'),
(101, 2, 'Iwan ', ' Sosa', 'password1', 'Iwan  Sosa', 'Ba', 'png'),
(102, 2, 'Constance', 'Khan', 'password1', 'ConstanceKhan', 'Ba', 'png'),
(103, 2, 'Erik', 'Jenkins', 'password1', 'ErikJenkins', 'Ba', 'png'),
(104, 2, 'Clayton ', 'Valenzuela', 'password1', 'Clayton Valenzuela', 'Ba', 'png'),
(105, 2, 'Keeley', 'Hernandez', 'password1', 'KeeleyHernandez', 'Ba', 'png'),
(106, 2, 'Raymond', 'Ramos', 'password1', 'RaymondRamos', 'Ba', 'png'),
(107, 2, 'Lara ', 'Shannon', 'password1', 'Lara Shannon', 'Ba', 'png'),
(108, 2, 'Oliwier ', 'Mccann', 'password1', 'Oliwier Mccann', 'Ba', 'png'),
(109, 2, 'Louise ', 'Ball', 'password1', 'Louise Ball', 'Ba', 'png'),
(110, 2, 'Dennis', 'Romero', 'password1', 'DennisRomero', 'Ba', 'png'),
(111, 2, 'Leslie ', ' Adams', 'password1', 'Leslie  Adams', 'Ba', 'png'),
(112, 2, 'Aliyah', 'York', 'password1', 'AliyahYork', 'Ba', 'png'),
(113, 2, 'Eliot ', 'Phelps', 'password1', 'Eliot Phelps', 'Ba', 'png'),
(114, 2, 'Regan', 'Mcknight', 'password1', 'ReganMcknight', 'Ba', 'png'),
(115, 2, 'Bryony', ' Diaz', 'password1', 'Bryony Diaz', 'Ba', 'png'),
(116, 2, 'Shannon', 'Mason', 'password1', 'ShannonMason', 'Ba', 'png'),
(117, 2, 'Nia', 'Coleman', 'password1', 'NiaColeman', 'Ba', 'png'),
(118, 2, 'Monty', 'Russo', 'password1', 'MontyRusso', 'Ba', 'png'),
(119, 2, 'Luke ', 'Barr', 'password1', 'Luke Barr', 'Ba', 'png'),
(120, 2, 'Kelly ', 'John', 'password1', 'Kelly John', 'Ba', 'png'),
(121, 0, 'Mark', 'Sadnk', 'password1', 'MarkSadnk', 'Ba', 'png'),
(122, 0, 'Žan', 'Šuperger', 'password1', 'ŽanŠuperger', 'Ba', 'png'),
(123, 0, 'Faruk', 'Užičanin', 'password1', 'FarukUžičanin', 'Ba', 'png');

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
ADD user_type int not null;

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id_predmet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

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
