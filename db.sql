-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 25-Jul-2019 às 14:37
-- Versão do servidor: 5.7.26-29
-- versão do PHP: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pmeg8744_checkout`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `adminID` bigint(10) UNSIGNED NOT NULL,
  `adminLogin` varchar(120) DEFAULT NULL,
  `adminSenha` varchar(20) DEFAULT NULL,
  `adminStatus` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`adminID`, `adminLogin`, `adminSenha`, `adminStatus`) VALUES
(1, 'admin@admin.com', 'mp123456', 1),

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `pedidoID` bigint(10) UNSIGNED NOT NULL,
  `pedidoIDMP` varchar(255) DEFAULT NULL,
  `pedidoCodigo` varchar(15) DEFAULT NULL,
  `pedidoNome` varchar(120) DEFAULT NULL,
  `pedidoEmail` varchar(120) DEFAULT NULL,
  `pedidoTelefone` varchar(15) DEFAULT NULL,
  `pedidoCPF` varchar(15) DEFAULT NULL,
  `pedidoCEP` varchar(9) DEFAULT NULL,
  `pedidoEnderecoRua` varchar(220) DEFAULT NULL,
  `pedidoEnderecoNumero` varchar(20) DEFAULT NULL,
  `pedidoEnderecoBairro` varchar(120) DEFAULT NULL,
  `pedidoEnderecoCidade` varchar(120) DEFAULT NULL,
  `pedidoEnderecoEstado` varchar(20) DEFAULT NULL,
  `pedidoPagamento` varchar(80) DEFAULT NULL,
  `pedidoStatus` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `pedidoData` datetime DEFAULT NULL,
  `pedidoFrete` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `pedidoValor` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `pedidoEnderecoComplemento` varchar(80) DEFAULT NULL,
  `pedidoProduto` varchar(120) DEFAULT NULL,
  `pedidoLinkBoleto` text,
  `pedidoBarcode` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`pedidoID`, `pedidoIDMP`, `pedidoCodigo`, `pedidoNome`, `pedidoEmail`, `pedidoTelefone`, `pedidoCPF`, `pedidoCEP`, `pedidoEnderecoRua`, `pedidoEnderecoNumero`, `pedidoEnderecoBairro`, `pedidoEnderecoCidade`, `pedidoEnderecoEstado`, `pedidoPagamento`, `pedidoStatus`, `pedidoData`, `pedidoFrete`, `pedidoValor`, `pedidoEnderecoComplemento`, `pedidoProduto`, `pedidoLinkBoleto`, `pedidoBarcode`) VALUES
(30, '4890659681', '292050B1B2...', 'Tester Campos', 'campos@hotmail.com', '41991729723', '05781291750', '81280330', 'Rua Professor Pedro ', '01', 'Cidade Industrial', 'Curitiba', 'PR', 'Boleto bancário', 1, '2019-06-21 22:09:47', '0.00', '189.55', 'Graciosa apto 184', 'Tapete Multisenssorial', 'https://www.mercadopago.com/mlb/payments/ticket/....', '23795793200....'),

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `produtoID` bigint(10) UNSIGNED NOT NULL,
  `produtoNome` varchar(220) DEFAULT NULL,
  `produtoValor` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `produtoFrete` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `produtoCodigo` char(32) DEFAULT NULL,
  `produtoPixel` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`produtoID`, `produtoNome`, `produtoValor`, `produtoFrete`, `produtoCodigo`, `produtoPixel`) VALUES
(1, 'Tapete Multisenssorial', '189.55', '0.00', '8133f1a221f3af42473a83cce3df4914', '349488005746684'),


--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`pedidoID`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produtoID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `pedidoID` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produtoID` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
