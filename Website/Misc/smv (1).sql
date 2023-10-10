-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: localhost:3306
-- Čas nastanka: 10. okt 2023 ob 06.38
-- Različica strežnika: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Različica PHP: 8.1.2-1ubuntu2.14

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

--
-- Odloži podatke za tabelo `model`
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
-- Struktura tabele `predmeti`
--

CREATE TABLE `predmeti` (
  `id_predmet` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `kratica` varchar(5) DEFAULT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `predmeti`
--

INSERT INTO `predmeti` (`id_predmet`, `ime`, `kratica`, `opis`) VALUES
(1, 'Slovenščina', 'SLO', NULL),
(2, 'Matematika', 'MAT', NULL),
(3, 'Sociologija', 'SOC', NULL),
(4, 'Napredna Uporaba Podatkovnih Baz', 'NUP', NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `ucilnica`
--

CREATE TABLE `ucilnica` (
  `id_predmet` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
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
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id_user`, `user_type`, `ime`, `priimek`, `geslo`, `username`, `opis`, `img_ext`) VALUES
(1, 0, 'Faruk', 'Užičanin', '$2y$10$8jTgj4uNZ1SuplooFnQ4guHmmFq5ch5PiAxFHTf9EGkqnWK8WVLrG', 'FarukUžičanin', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(134, 2, 'Kevin', 'Zlodej', '$2y$10$tQnH9CHCY.wF5wxvh7QNieViJuRLfH08aE/mBTXnoS2DAdKpwuwDa', 'KevinZlodej', NULL, NULL),
(135, 0, 'Mark', 'Sadnik', '$2y$10$XzaNopJwU82D8xQ9OYp//ew3wJz8jEw.BOkO4OvI/6K20FBtt.KE6', 'MarkSadnik', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(136, 2, 'Liam', 'Smith', '$2y$10$f.Z3VP5tlNFIBtpN3QYMC.UijXYFiYPOvLQh4TuJc02ck7P9tJhqi', 'LiamSmith', NULL, NULL),
(137, 2, 'Markku', 'Allen', '$2y$10$EpSGk4t0NskHCdok5FomW.AYFyIyJ0redZ5ZKaxzv.zCrICSw74ru', 'MarkkuAllen', NULL, NULL),
(138, 2, 'Baba', 'Baba', '$2y$10$vtwWLHyTuv66dVqbN9P2ROW2ggCkvziNnuyex0BJUjpayK87Y6rZS', 'BabaBaba', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(139, 2, 'Jan', 'Janko', '$2y$10$el5wfBowldkJDPSwgwIQFOVxdyvKBBqg1zrnttg.vDcyzHEsBOWam', 'JanJanko', NULL, NULL),
(140, 0, 'Žan', 'Šuperger', '$2y$10$hbx0j5KmfOXjOIyZAzdDC.iibC5ujlnZEmNMhDRQ2qSAFnihbRGoa', 'ŽanSuperger', '[uporabnik ni dodal dodatnih informacij]', 'jpg'),
(141, 2, 'Žan', 'Župa', '$2y$10$SLE/8CkvoVokzp6M0x5/5eQtF2rBs1dXEuTxBIeOamSPnRigaX1JK', 'ŽanŽupa', NULL, NULL);

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
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `predmeti`
--
ALTER TABLE `predmeti`
  MODIFY `id_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

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
