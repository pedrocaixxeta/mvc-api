-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Nov-2025 às 20:20
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco_mvc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `generos`
--

INSERT INTO `generos` (`id`, `nome`) VALUES
(1, 'Ficção Científica'),
(2, 'Terror'),
(3, 'Romance'),
(4, 'Fantasia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recomendacoes`
--

CREATE TABLE `recomendacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `livro_recomendado` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `recomendacoes`
--

INSERT INTO `recomendacoes` (`id`, `usuario_id`, `genero_id`, `livro_recomendado`) VALUES
(1, 2, 4, 'O Senhor dos Anéis');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'João Silva', 'joao@email.com', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa'),
(2, 'Maria Souza', 'maria@email.com', '$2y$10$pRl1xV2OBzxc4nhAfW1PxeZHuRJOJ/7mRmP5hwLQWyLd8xsG9AS.O'),
(4, 'Pedro', 'pedro@gmail.com', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa'),
(5, 'Aluno Nota 100', 'aluno100@teste.com', '$2y$10$0Cl0lhIDHg1UXUUaLvfer.KJaR3LSgZpBPVVhYtkuKLsZjUVKiUd6'),
(7, 'Teste Postman', 'teste@postman.com', '$2y$10$LdMZgq5VK6tdN5oQYwek3OXI7eb7vIslwn9tjRFrNhsq3f7P/cAhq'),
(9, 'Luana', 'luana@email.com', '$2y$10$s0TzBHRRMfKtjDwwLRQht.nOG5Bz1LuZk4YkSg55j.9xtedylWfl6'),
(10, 'alessandro', 'alessandro@email.com', '$2y$10$2Q52xnm69b1bF3FQvKoBuOaD41q01MEmdgAuulRd1kfCW0tEgtN76');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recomendacoes`
--
ALTER TABLE `recomendacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `recomendacoes`
--
ALTER TABLE `recomendacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `recomendacoes`
--
ALTER TABLE `recomendacoes`
  ADD CONSTRAINT `recomendacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `recomendacoes_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
