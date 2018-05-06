-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Abr-2018 às 22:55
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stkcalc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `coinlist`
--

CREATE TABLE `coinlist` (
  `id` int(5) NOT NULL,
  `CoinTag` varchar(10) NOT NULL,
  `CoinName` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `coinlist`
--

INSERT INTO `coinlist` (`id`, `CoinTag`, `CoinName`) VALUES
(10, 'OPT', 'Optimus');

-- --------------------------------------------------------

--
-- Estrutura da tabela `opt`
--

CREATE TABLE `opt` (
  `BeginBlock` varchar(255) DEFAULT NULL,
  `EndBlock` varchar(255) DEFAULT NULL,
  `BlockTime` varchar(255) DEFAULT NULL,
  `Roi` decimal(5,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `opt`
--

INSERT INTO `opt` (`BeginBlock`, `EndBlock`, `BlockTime`, `Roi`) VALUES
('86180', '88888', '1524009600', '1.370'),
('96980', '88888', '1526601600', '1.370'),
('107780', '88888', '1529193600', '1.370'),
('118580', '88888', '1531785600', '1.370'),
('129380', '88888', '1524124586', '1.370'),
('140180', '88888', '1534164895', '1.370'),
('150980', '88888', '1534120458', '1.710'),
('161780', '88888', '1534694876', '1.370'),
('96980', '88888', '1526601600', '1.370'),
('183380', '88888', '1534753216', '2.330'),
('194180', '88888', '1534654823', '3.290'),
('204980', '88888', '1534369852', '1.030');

-- --------------------------------------------------------

--
-- Estrutura da tabela `opt_start`
--

CREATE TABLE `opt_start` (
  `CoinName` varchar(255) DEFAULT NULL,
  `StartBlock` varchar(255) DEFAULT NULL,
  `StartBlockTime` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `opt_start`
--

INSERT INTO `opt_start` (`CoinName`, `StartBlock`, `StartBlockTime`) VALUES
('Optimus', '<br /><b>Notice</b>:  Undefined variable: stblock in <b>C:xampphtdocsstake calculatoredit.php</b> on line <b>187</b><br />', '<br /><b>Notice</b>:  Undefined variable: stblocktime in <b>C:xampphtdocsstake calculatoredit.php</b> on line <b>188</b><br />');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coinlist`
--
ALTER TABLE `coinlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coinlist`
--
ALTER TABLE `coinlist`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
