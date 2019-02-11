-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Nov-2017 às 14:29
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(7) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `tipo` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `tipo`) VALUES
(1, 'CONSUMO', 'DESPESA'),
(2, 'CARRO', 'DESPESA'),
(3, 'MOTO', 'DESPESA'),
(4, 'ESTOQUE', 'DESPESA'),
(5, 'SALÁRIOS', 'DESPESA'),
(6, 'SERVIÇOS', 'DESPESA'),
(7, 'VENDA', 'RECEITA'),
(8, 'SERVIÇOS', 'RECEITA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(7) NOT NULL,
  `id_pessoa_fisica` int(7) DEFAULT NULL,
  `id_pessoa_juridica` int(7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `id_pessoa_fisica`, `id_pessoa_juridica`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2017-08-19 03:17:43', '2017-08-19 03:17:43'),
(3, 3, NULL, '2017-08-19 03:22:37', '2017-08-19 03:22:37'),
(4, NULL, 5, '2017-09-02 03:00:43', '2017-09-02 03:00:43'),
(5, 6, NULL, '2017-09-07 00:45:48', '2017-09-07 00:45:48'),
(6, 7, NULL, '2017-09-19 00:36:06', '2017-09-19 00:36:06'),
(7, 8, NULL, '2017-09-22 00:10:37', '2017-09-22 00:10:37'),
(8, 9, NULL, '2017-09-22 00:13:08', '2017-09-22 00:13:08'),
(9, 10, NULL, '2017-09-22 00:15:31', '2017-09-22 00:15:31'),
(10, 11, NULL, '2017-09-22 00:19:01', '2017-09-22 00:19:01'),
(11, NULL, 7, '2017-09-22 00:21:42', '2017-09-22 00:21:42'),
(12, NULL, 8, '2017-09-22 00:25:08', '2017-09-22 00:25:08'),
(13, 12, NULL, '2017-10-18 23:50:25', '2017-10-18 23:50:25'),
(14, 14, NULL, '2017-10-27 00:02:59', '2017-10-27 00:02:59'),
(15, 15, NULL, '2017-11-01 00:35:25', '2017-11-01 00:35:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_pagar`
--

CREATE TABLE `contas_pagar` (
  `id` int(7) NOT NULL,
  `id_categoria` int(7) NOT NULL,
  `id_fornecedor` int(7) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `qtd_parcelas` int(4) DEFAULT NULL,
  `qtd_parcelas_pagas` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`id`, `id_categoria`, `id_fornecedor`, `descricao`, `valor`, `valor_pago`, `qtd_parcelas`, `qtd_parcelas_pagas`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'COMBUSTIVEL', '80.00', '0.00', 1, 0, '2017-09-22 00:48:00', '2017-09-22 00:48:00'),
(2, 4, 12, 'PAPEL SULFITE A4', '6000.00', '0.00', 3, 0, '2017-09-22 00:49:07', '2017-09-22 00:49:07'),
(3, 4, 13, 'COMPUTADORES', '7380.00', '0.00', 4, 0, '2017-09-22 00:50:00', '2017-09-22 00:50:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_receber`
--

CREATE TABLE `contas_receber` (
  `id` int(7) NOT NULL,
  `id_categoria` int(7) NOT NULL,
  `id_cliente` int(7) NOT NULL,
  `recorrente` tinyint(1) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `qtd_parcelas` int(4) DEFAULT NULL,
  `qtd_parcelas_pagas` int(4) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(7) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `departamentos`
--

INSERT INTO `departamentos` (`id`, `nome`, `created_at`, `updated_at`) VALUES
(1, 'ESCRITORIO', '2017-08-06 20:28:51', '2017-09-15 20:33:26'),
(2, 'INFORMATICA', '2017-08-07 22:51:41', '2017-09-15 20:33:34'),
(3, 'ESCOLAR', '2017-08-07 22:52:39', '2017-09-15 20:33:42'),
(4, 'ARMARINHOS', '2017-09-02 03:26:23', '2017-09-15 20:34:29'),
(5, 'DIVERSOS', '2017-10-21 23:18:25', '2017-10-21 23:18:25'),
(7, 'ESCRITORIO 2', '2017-11-01 01:27:16', '2017-11-01 01:27:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada`
--

CREATE TABLE `entrada` (
  `id` int(7) NOT NULL,
  `id_usuario` int(7) NOT NULL,
  `id_fornecedor` int(7) DEFAULT NULL,
  `data_entrada` date DEFAULT NULL,
  `serie_nf` varchar(3) DEFAULT NULL,
  `num_nota_fiscal` varchar(12) DEFAULT NULL,
  `motivo` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entrada`
--

INSERT INTO `entrada` (`id`, `id_usuario`, `id_fornecedor`, `data_entrada`, `serie_nf`, `num_nota_fiscal`, `motivo`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2017-09-15', '11', '000001', NULL, '2017-09-15 20:45:53', '2017-09-15 20:45:53'),
(2, 1, 6, '2017-09-15', '11', '000002', NULL, '2017-09-15 20:46:39', '2017-09-15 20:46:39'),
(3, 1, 5, '2017-09-15', '12', '000004', NULL, '2017-09-15 23:05:02', '2017-09-15 23:05:02'),
(4, 1, 6, '2017-09-15', '12', '121321212', NULL, '2017-09-16 00:21:10', '2017-09-16 00:21:10'),
(5, 11, 2, '2017-09-15', '10', '456564655', NULL, '2017-09-16 01:26:35', '2017-09-16 01:26:35'),
(24, 1, NULL, '2017-09-16', NULL, NULL, 'foi solicitado mais do que o necessário', '2017-09-16 17:09:22', '2017-09-16 17:09:22'),
(36, 1, 6, '2017-09-16', '2', '513232132', NULL, '2017-09-16 19:20:44', '2017-09-16 19:20:44'),
(37, 1, 8, '2017-10-14', '1', '845122331', NULL, '2017-10-14 20:25:06', '2017-10-14 20:25:06'),
(65, 1, NULL, NULL, NULL, NULL, 'teste', '2017-10-28 00:17:26', '2017-10-28 00:17:26'),
(64, 1, 13, '2017-10-26', '511', '513121032', NULL, '2017-10-27 23:55:06', '2017-10-27 23:55:06'),
(69, 1, NULL, '2017-10-27', NULL, NULL, 'apagar', '2017-10-28 00:35:16', '2017-10-28 00:35:16'),
(71, 1, 15, '2017-11-01', '112', '7894441', NULL, '2017-11-02 00:50:29', '2017-11-02 00:50:29'),
(79, 1, 15, '2017-11-03', '322', '3232233', NULL, '2017-11-02 03:36:03', '2017-11-02 03:36:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada_produto`
--

CREATE TABLE `entrada_produto` (
  `id` int(7) NOT NULL,
  `id_entrada` int(7) NOT NULL,
  `id_produto` int(7) NOT NULL,
  `quantidade` int(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entrada_produto`
--

INSERT INTO `entrada_produto` (`id`, `id_entrada`, `id_produto`, `quantidade`, `created_at`, `updated_at`) VALUES
(1, 1, 26, 20, NULL, NULL),
(2, 1, 25, 30, NULL, NULL),
(3, 1, 24, 5, NULL, NULL),
(4, 2, 28, 15, NULL, NULL),
(5, 2, 27, 10, NULL, NULL),
(6, 3, 27, 10, NULL, NULL),
(7, 4, 28, 3, NULL, NULL),
(8, 5, 25, 4, NULL, NULL),
(9, 24, 24, 2, NULL, NULL),
(10, 36, 30, 3, NULL, NULL),
(11, 37, 30, 10, NULL, NULL),
(24, 65, 34, 5, NULL, NULL),
(23, 64, 32, 10, NULL, NULL),
(25, 69, 34, 3, NULL, NULL),
(26, 71, 37, 12, NULL, NULL),
(27, 71, 35, 17, NULL, NULL),
(40, 79, 35, 8, NULL, NULL),
(39, 79, 38, 18, NULL, NULL);

--
-- Acionadores `entrada_produto`
--
DELIMITER $$
CREATE TRIGGER `trigger_saldo_delete_entrada` AFTER DELETE ON `entrada_produto` FOR EACH ROW BEGIN
	UPDATE produtos SET produtos.saldo = produtos.saldo - old.quantidade
    WHERE id = old.id_produto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_saldo_entrada` AFTER INSERT ON `entrada_produto` FOR EACH ROW BEGIN
	UPDATE produtos SET produtos.saldo = produtos.saldo + NEW.quantidade
    WHERE id = NEW.id_produto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `forma_pagamento`
--

CREATE TABLE `forma_pagamento` (
  `id` int(7) NOT NULL,
  `descricao` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `forma_pagamento`
--

INSERT INTO `forma_pagamento` (`id`, `descricao`) VALUES
(1, 'À VISTA'),
(2, 'CARTÃO CRÉDITO'),
(3, 'CARTÃO DÉBITO'),
(4, 'CHEQUE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedors`
--

CREATE TABLE `fornecedors` (
  `id` int(7) NOT NULL,
  `id_pessoa_fisica` int(7) DEFAULT NULL,
  `id_pessoa_juridica` int(7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fornecedors`
--

INSERT INTO `fornecedors` (`id`, `id_pessoa_fisica`, `id_pessoa_juridica`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, '2017-08-19 03:20:57', '2017-08-19 03:20:57'),
(3, 3, NULL, '2017-08-19 03:22:37', '2017-08-19 03:22:37'),
(4, NULL, 4, '2017-08-19 03:36:27', '2017-08-19 03:36:27'),
(5, 5, NULL, '2017-09-02 03:00:17', '2017-09-02 03:00:17'),
(6, NULL, 5, '2017-09-02 03:00:43', '2017-09-02 03:00:43'),
(7, NULL, 6, '2017-09-16 01:30:13', '2017-09-16 01:30:13'),
(8, 9, NULL, '2017-09-22 00:13:08', '2017-09-22 00:13:08'),
(9, 11, NULL, '2017-09-22 00:19:01', '2017-09-22 00:19:01'),
(10, NULL, 8, '2017-09-22 00:25:08', '2017-09-22 00:25:08'),
(11, NULL, 9, '2017-09-22 00:28:47', '2017-09-22 00:28:47'),
(12, NULL, 10, '2017-09-22 00:32:04', '2017-09-22 00:32:04'),
(13, NULL, 11, '2017-09-22 00:33:57', '2017-09-22 00:33:57'),
(14, 14, NULL, '2017-10-27 00:02:59', '2017-10-27 00:02:59'),
(15, NULL, 12, '2017-11-01 22:31:21', '2017-11-01 22:31:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_estoque`
--

CREATE TABLE `historico_estoque` (
  `id_historico_estoque` int(7) NOT NULL,
  `qtd` varchar(10) DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(7) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id`, `nome`, `created_at`, `updated_at`) VALUES
(3, 'CHAMEX', '2017-08-07 23:50:36', '2017-09-15 20:34:56'),
(4, 'FABER CASTELL', '2017-08-08 00:10:54', '2017-09-15 20:34:49'),
(5, 'GENIUS', '2017-08-25 00:32:02', '2017-09-15 20:35:02'),
(6, 'PRITT', '2017-08-27 01:33:19', '2017-09-15 20:35:09'),
(7, 'HP', '2017-09-02 03:26:06', '2017-09-15 20:35:17'),
(8, 'DELL', '2017-09-02 03:28:23', '2017-09-15 20:35:23'),
(9, 'BIC', '2017-09-15 20:35:45', '2017-09-15 20:35:45'),
(10, 'TILIBRA', '2017-09-15 20:36:02', '2017-09-15 20:36:02'),
(11, 'INFORMS', '2017-09-15 20:37:41', '2017-09-15 20:37:41'),
(12, 'ACRILEX', '2017-09-16 01:15:29', '2017-09-16 01:15:29'),
(13, 'PILOT', '2017-10-21 23:36:21', '2017-10-21 23:36:21'),
(14, 'WALEU', '2017-10-21 23:37:22', '2017-10-21 23:37:22'),
(15, 'SOUZA', '2017-10-21 23:37:32', '2017-10-21 23:37:32'),
(16, 'ACRIMET', '2017-10-21 23:38:00', '2017-10-21 23:38:00'),
(17, 'MASTERPRINT', '2017-10-21 23:43:27', '2017-10-21 23:43:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelas`
--

CREATE TABLE `parcelas` (
  `id` int(7) NOT NULL,
  `id_conta_pagar` int(7) DEFAULT NULL,
  `id_conta_receber` int(7) DEFAULT NULL,
  `id_forma_pagamento` int(7) DEFAULT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `valor_parcela` decimal(10,2) DEFAULT NULL,
  `num_parcela` int(7) DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `parcelas`
--

INSERT INTO `parcelas` (`id`, `id_conta_pagar`, `id_conta_receber`, `id_forma_pagamento`, `valor_pago`, `valor_parcela`, `num_parcela`, `data_pagamento`, `data_vencimento`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, '80.00', 1, NULL, '2017-09-30', 0, '2017-09-22 00:48:00', '2017-09-22 00:48:00'),
(2, 2, NULL, NULL, NULL, '2000.00', 1, NULL, '2017-10-02', 0, '2017-09-22 00:49:07', '2017-09-22 00:49:07'),
(3, 2, NULL, NULL, NULL, '2000.00', 2, NULL, '2017-11-02', 0, '2017-09-22 00:49:07', '2017-09-22 00:49:07'),
(4, 2, NULL, NULL, NULL, '2000.00', 3, NULL, '2017-12-02', 0, '2017-09-22 00:49:07', '2017-09-22 00:49:07'),
(5, 3, NULL, NULL, NULL, '1845.00', 1, NULL, '2017-10-05', 0, '2017-09-22 00:50:00', '2017-09-22 00:50:00'),
(6, 3, NULL, NULL, NULL, '1845.00', 2, NULL, '2017-11-05', 0, '2017-09-22 00:50:00', '2017-09-22 00:50:00'),
(7, 3, NULL, NULL, NULL, '1845.00', 3, NULL, '2017-12-05', 0, '2017-09-22 00:50:00', '2017-09-22 00:50:00'),
(8, 3, NULL, NULL, NULL, '1845.00', 4, NULL, '2018-01-05', 0, '2017-09-22 00:50:00', '2017-09-22 00:50:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
(3, 'teste@email.com', '$2y$10$IrItZLE5bHO9kSx/j2b4OeoPRtCipRPSVWdRmZKnOFG6AuV7i8Z2u', '2017-07-14 00:30:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_fisicas`
--

CREATE TABLE `pessoa_fisicas` (
  `id` int(7) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `rg` varchar(15) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `data_nascim` date DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `logradouro` varchar(50) DEFAULT NULL,
  `numero` int(6) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `telefone_sec` varchar(20) DEFAULT NULL,
  `tipo` varchar(2) DEFAULT NULL,
  `orgao_expedidor` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pessoa_fisicas`
--

INSERT INTO `pessoa_fisicas` (`id`, `nome`, `cpf`, `rg`, `sexo`, `data_nascim`, `uf`, `cidade`, `cep`, `bairro`, `logradouro`, `numero`, `complemento`, `email`, `telefone`, `telefone_sec`, `tipo`, `orgao_expedidor`, `created_at`, `updated_at`) VALUES
(11, 'ALANA NINA PIETRA PEREIRA', '48580879647', '366046147', 'f', '1985-06-27', 'ES', 'Vitória', '29016320', 'Centro', 'Rua Serrat', 797, NULL, 'nalana@email.com', '2739019797', '27996212139', 'cf', NULL, '2017-09-22 00:19:01', '2017-09-22 00:19:01'),
(9, 'RODRIGO HENRY CARDOSO', '60266653901', '234889123', 'm', '1995-08-24', 'PR', 'Ponta Grossa', '84060588', 'Contorno', 'Rua Ary Lievore', 172, NULL, 'rodrigohenrycardoso_@kmspublicidade.com.br', '7936580391', '79989828171', 'cf', NULL, '2017-09-22 00:13:08', '2017-09-22 00:13:08'),
(8, 'CAIO RODRIGO FRANCISCO PEREIRA', '30049559974', '293807036', 'm', '1995-09-05', 'SE', 'Aracaju', '49001368', 'Zona de Expansão (Aruana)', 'Rua Professora Maria Eulina de Carvalho Batista', 711, NULL, 'caior@email.com', '4136992757', '41997707733', 'c', NULL, '2017-09-22 00:10:37', '2017-09-22 00:10:37'),
(10, 'ISABELLE MAITÊ ANTONELLA ALMEIDA', '89910760096', '106724253', 'f', '1993-08-20', 'AM', 'Parintins', '69153420', 'São Vicente de Paula', 'Rua Acioly Teixeira', 921, NULL, 'isabellema@uol.com.br', '9226351704', '92999502209', 'c', NULL, '2017-09-22 00:15:31', '2017-09-22 00:15:31'),
(7, 'DIEGO NICOLAS OLIVEIRA', '09731141936', '10.983.744-0', 'm', '1995-02-21', 'PR', 'Ponta Grossa', '84030320', 'Uvaranas', 'Rua Valério Ronchi', 155, NULL, 'ronaldandreyrnd@gmail.com', '42999900222', '42322211522', 'c', NULL, '2017-09-19 00:36:06', '2017-09-22 00:16:00'),
(12, 'CALEBE BRENO ALVES', '89246461339', '257474079', 'm', '2017-10-01', 'PR', 'Curitiba', '81265130', 'Augusta', 'Rua Faxinal', 762, 'perto', 'ccalebebrenoalves@bassanpeixoto.adv.br', '4125067482', '41981866860', 'c', 'SSP/PR', '2017-10-18 23:50:25', '2017-10-18 23:50:25'),
(15, 'EMANUELLY MARIA YASMIN DA SILVA', '84500779582', '364631107', 'f', '1985-04-15', 'PE', 'Camaragibe', '54762303', 'Bairro Novo do Carmelo', 'Avenida Doutor Belmino Correia', 971, 'fundos', 'emanuellymariayasmindasilva_@konzeption.com.br', '4232233222', '7784525522', 'c', 'SEPE', '2017-11-01 00:35:25', '2017-11-01 00:35:25'),
(16, 'TIAGO ALCANTARA MENDES', '07606584044', '109725540', 'm', '1995-02-21', 'PR', 'Ponta Grossa', '84060588', 'Contorno', 'Rua Ary Lievore', 58, 'casa 3', 'tiago.da@gehssl', '4232290102', '', '', 'SESP', '2017-11-01 00:40:13', '2017-11-01 00:56:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_juridicas`
--

CREATE TABLE `pessoa_juridicas` (
  `id` int(7) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `nome_fantasia` varchar(60) DEFAULT NULL,
  `razao_social` varchar(60) DEFAULT NULL,
  `inscricao_estadual` varchar(14) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `logradouro` varchar(50) DEFAULT NULL,
  `numero` int(6) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `telefone_sec` varchar(20) DEFAULT NULL,
  `tipo` varchar(2) DEFAULT NULL,
  `orgao_expedidor` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pessoa_juridicas`
--

INSERT INTO `pessoa_juridicas` (`id`, `cnpj`, `nome_fantasia`, `razao_social`, `inscricao_estadual`, `uf`, `cidade`, `cep`, `bairro`, `logradouro`, `numero`, `complemento`, `email`, `telefone`, `telefone_sec`, `tipo`, `orgao_expedidor`, `created_at`, `updated_at`) VALUES
(9, '75639254000153', 'VIT PH RESTAURANTE', 'Vitória e Pedro Henrique Restaurante ME', '3839661400', 'PR', 'Araucária', '83705195', 'Estação', 'Travessa Evaristo Druziak', 98, NULL, 'qualidade@vitoriaepedrohe.com', '4129995007', '41998242278', 'f', NULL, '2017-09-22 00:28:47', '2017-09-22 00:28:47'),
(8, '34011124000194', 'HC PUBLICIDADE E PROPAGANDA', 'HELENA E CAUÃ PUBLICIDADE E PROPAGANDA LTDA', '533806899045', 'SP', 'São Paulo', '03718020', 'Jardim São Francisco (Zona Leste)', 'Rua Juriti-Piranga', 641, NULL, 'manutencao@helena.com.br', '1135461055', '11999960173', 'cf', NULL, '2017-09-22 00:25:08', '2017-09-22 00:26:08'),
(7, '82653842000107', 'GABRIEL E BEATRIZ PADARIA', 'GABRIEL E BEATRIZ PADARIA ME', '405337309445', 'SP', 'São Paulo', '05126100', 'Parque São Domingos', 'Rua Joaquim Pereira Lima', 520, NULL, 'producao@gabrielebeatrizpadariame.com.br', '1139714545', '11993757032', 'c', NULL, '2017-09-22 00:21:42', '2017-09-22 00:26:25'),
(10, '67566055000134', 'ATACADO SIMAS', 'roberto simas ltda', '6675446022', 'PR', 'Francisco Beltrão', '85601821', 'Nova Petrópolis', 'Rua Ceará', 632, NULL, 'estoque@joanaepedrotelecomltda.com.br', '4626682861', '46993919515', 'f', NULL, '2017-09-22 00:32:04', '2017-09-22 00:32:04'),
(11, '03377283000183', 'BM INFORMATICA', 'Benjamin e Miguel Informática ME', '0885557597', 'PR', 'Araucária', '83702970', 'Centro', 'Rua Major Sezino Pereira de Souza', 210, NULL, 'fiscal@benjaminemiguelinformaticame.com.br', '4136204671', '41998505323', 'f', NULL, '2017-09-22 00:33:57', '2017-09-22 00:33:57'),
(12, '71566811000100', 'MII PAPELARIAS', 'Marcelo Isaac Ivone ltda.', '308040529187', 'SP', 'Campinas', '13015918', 'Centro', 'Rua Joaquim Novaes', 478, NULL, 'miipapel@mii.com', '1926411059', '19994192541', 'f', NULL, '2017-11-01 22:31:21', '2017-11-01 22:31:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(7) NOT NULL,
  `id_marca` int(7) NOT NULL,
  `id_departamento` int(7) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `codigo_barras` varchar(30) NOT NULL,
  `saldo` int(7) NOT NULL,
  `unidade_medida` varchar(10) NOT NULL,
  `posicao` varchar(3) NOT NULL,
  `corredor` int(7) NOT NULL,
  `prateleira` int(7) NOT NULL,
  `minimo` int(7) NOT NULL,
  `observacao` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `id_marca`, `id_departamento`, `descricao`, `codigo_barras`, `saldo`, `unidade_medida`, `posicao`, `corredor`, `prateleira`, `minimo`, `observacao`, `created_at`, `updated_at`) VALUES
(24, 8, 2, 'MONITOR LED 17"', '10101201212', 1, 'UNIDADES', 'B', 3, 15, 2, NULL, '2017-09-15 20:40:38', '2017-10-22 00:18:46'),
(25, 7, 2, 'MOUSE 1200 DPI', '111111111111', 30, 'UNIDADES', 'B', 3, 21, 5, NULL, '2017-09-15 20:41:30', '2017-09-15 20:41:30'),
(26, 7, 2, 'TECLADO MULTIMÍDIA', '3323232332232', 17, 'UNIDADES', 'B', 2, 17, 5, NULL, '2017-09-15 20:42:10', '2017-09-15 20:42:10'),
(27, 9, 3, 'BORRACHA BRANCA', '121222122', 10, 'CAIXAS', 'A', 2, 6, 4, 'CAIXA COM 10 UNIDADES', '2017-09-15 20:43:25', '2017-09-15 20:43:25'),
(28, 4, 3, 'LAPIS DE ESCREVER', '5121321213', 14, 'CAIXAS', 'A', 1, 5, 11, 'CAIXA COM 240 UNIDADES', '2017-09-15 20:44:17', '2017-09-16 01:19:54'),
(30, 12, 4, 'TINTA ACRILICA VERMELHA', '5416123123132', 11, 'CAIXAS', 'A', 1, 5, 2, 'CAIXA C/ 12', '2017-09-16 19:19:24', '2017-09-16 19:19:24'),
(32, 8, 2, 'NOTEBOOK CORE I5', '731509567403', 2, 'UNIDADES', 'C', 4, 12, 3, '8GB RAM 1TB HD', '2017-10-19 02:01:38', '2017-10-19 02:01:38'),
(33, 7, 2, 'IMPRESSORA HP2101', '1234567890128', 0, 'UNIDADES', 'C', 4, 31, 6, NULL, '2017-10-19 22:04:12', '2017-10-19 22:04:12'),
(34, 12, 3, 'TINTA GUACHE 6C 15ML', '1611457891241', 5, 'CAIXAS', 'C', 8, 9, 10, 'caixa com 36 unidades', '2017-10-22 00:18:19', '2017-10-22 00:18:19'),
(35, 4, 3, 'CANETA ESF 1.0 PRETA', '1165132131110', 17, 'CAIXAS', 'C', 7, 23, 9, 'caixa com 200 unidades', '2017-10-22 05:23:43', '2017-10-22 05:23:43'),
(37, 4, 3, 'COLA BASTÃO 10G', '5446559889010', 3, 'PACOTES', 'A', 4, 3, 8, 'pacote c/10', '2017-11-01 22:09:26', '2017-11-01 22:09:26'),
(38, 4, 3, 'CANETA ESF 1.0 AZUL', '1237894561457', 18, 'CAIXAS', 'A', 7, 4, 9, 'caixa com 10 unidades', '2017-11-02 02:49:00', '2017-11-02 02:49:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_solicitado`
--

CREATE TABLE `produto_solicitado` (
  `id` int(7) NOT NULL,
  `id_solicitacao_produto` int(7) NOT NULL,
  `id_produto` int(7) DEFAULT NULL,
  `qtd_solicitada` int(5) DEFAULT NULL,
  `qtd_atendida` int(5) DEFAULT NULL,
  `aprovado` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_solicitado`
--

INSERT INTO `produto_solicitado` (`id`, `id_solicitacao_produto`, `id_produto`, `qtd_solicitada`, `qtd_atendida`, `aprovado`) VALUES
(1, 3, 26, 2, 2, 1),
(2, 3, 25, 4, 4, 1),
(3, 4, 28, 1, 1, 1),
(4, 4, 27, 2, 0, 0),
(5, 5, 26, 3, 3, 1),
(6, 8, 27, 2, 0, 0),
(7, 14, 24, 2, 0, 0),
(8, 14, 26, 1, 0, 0),
(9, 19, 26, 2, 0, 0),
(10, 24, 30, 2, 0, 0),
(11, 25, 30, 1, 1, 1),
(12, 26, 24, 5, 5, 1),
(13, 27, 24, 1, 1, 1),
(14, 28, 30, 2, 1, 1),
(19, 44, 32, 8, 8, 1),
(20, 45, 34, 2, 1, 1),
(21, 46, 34, 3, 2, 1),
(22, 47, 25, 4, 4, 1),
(23, 47, 28, 3, 3, 1),
(79, 88, 35, 15, 8, 1),
(78, 88, 37, 9, 9, 1),
(80, 88, 28, 1, 1, 1);

--
-- Acionadores `produto_solicitado`
--
DELIMITER $$
CREATE TRIGGER `trigger_saldo_retirada` AFTER UPDATE ON `produto_solicitado` FOR EACH ROW BEGIN
	UPDATE produtos SET saldo = (saldo + old.qtd_atendida) - NEW.qtd_atendida
	WHERE id = NEW.id_produto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao_compra`
--

CREATE TABLE `solicitacao_compra` (
  `id` int(7) NOT NULL,
  `id_usuario_solicitante` int(7) NOT NULL,
  `id_usuario_confirma` int(7) DEFAULT NULL,
  `id_produto` int(7) NOT NULL,
  `data_solicitacao` date DEFAULT NULL,
  `data_confirmacao` date DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `solicitacao_compra`
--

INSERT INTO `solicitacao_compra` (`id`, `id_usuario_solicitante`, `id_usuario_confirma`, `id_produto`, `data_solicitacao`, `data_confirmacao`, `confirmado`) VALUES
(1, 1, 1, 35, '2017-11-01', '2017-11-01', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao_produto`
--

CREATE TABLE `solicitacao_produto` (
  `id` int(7) NOT NULL,
  `id_usuario_solicitante` int(7) NOT NULL,
  `id_usuario_aprova` int(7) DEFAULT NULL,
  `data_solicitacao` timestamp NOT NULL,
  `data_aprovacao` timestamp NULL DEFAULT NULL,
  `status` char(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `solicitacao_produto`
--

INSERT INTO `solicitacao_produto` (`id`, `id_usuario_solicitante`, `id_usuario_aprova`, `data_solicitacao`, `data_aprovacao`, `status`, `created_at`, `updated_at`) VALUES
(19, 1, 1, '2017-09-16 17:25:33', '2017-09-16 17:36:25', 'f', '2017-09-16 17:25:33', '2017-09-16 17:25:33'),
(5, 1, 1, '2017-09-15 22:26:17', '2017-09-15 20:08:42', 'f', '2017-09-15 22:26:17', '2017-09-15 22:26:17'),
(8, 1, 1, '2017-09-15 23:05:33', '2017-09-15 20:08:54', 'f', '2017-09-15 23:05:33', '2017-09-15 23:05:33'),
(14, 11, 11, '2017-09-16 01:21:37', '2017-09-15 22:24:30', 'f', '2017-09-16 01:21:37', '2017-09-16 01:21:37'),
(24, 1, 1, '2017-09-16 19:21:24', '2017-09-16 17:37:11', 'f', '2017-09-16 19:21:24', '2017-09-16 19:21:24'),
(25, 1, 1, '2017-09-16 19:35:37', '2017-09-16 17:35:49', 'f', '2017-09-16 19:35:37', '2017-09-16 19:35:37'),
(26, 1, 1, '2017-09-16 20:41:49', '2017-09-16 17:42:55', 'f', '2017-09-16 20:41:49', '2017-09-16 20:41:49'),
(27, 1, 1, '2017-09-16 21:04:00', '2017-09-16 18:05:16', 'f', '2017-09-16 21:04:00', '2017-09-16 21:04:00'),
(28, 1, 1, '2017-09-18 23:00:13', '2017-09-18 20:20:22', 'f', '2017-09-18 23:00:13', '2017-09-18 23:00:13'),
(44, 1, 1, '2017-10-28 00:04:14', '2017-10-27 22:05:20', 'f', '2017-10-28 00:04:14', '2017-10-28 00:04:14'),
(45, 1, 1, '2017-10-28 00:41:26', '2017-10-27 23:16:37', 'f', '2017-10-28 00:41:27', '2017-10-28 00:41:27'),
(46, 1, 1, '2017-10-28 14:38:43', '2017-10-28 13:12:21', 'f', '2017-10-28 14:38:44', '2017-10-28 14:38:44'),
(47, 1, 1, '2017-10-28 15:15:43', '2017-10-28 13:55:32', 'f', '2017-10-28 15:15:43', '2017-10-28 15:15:43'),
(88, 1, 1, '2017-11-02 02:35:36', '2017-11-02 00:38:02', 'f', '2017-11-02 02:35:36', '2017-11-02 02:35:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medidas`
--

CREATE TABLE `unidade_medidas` (
  `id_unidade_medida` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `unidade_medidas`
--

INSERT INTO `unidade_medidas` (`id_unidade_medida`, `nome`, `created_at`, `updated_at`) VALUES
(1, 'BLOCOS', NULL, NULL),
(2, 'BOBINAS', NULL, NULL),
(3, 'CARTELAS', NULL, NULL),
(4, 'CENTOS', NULL, NULL),
(5, 'CONJUNTOS', NULL, NULL),
(6, 'CENTIMETROS', NULL, NULL),
(7, 'CAIXAS', NULL, NULL),
(8, 'EMBALAGENS', NULL, NULL),
(9, 'FARDOS', NULL, NULL),
(10, 'FOLHAS', NULL, NULL),
(11, 'GRAMAS', NULL, NULL),
(12, 'JOGOS', NULL, NULL),
(13, 'QUILOGRAMAS', NULL, NULL),
(14, 'KIT', NULL, NULL),
(15, 'METROS', NULL, NULL),
(16, 'MILHEIROS', NULL, NULL),
(17, 'PACOTES', NULL, NULL),
(18, 'PALETES', NULL, NULL),
(19, 'PARES', NULL, NULL),
(20, 'PEÇAS', NULL, NULL),
(21, 'POTES', NULL, NULL),
(22, 'RESMAS', NULL, NULL),
(23, 'ROLOS', NULL, NULL),
(24, 'SACOS', NULL, NULL),
(25, 'SACOLAS', NULL, NULL),
(26, 'TUBOS', NULL, NULL),
(27, 'UNIDADES', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel` int(2) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nivel`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ronald', 'ronaldandreyrnd@gmail.com', 10, '$2y$10$C1YGR53DnI8Z7nylDMauDOiTCI4zKjCPWglwQnP.osoDBAQ85f.rG', 'ALefrs9PM6N1KdppCQd85xQyK3hpiLoB31ZFPvfHjsFVAdvERPQSMCLMjedl', '2017-07-14 04:00:54', '2017-07-14 04:02:52'),
(10, 'fid', 'fid@gmail.com', 10, '$2y$10$PevoqARmGY1kQJnyO1tcJexOp6KrSpW84AxwpJmiKHV7HwV/Z.FI6', NULL, '2017-09-02 01:51:45', '2017-09-02 01:51:45'),
(12, 'banca', 'banca@email.com', 1, '$2y$10$P/6IQ59duVbUjh0k6bcc3uPYrb5Jhf9UOhIROgufP8YtPFlBJJsGq', NULL, '2017-09-22 00:35:38', '2017-09-22 00:35:38'),
(0, 'root', 'cofee.uepg17@gmail.com', 10, '$2y$10$oJ0eJqXbRCvhAB.q9ST0augTJoyr8oWydMmV27oSG5T5t.i9rt6Iq', 'Q529lcQu3H3eriM2BOCCxVhe9JLgdVA3lxaSXkongymO5iBK7aeO7LyTiDuX', '2017-11-01 02:39:01', '2017-11-01 02:39:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fk_fornecedor` (`id_fornecedor`),
  ADD KEY `id_fk_usuario` (`id_usuario`);

--
-- Indexes for table `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fk_entrada` (`id_entrada`),
  ADD KEY `id_fk_produto` (`id_produto`);

--
-- Indexes for table `forma_pagamento`
--
ALTER TABLE `forma_pagamento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecedors`
--
ALTER TABLE `fornecedors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pessoa_fisica` (`id_pessoa_fisica`),
  ADD KEY `id_pessoa_juridica` (`id_pessoa_juridica`);

--
-- Indexes for table `historico_estoque`
--
ALTER TABLE `historico_estoque`
  ADD PRIMARY KEY (`id_historico_estoque`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcelas`
--
ALTER TABLE `parcelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_conta_pagar` (`id_conta_pagar`),
  ADD KEY `id_forma_pagamento` (`id_forma_pagamento`),
  ADD KEY `id_conta_receber` (`id_conta_receber`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pessoa_fisicas`
--
ALTER TABLE `pessoa_fisicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pessoa_juridicas`
--
ALTER TABLE `pessoa_juridicas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_barras_UNIQUE` (`codigo_barras`),
  ADD KEY `id_departamento` (`id_departamento`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indexes for table `produto_solicitado`
--
ALTER TABLE `produto_solicitado`
  ADD PRIMARY KEY (`id`,`id_solicitacao_produto`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `solicitacao_compra`
--
ALTER TABLE `solicitacao_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_solicitante` (`id_usuario_solicitante`);

--
-- Indexes for table `solicitacao_produto`
--
ALTER TABLE `solicitacao_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_solicitante` (`id_usuario_solicitante`),
  ADD KEY `id_usuario_aprova` (`id_usuario_aprova`);

--
-- Indexes for table `unidade_medidas`
--
ALTER TABLE `unidade_medidas`
  ADD PRIMARY KEY (`id_unidade_medida`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `entrada_produto`
--
ALTER TABLE `entrada_produto`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `forma_pagamento`
--
ALTER TABLE `forma_pagamento`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fornecedors`
--
ALTER TABLE `fornecedors`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pessoa_fisicas`
--
ALTER TABLE `pessoa_fisicas`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `pessoa_juridicas`
--
ALTER TABLE `pessoa_juridicas`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `produto_solicitado`
--
ALTER TABLE `produto_solicitado`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `solicitacao_compra`
--
ALTER TABLE `solicitacao_compra`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `solicitacao_produto`
--
ALTER TABLE `solicitacao_produto`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `unidade_medidas`
--
ALTER TABLE `unidade_medidas`
  MODIFY `id_unidade_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_fk_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`),
  ADD CONSTRAINT `produtos_fk_marca` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
