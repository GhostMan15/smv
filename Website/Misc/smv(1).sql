-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2023 at 08:47 PM
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

--
-- Dumping data for table `gradiva`
--

INSERT INTO `gradiva` (`id_gradiva`, `oddaja`, `datum_do`, `format`, `naslov`, `opis`, `id_modula`) VALUES
(1, '0', NULL, '', 'Gramatika', '', 1);

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
  `id_ucilnica` int(11) NOT NULL,
  `id_predmet` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ucilnica`
--

INSERT INTO `ucilnica` (`id_ucilnica`, `id_predmet`, `id_user`, `user_type`) VALUES
(1, 1, 161, 2),
(2, 4, 161, 2);

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
(1, 2, 'name', 'surname', '$2y$10$FbCXL10Q1.QQfE0SFg9Cw.ojeweLR9QRiqGVsbL1TigrQ9WHS6bla', 'name_surname', NULL, NULL),
(3, 2, 'John', 'Brown', '$2y$10$hErL93z4mbeZAj1WEIRGb.or6xp4OYiMv2GccU.K2rREf/dEhCFC2', 'john_brown', NULL, NULL),
(4, 2, 'Alice', 'Johnson', '$2y$10$vKkFETx12OdVokGIwk9WQeNrHsiJoaxotEEtXX2lHaDKYsh2wfH3m', 'alice_johnson', NULL, NULL),
(5, 2, 'John', 'Smith', '$2y$10$TJCFunHqlEI9jrFdOx4ffu2cLQF.6e4t6tomjkpqo7HBFwMhhzp92', 'john_smith', NULL, NULL),
(6, 2, 'Moron', 'Wilson', '$2y$10$CHFjlfvhzehCVGuPq2x0R.quMkk6rNWrLJdsmFEPOh9l6QRweisfy', 'moron_wilson', NULL, NULL),
(7, 2, 'Jane', 'Smith', '$2y$10$z2c9/E4bivsjNLNuYhzoqeXvVgeb.4W1U/XwRogaPiuL.TPETPv9.', 'jane_smith', NULL, NULL),
(8, 2, 'Jane', 'Anderson', '$2y$10$zr84b4/BXAALQPUGAL/NBe/M3TToniIs/S.PZ6PSfQc.fJg5wTHfC', 'jane_anderson', NULL, NULL),
(9, 2, 'Bob', 'Wilson', '$2y$10$YlvYIm5cjyZFnMwhGxC7MOxmE.7P78UauOlJ1UDXyLQeYaiH4Cm3S', 'bob_wilson', NULL, NULL),
(10, 2, 'Emily', 'Davis', '$2y$10$XDXQ7P1bnUlr5aMYyDcQguEMvOmtcyWrr2Rvw2nwz3LVD8ciGAGUW', 'emily_davis', NULL, NULL),
(11, 2, 'Jane', 'Davis', '$2y$10$vRLPV7oySZOWfm9zj0P2wefv33RlqbtIKy6oxnYw5sdT0rw69sNt6', 'jane_davis', NULL, NULL),
(12, 2, 'Alice', 'Brown', '$2y$10$0wL6qAnHIHoO9CpgQ9o3kucroD9AI0znujnhKnjddqwEC3EG95gJW', 'alice_brown', NULL, NULL),
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
(176, 2, 'Chris', 'Young', '$2y$10$9V5RNehgjqDRzF7Nw5Y6.euyIEav75IfSoWifBlH1Xu6M6PLbI34C', 'ChrisYoung', NULL, NULL),
(259, 2, 'Michael', 'Williams', '$2y$10$A91djA7exSx0kmMR5HctjuWT7OZvawW.U8N9PdYfyKRoyvRKC1eom', 'michael_williams', NULL, NULL),
(260, 2, 'Jennifer', 'Brown', '$2y$10$0p9n2UTly1zRHwtVnvcg87FA8eHsX2XynelUfd3y52hDOS8CIitbm', 'jennifer_brown', NULL, NULL),
(261, 2, 'William', 'Jones', '$2y$10$MxOY8os5s0U1y4wxJnh76AfD0y4Rw5i97K7VfN0FW9KJ0Yp6YQJKW', 'william_jones', NULL, NULL),
(262, 2, 'Bobby', 'John', '$2y$10$hqj2FFHqy6IqRnpNdJupJedws9WLPzdmzdoXWXnh5p6KDLbI3h8tu', 'bobby_john', NULL, NULL),
(263, 2, 'David', 'Clark', '$2y$10$6jFbkuM/1P6j3qR2sdQyaOhhITj11kPqGJtr0RYmcm/BDJR1ye/ka', 'david_clark', NULL, NULL),
(264, 2, 'Daniel', 'Martinez', '$2y$10$67jCZBpnchktwKuXfODWd0hM31Qtb5O8qFf.ZE2wr1vXLtETgW.OA', 'daniel_martinez', NULL, NULL),
(265, 2, 'Olivia', 'Lopez', '$2y$10$TbD59ZusIsyx3qhaSYKTXl8BB9haOj.7MTJhuv.lX7wKtU8sCP/We', 'olivia_lopez', NULL, NULL),
(266, 2, 'Sophia', 'Garcia', '$2y$10$nLSBY7gAimj7yHXEujl54e7Gq6qz2Tm4Ri5LbCRWwgbomP7vIrbpC', 'sophia_garcia', NULL, NULL),
(267, 2, 'James', 'Rodriguez', '$2y$10$9O5Tnc0Ob9Kz2bCcdaQWiD/8t3MZ7yq.9AE5J80U9dDDnFd9yXJ.2', 'james_rodriguez', NULL, NULL),
(268, 2, 'Emma', 'Hernandez', '$2y$10$RhGntkK7MD4Sv2aTnl2Rd8tDBddzCx.wP4RWteEh1nQnIB7n.xz7G', 'emma_hernandez', NULL, NULL),
(269, 2, 'Liam', 'Taylor', '$2y$10$paExLm7g0I6Rz1nzV41IzuuYI2vB.2gegLWVzE6.GD5WtSfdVYKu.', 'liam_taylor', NULL, NULL),
(270, 2, 'Ava', 'Roberts', '$2y$10$S5vklKFNzW43vVx4tdT1vOFMm1kWfBwAKft3mNp6LyDcvBl9a.LfS', 'ava_roberts', NULL, NULL),
(271, 2, 'Noah', 'Johnson', '$2y$10$JG9by6NqF33arz1HOmcY1.AjtVbl1f9QRrCKPq9O7.CGBhlHZUuwa', 'noah_johnson', NULL, NULL),
(272, 2, 'Isabella', 'White', '$2y$10$JU5qkbXk9GML9nhA.TzURuIw6cSbljOhrz5f4sjEXJePD9j/ITxR.', 'isabella_white', NULL, NULL),
(273, 2, 'Mason', 'Harris', '$2y$10$3bOHPf4T9jwI36jV.8ak/uJhkv6Wh4zVCm62YiPvG1OSxHlH1Usw6', 'mason_harris', NULL, NULL),
(274, 2, 'Sophia', 'Martin', '$2y$10$Jts8YVRniNobRqilDUn07.tY9QrD6dAhlVa8mZjt0s3sBsDD11iXu', 'sophia_martin', NULL, NULL),
(275, 2, 'Lucas', 'Clark', '$2y$10$BDTNTxwbfrcOnKlyHoF.3upWVBTRD5C1Z9tRPWVkdWk9RlGOCQzSi', 'lucas_clark', NULL, NULL),
(276, 2, 'Ava', 'Wilson', '$2y$10$nVQ7i2OpCBXO2.tVYDDZ4.MCzF2fI3abunRpFQr/UvVe5EzTJ68fu', 'ava_wilson', NULL, NULL),
(277, 2, 'Liam', 'Perez', '$2y$10$MgVv0tiK2/lhP/Cy6MLdXOBvunybI7ceNztz.GWkm6QYKls3r3DNa', 'liam_perez', NULL, NULL),
(278, 2, 'Isabella', 'Jackson', '$2y$10$rZyni3lyw9L33xL29J/xw.C1MQETsmjvAZ2w5zKvzZVACoJkGUBGi', 'isabella_jackson', NULL, NULL),
(279, 2, 'Oliver', 'Miller', '$2y$10$FQDpyJFi9MgWpZVcWk2TMe7Uo2n8Cf2y.fIb0u1O8Myt3Ys7sLdUq', 'oliver_miller', NULL, NULL),
(280, 2, 'Mia', 'Thompson', '$2y$10$DLZk1VgWLWT8QWZCfOgkZ1OGLoU.hgk.2r7pT2PhMnrCNOdDXgJFq', 'mia_thompson', NULL, NULL),
(281, 2, 'Ethan', 'Hernandez', '$2y$10$lQg9hQptC09kKJ.wpdVQFe9XsMz2l4MhzkNdP3rWnJ2MAweTDMG5e', 'ethan_hernandez', NULL, NULL),
(282, 2, 'Amelia', 'Gonzalez', '$2y$10$aA5vbRu5JnQUCWzya1iIXuxbChAQ9aJt5G3IYN2m7fK8OY1eGtuai', 'amelia_gonzalez', NULL, NULL),
(283, 2, 'Liam', 'Smithž', '$2y$10$NaiyPJcsiq2nByDbTbAgk.NXxlBb6A.lssrqeisYNihoLmt4zJKBy', 'liam_smithž', NULL, NULL),
(284, 2, 'Charlotte', 'Anderson', '$2y$10$jFT3K9DTFV4EMfHXY4rcqel7k1Jsl4Vn1KNd5NdGgrq4s35q5k1KW', 'charlotte_anderson', NULL, NULL),
(285, 2, 'Oliver', 'Brown', '$2y$10$Tn7r.lAZa/4RUvcwz9/5yOkCvKQGhF.9zWlJ0gOWPwqo0i9cSXzYe', 'oliver_brown', NULL, NULL),
(286, 2, 'Ava', 'Taylor', '$2y$10$Fc0F7ciAnEjz52vJKAtck0XJoOFDPJ0BBrgrPZ2H7eUq2kjOTuMfG', 'ava_taylor', NULL, NULL),
(287, 2, 'William', 'Smith', '$2y$10$JWraYK7TMTlFNlzTMrJVOeI5qZp3WqftkSVOXmT71j6HZWFOQVqwu', 'william_smith', NULL, NULL),
(288, 2, 'Emma', 'Roberts', '$2y$10$4Gc9IFJiM60ReZ.cVcXRY2cqKQoZIotd7zRcTpvkl1Dp6kziFN6kq', 'emma_roberts', NULL, NULL),
(289, 2, 'Sophia', 'Johnson', '$2y$10$1QsD6K9NTezS8r7ny5TOdunIOcDoycS2I5b0n9HDFvylQRDT8l3F.', 'sophia_johnson', NULL, NULL),
(290, 2, 'Liam', 'Davis', '$2y$10$93GxSKyFn.oMORCb5V0uZ.Ml8cgzSNn8c9G92HsJLk4B4hoy6TlNO', 'liam_davis', NULL, NULL),
(291, 2, 'Olivia', 'Williams', '$2y$10$8FYraKPETuK7ZxDAtkjvbekuUIlLlRUZ1bcwSvCpTVxt14wDrOiB6', 'olivia_williams', NULL, NULL),
(292, 2, 'Noah', 'Brown', '$2y$10$B0wVKuN1dRlDlJcqY.4Aou6zbbFqoL9G3zzwE/9LbGujp9lJF3XAK', 'noah_brown', NULL, NULL),
(293, 2, 'Ava', 'Davis', '$2y$10$jN6L4K7RlLZf2jgjk9dO9LpNzdejkdBOYxE9fa8yKmL.jrJ0y5pW6', 'ava_davis', NULL, NULL),
(294, 2, 'Mia', 'Anderson', '$2y$10$E5bu9KVb73.jq2/Z8sT0r.MLhCHpD6MI1k7v0vw3hOQYj0wj9VHvy', 'mia_anderson', NULL, NULL),
(295, 2, 'Lucas', 'Garcia', '$2y$10$rOJccKESrO3wNKYBlDeP8s0p.Jcj8ZpI.WCI0nhXlG4owJ.P4/JTO', 'lucas_garcia', NULL, NULL),
(296, 2, 'Oliver', 'Hernandez', '$2y$10$G7i9ZKkEFO9NluKDQeO9hjzRLJoJ8SoI1.ZR0ozXlEJNwRi3vMeSy', 'oliver_hernandez', NULL, NULL),
(297, 2, 'Sophia', 'Roberts', '$2y$10$lO19bKkEGR9cGuZDsceZhu.Eq.98RzNQWv9vChJNJOGjB6v/Wpz3i', 'sophia_roberts', NULL, NULL),
(298, 2, 'Ethan', 'Clark', '$2y$10$F71ZKk6E/GHnkuZfRezkhqXpC..J.Fp/h6Q5j3i5W/Jg0twyGh6wG', 'ethan_clark', NULL, NULL),
(299, 2, 'William', 'Smithž', '$2y$10$3ElZKkz9VW9PHuZ/cQw9dVeO/5i.BhVo1y7/JhOwJn6X/lGtBn5Ye', 'william_smithž', NULL, NULL),
(300, 2, 'Olivia', 'Taylor', '$2y$10$1FpJkzcN1Yv9DKuG0w9dRePb/j.IpUKs9W9X3CRcXCpXkDHZj/Zj2', 'olivia_taylor', NULL, NULL),
(301, 2, 'Mia', 'Johnson', '$2y$10$2FvJkzcN1jw9RQU/1eRb3vFb.eFyiTKR1W9VJLAL5hSWk.GkzJ.Ku', 'mia_johnson', NULL, NULL),
(302, 2, 'Ethan', 'Wilson', '$2y$10$1FzJkzcN1Xy9DhU/1i9jDvKb/lFziQpS1W9VZ9Ls8WRSkEKgk9Z.n', 'ethan_wilson', NULL, NULL),
(303, 2, 'Isabella', 'Brown', '$2y$10$zFvJkzcN1Kw9QcU.1Y9wDvVb.mFzfzVl1W9VoLaJ5V.vk/UKGzKJG', 'isabella_brown', NULL, NULL),
(304, 2, 'Liam', 'Hernandez', '$2y$10$1XzNkzcN2pW9KYU1VXzRVXgb.lfzL/fL1XzYpXzg8nCzZkLKZzLXm', 'liam_hernandez', NULL, NULL),
(305, 2, 'Sophia', 'Gonzalez', '$2y$10$7XzNkzcN2wW9JOV1AXzPVygb.vfzL7fL1AXz.jr2zMflJWUvLzj.K', 'sophia_gonzalez', NULL, NULL),
(306, 2, 'Oliver', 'Martinez', '$2y$10$2ZzNkzcN21W9K9D1oXz1ViYb.EfzL7zL1Xz.yrpXz.jflV2KqKmLk', 'oliver_martinez', NULL, NULL),
(307, 2, 'Charlotte', 'Clark', '$2y$10$0.7NkzcN2RW9JtI1fXz1ZeYb.fRzL2zL1Xz.xrpXzJ.czBp3uLLzq', 'charlotte_clark', NULL, NULL),
(308, 2, 'Noah', 'Perez', '$2y$10$2z.NkzcN2GW9JQ.1QXzWVgYb.dzLWz8L1Xz.qrpXzJpKm2ApJq2LK', 'noah_perez', NULL, NULL),
(309, 2, 'Avaz', 'Robertš', '$2y$10$Myyhkd1vNf.WH96.EUHnBz/OILFzqzh1siohdmBoRnV1Ofv/5Xffm', 'avaz_robertš', NULL, NULL),
(310, 2, 'Liamz', 'Smith', '$2y$10$QyvNkd1XNf.WH.LjElHn0z/zTIWiIuWk7A6BlzF.X.Lq4F19DWXjy', 'liamz_smith', NULL, NULL),
(311, 2, 'Emma', 'Davis', '$2y$10$C6c9kd1Yf.WkHvEPlXn10z/z8xO6u3D6wCGBbP1H.JCKsPi5DmBh.q', 'emma_davis', NULL, NULL),
(312, 2, 'Noah', 'Garcia', '$2y$10$G9yVkd1Uf.WkH.ziB1Hn00z/uYFSU9NK1FCk.xBvXZci6rFErG9gu', 'noah_garcia', NULL, NULL),
(313, 2, 'Olivia', 'Hernandez', '$2y$10$R5hJkd1Tf.WkHVkvl1HnH0z/LzUvj5.Ur2v0BC9i6TCz7rGyv9v.q', 'olivia_hernandez', NULL, NULL),
(314, 2, 'William', 'Martinez', '$2y$10$L1h1kd1Yf.WklV6y.xk0I.z/vMHUuppJf7Bh.x.zH2KcEKcKC6Zua', 'william_martinez', NULL, NULL),
(315, 2, 'Mia', 'Andersonz', '$2y$10$Y1h1kd1Zf.WknV8y.xk0B.z./pTH7OO9.RhYf2GZu2bD9tDlkzKtq', 'mia_andersonz', NULL, NULL),
(316, 2, 'Oliver', 'Roberts', '$2y$10$O1h1kd1Yf.WknRy.xk0Cz.z3eCHD2tKzBuMKvESk8PqJ/7fc.ykF.', 'oliver_roberts', NULL, NULL),
(317, 2, 'Sophia', 'Smith', '$2y$10$U1h1kd1Tf.Wknu6y.xk0Dz.9bMeHj5H9nYBXGk8kM6veKDc.MOmk.', 'sophia_smith', NULL, NULL),
(318, 2, 'Lucas', 'Gonzalez', '$2y$10$R1h1kd1Sf.WknO8y.xk0Ez.7BvHcPzD9uW9fj0Lk9mDz7EHRDxWkq', 'lucas_gonzalez', NULL, NULL),
(319, 2, 'Ava', 'Garcia', '$2y$10$L1h1kd1Yf.WklV6y.xk0I.z/vMHUuppJf7Bh.x.zH2KcEKcKC6Zua', 'ava_garcia', NULL, NULL),
(320, 2, 'Noah', 'Davis', '$2y$10$Y1h1kd1Zf.WknV8y.xk0B.z./pTH7OO9.RhYf2GZu2bD9tDlkzKtq', 'noah_davis', NULL, NULL),
(321, 2, 'Liamz', 'Hernandez', '$2y$10$O1h1kd1Yf.WknRy.xk0Cz.z3eCHD2tKzBuMKvESk8PqJ/7fc.ykF.', 'liamz_hernandez', NULL, NULL),
(322, 2, 'Ema', 'Roberts', '$2y$10$U1h1kd1Tf.Wknu6y.xk0Dz.9bMeHj5H9nYBXGk8kM6veKDc.MOmk.', 'ema_roberts', NULL, NULL),
(323, 2, 'Oliver', 'Smith', '$2y$10$R1h1kd1Sf.WknO8y.xk0Ez.7BvHcPzD9uW9fj0Lk9mDz7EHRDxWkq', 'oliver_smith', NULL, NULL),
(324, 1, 'Liamz', 'Taylor', '$2y$10$aUvNkd1Sf.WknX8y.xk0Qz.7avvHcMzD9uW9g0Lk9mDz7RHRDl2kq', 'liamz_taylor', NULL, NULL),
(325, 1, 'Sophiaz', 'Johnson', '$2y$10$aRvNkd1Tf.WknW8y.xk0Vz.9bvzHcjzD9nYBWGk8kM6vcRHRDiRkq', 'sophiaz_johnson', NULL, NULL),
(326, 1, 'Oliver', 'Hernandezz', '$2y$10$aQvNkd1Uf.WknXy.xk0Dz.7bOvzHc9zD1YBEGk8kM6vcRHRDr.kq', 'oliver_hernandezz', NULL, NULL),
(327, 1, 'Charlotte', 'Roberts', '$2y$10$aPvNkd1Wf.WknU8y.xk0Cz.7.vvzH2zD9uWG0Lk9mDz7RHRDd.kq', 'charlotte_roberts', NULL, NULL),
(328, 1, 'Nozah', 'Garcia', '$2y$10$aLvNkd1Xf.WknP8y.xk0Bz.7zvvzHqzD9nYWJGk8kM6vcRHRD2.kq', 'nozah_garcia', NULL, NULL),
(332, 1, 'Adin', 'Smith', '$2y$10$AABgC0mdY0aZtQHyLjLy2.6TzZ.mM7LHXYMHEy7TGOCECFKwK1kG.', 'adin_smith', NULL, NULL),
(333, 1, 'Subbob', 'Adin', '$2y$10$BABgC0md6YmZtRgy3jLy2.AUZcZ.mS7zHlY3EiylGZiYEDy3Y.YBm', 'subbob_adin', NULL, NULL),
(335, 1, 'Jzohn', 'Smith', '$2y$10$6AgyC0md6YmZtRgy3jLy2.AUZcZ.mS7zHlY3EiylGZiYEDy3Y.YBm', 'jzohn_smith', NULL, NULL),
(336, 1, 'Sarazh', 'Johnson', '$2y$10$2By2C0md6YzZtNgyTjLy2.5YZiZ.mR7zHqYR.tlkGZmEzgytY.rKm', 'sarazh_johnson', NULL, NULL),
(337, 1, 'Michaezl', 'Williams', '$2y$10$5Cy2C0md6YzZtNgyTjLy2.5YZiZ.mR7zHqYR.tlkGZmEzgytY.rKm', 'michaezl_williams', NULL, NULL);

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
  ADD PRIMARY KEY (`id_ucilnica`),
  ADD KEY `id_predmet` (`id_predmet`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id_gradiva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_ucilnica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

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
  ADD CONSTRAINT `ucilnica_ibfk_1` FOREIGN KEY (`id_predmet`) REFERENCES `predmeti` (`id_predmet`),
  ADD CONSTRAINT `ucilnica_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
