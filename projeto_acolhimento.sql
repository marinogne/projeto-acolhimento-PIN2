-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 21/10/2025 às 22:27
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_acolhimento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `IdAdministrador` int(20) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agressor`
--

CREATE TABLE `agressor` (
  `id_agressor` int(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `endereco` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agressor`
--

INSERT INTO `agressor` (`id_agressor`, `nome`, `endereco`) VALUES
(2, 'Pedro Teste 50', 'Rua Teste Agressor, 50'),
(3, 'João Pedro de Oliveira', 'Rua das Palmeiras, 70, Bairro Novo, São Paulo/SP  Exportar para as Planilhas'),
(5, 'Safado', 'rua dos trouxa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidadao`
--

CREATE TABLE `cidadao` (
  `id_cidadao` int(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nasci` date NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `id_login` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidadao`
--

INSERT INTO `cidadao` (`id_cidadao`, `nome`, `cpf`, `data_nasci`, `telefone`, `endereco`, `id_login`) VALUES
(4, 'Maria Mary Maria', '12345678901', '1985-01-15', '1135353535', 'Rua Teste Vitima, 100', 1),
(5, 'Ana Lúcia da Silva', '45678912300', '1985-05-20', '11987654321', 'Rua dos Ipês, 150, Centro, São Paulo/SP', 5),
(8, 'Duna Atreides', '11122233344', '2012-03-03', '11555554444', 'Palmas 107', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ocorrencia`
--

CREATE TABLE `ocorrencia` (
  `id_ocorrencia` int(20) NOT NULL,
  `id_vitima` int(20) NOT NULL,
  `id_agressor` int(20) NOT NULL,
  `relacao_com_agressor` varchar(100) NOT NULL,
  `tempo_relacao` varchar(50) NOT NULL,
  `tipo_violencia` varchar(100) NOT NULL,
  `primeira_agressao` enum('sim','nao') NOT NULL,
  `detalhe_violencia` varchar(400) DEFAULT NULL,
  `testemunhas` varchar(50) NOT NULL,
  `boletim_ocorrencia` enum('sim','nao') NOT NULL,
  `medida_protetiva` varchar(50) NOT NULL,
  `agressor_antecedentes` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ocorrencia`
--

INSERT INTO `ocorrencia` (`id_ocorrencia`, `id_vitima`, `id_agressor`, `relacao_com_agressor`, `tempo_relacao`, `tipo_violencia`, `primeira_agressao`, `detalhe_violencia`, `testemunhas`, `boletim_ocorrencia`, `medida_protetiva`, `agressor_antecedentes`) VALUES
(1, 4, 2, 'Ex-marido', '10 anos', 'Física,Verbal', 'sim', 'Detalhes do Teste', 'Sim_Filhos', 'nao', 'Solicitada', 'nao'),
(2, 5, 3, 'Ex-Companheiro', '5 anos', 'psicologica,sexual', 'nao', 'Agressão física ocorreu após discussão sobre finanças. Ameaças são constantes.', 'sim_outros', 'sim', 'nao', 'sim'),
(4, 8, 5, 'namorado', '2 meses', 'verbal,psicologica', 'nao', '', 'sim_outros', 'nao', 'sim', 'nao_sei');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(20) NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `senha`, `tipo_usuario`) VALUES
(1, 'teste', '$2y$10$DkODJnUvl0qlNl3SMpxfdu4yZ1pGC5B.bZWI7wQ7G0l0LM0dZi9Ve', 'Vitima'),
(5, 'teste5', '$2y$10$1mLOoCUGfyFA3X0VYxxBDeRchpfQr6ACAopTSJyXEA7Tivk/0nPyC', 'Vitima'),
(7, 'teste2', '$2y$10$da14Hu1pZ3L0XtVj2D/32eWIIgK21qpbdMSlxsro8BIp95fVjTLrm', 'Vitima'),
(8, 'IFSP', '$2y$10$ORX51A6vR2qHJCvIwl.dE.OG3.RlmKQ/xdtsz7srXzUhNvqZaoume', 'Vitima');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vitima`
--

CREATE TABLE `vitima` (
  `id_cidadao` int(20) NOT NULL,
  `etnia` varchar(50) NOT NULL,
  `possui_renda` enum('sim','nao') NOT NULL,
  `recebe_auxilio` enum('sim','nao') NOT NULL,
  `trabalha` enum('sim','nao') NOT NULL,
  `escolaridade` varchar(50) NOT NULL,
  `possui_filhos` enum('sim','nao') NOT NULL,
  `qtd_filhos_menores` int(5) DEFAULT NULL,
  `nome_mae` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vitima`
--

INSERT INTO `vitima` (`id_cidadao`, `etnia`, `possui_renda`, `recebe_auxilio`, `trabalha`, `escolaridade`, `possui_filhos`, `qtd_filhos_menores`, `nome_mae`) VALUES
(4, 'sem_declaracao', 'nao', 'nao', 'nao', 'fundamental_incompleto', 'sim', 11, 'Mãe da Maria'),
(5, 'parda', 'sim', 'nao', 'sim', 'medio_completo', 'sim', 2, 'Maria das Dores Silva'),
(8, 'indigena', 'nao', 'nao', 'nao', 'pos_graduacao', 'nao', 0, 'Doguinha Dog');

-- --------------------------------------------------------

--
-- Estrutura para tabela `voluntario`
--

CREATE TABLE `voluntario` (
  `idVoluntario` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `disponibilidade` varchar(30) NOT NULL,
  `areas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `voluntario`
--

INSERT INTO `voluntario` (`idVoluntario`, `nome`, `email`, `telefone`, `disponibilidade`, `areas`) VALUES
(1, 'Jose', 'jose@gmail.com', '1100090909', 'Tarde', 'Apoio psicológico'),
(2, 'aaa', 'aaa@gmail.com', '112222222', 'Noite', 'Apoio psicológico'),
(3, 'Teste Teste', 'teste@gmail.com', '11000200020', 'Tarde', 'Apoio jurídico'),
(4, 'Teste', 'teste1@gmail.com', '11000200020', 'Tarde', 'Divulgação');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`IdAdministrador`);

--
-- Índices de tabela `agressor`
--
ALTER TABLE `agressor`
  ADD PRIMARY KEY (`id_agressor`);

--
-- Índices de tabela `cidadao`
--
ALTER TABLE `cidadao`
  ADD PRIMARY KEY (`id_cidadao`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `id_login` (`id_login`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idFuncionario`);

--
-- Índices de tabela `ocorrencia`
--
ALTER TABLE `ocorrencia`
  ADD PRIMARY KEY (`id_ocorrencia`),
  ADD KEY `id_vitima` (`id_vitima`),
  ADD KEY `id_agressor` (`id_agressor`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `vitima`
--
ALTER TABLE `vitima`
  ADD PRIMARY KEY (`id_cidadao`);

--
-- Índices de tabela `voluntario`
--
ALTER TABLE `voluntario`
  ADD PRIMARY KEY (`idVoluntario`),
  ADD UNIQUE KEY `uq_voluntario_email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agressor`
--
ALTER TABLE `agressor`
  MODIFY `id_agressor` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cidadao`
--
ALTER TABLE `cidadao`
  MODIFY `id_cidadao` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `ocorrencia`
--
ALTER TABLE `ocorrencia`
  MODIFY `id_ocorrencia` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `voluntario`
--
ALTER TABLE `voluntario`
  MODIFY `idVoluntario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cidadao`
--
ALTER TABLE `cidadao`
  ADD CONSTRAINT `cidadao_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `ocorrencia`
--
ALTER TABLE `ocorrencia`
  ADD CONSTRAINT `ocorrencia_ibfk_1` FOREIGN KEY (`id_vitima`) REFERENCES `cidadao` (`id_cidadao`),
  ADD CONSTRAINT `ocorrencia_ibfk_2` FOREIGN KEY (`id_agressor`) REFERENCES `agressor` (`id_agressor`);

--
-- Restrições para tabelas `vitima`
--
ALTER TABLE `vitima`
  ADD CONSTRAINT `vitima_ibfk_1` FOREIGN KEY (`id_cidadao`) REFERENCES `cidadao` (`id_cidadao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
