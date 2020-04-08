-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 04-Jun-2019 às 02:44
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

create database controlepacientes;
use controlepacientes;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `controlepacientes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `idpessoa` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `dataNascimento` varchar(45) DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `cpf` varchar(150) DEFAULT NULL,
  `idtipoPessoa` int(11) DEFAULT NULL,
  `dataCadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`idpessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`idpessoa`, `nome`, `dataNascimento`, `sexo`, `cpf`, `idtipoPessoa`, `dataCadastro`) VALUES
(12, 'Joaquina alterado', '2010-01-11', 1, '12365564654', 1, '2019-06-03 00:50:34'),
(13, 'joão Rosa alterado', '1987-08-11', 2, '9898988080', 1, '2019-06-03 06:18:14'),
(14, 'Maria Rosa Mada', '1998-02-10', 1, '98989898998', 1, '2019-06-04 00:28:42'),
(16, 'Joaquina', '1999-03-11', 1, '23434324234', 1, '2019-06-04 01:29:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipopessoa`
--

DROP TABLE IF EXISTS `tipopessoa`;
CREATE TABLE IF NOT EXISTS `tipopessoa` (
  `idtipoPessoa` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtipoPessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipopessoa`
--

INSERT INTO `tipopessoa` (`idtipoPessoa`, `descricao`) VALUES
(4, 'Paciente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `dataCadastro` datetime DEFAULT NULL,
  `tipoUsuario` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nome`, `email`, `senha`, `dataCadastro`, `tipoUsuario`, `usuario`) VALUES
(4, 'user teste', 'teste@teste.com', '2ca72350ffc67eaec75f79ac14ec7358', '2019-06-02 18:05:00', 1, 'hammer'),
(5, 'Maria Rosa', 'maria@hotmail.com', '202cb962ac59075b964b07152d234b70', '2019-06-04 00:04:43', 1, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
