-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08/12/2020 às 11:33
-- Versão do servidor: 5.7.26
-- Versão do PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Banco de dados: `MyBlog`
--
CREATE DATABASE IF NOT EXISTS `MyBlog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `MyBlog`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_520_ci,
  `term` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `group` bigint(20) NOT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Despejando dados para a tabela `category`
--

INSERT INTO `category` (`id`, `name`, `term`, `group`) VALUES
(1, 'Sem Categoria', 'sem-categoria', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `author_ip` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_status` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `comment_group` bigint(20) NOT NULL DEFAULT NULL,
  `comment_type` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `summary` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `views` decimal(10,0) NOT NULL DEFAULT '0',
  `post_security` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `comment_security` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `term` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `type` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `post_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_cats`
--

CREATE TABLE `post_cats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `term` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `preferences`
--

CREATE TABLE `preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Despejando dados para a tabela `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`) VALUES
(1, 'blog_name', 'MyBlog'),
(2, 'blog_desc', 'Best blog service'),
(3, 'blog_url', 'http://localhost/myblog'),
(4, 'blog_template', 'evo'),
(5, 'blog_public', '1'),
(6, 'admin_email', 'webmaster@localhost'),
(7, 'maintenance', '0'),
(8, 'maintenace_enddate', '00/00/0000 00:00:00'),
(9, 'language', 'en-US');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `registered` datetime NOT NULL,
  `status` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `rank` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0' COMMENT '0 - Assinante, 1 - Assinante Notificado,  2 - Assinante Premium, 3 - Moderador, 4 - Administrador, 5 - Proprietario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY (`term`);

--
-- Índices de tabela `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_post` (`post_id`),
  ADD KEY `comment_author` (`author_id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY (`term`),
  ADD KEY `post_author` (`author`);

--
-- Índices de tabela `post_cats`
--
ALTER TABLE `post_cats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_category` (`cat_id`),
  ADD KEY `cat_post` (`post_id`);

--
-- Índices de tabela `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_post` (`post_id`);

--
-- Índices de tabela `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `post_cats`
--
ALTER TABLE `post_cats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `post_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `post_cats`
--
ALTER TABLE `post_cats`
  ADD CONSTRAINT `cat_category` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cat_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `tag_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
