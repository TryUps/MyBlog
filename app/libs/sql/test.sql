-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 08/12/2020 às 12:41
-- Versão do servidor: 5.7.26
-- Versão do PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Banco de dados: `MyBlog`
--
DROP DATABASE IF EXISTS `MyBlog`;
CREATE DATABASE IF NOT EXISTS `MyBlog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `MyBlog`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `category`
--
-- Criação: 08/12/2020 às 14:42
-- Última atualização: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `simple_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `group` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Despejando dados para a tabela `category`
--

INSERT INTO `category` (`id`, `name`, `simple_name`, `group`) VALUES
(0, 'Sem Categoria', 'sem-categoria', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comments`
--
-- Criação: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `author_ip` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_status` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `comment_group` bigint(20) NOT NULL DEFAULT '0',
  `comment_type` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `comment_post` (`post_id`),
  KEY `comment_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--
-- Criação: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `simple_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `type` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `post_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_cats`
--
-- Criação: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `post_cats` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_category` (`cat_id`),
  KEY `cat_post` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_tags`
--
-- Criação: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `simple_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tag_post` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `preferences`
--
-- Criação: 08/12/2020 às 15:40
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `enabled` set('0','1') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Define: ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Despejando dados para a tabela `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`, `enabled`, `comment`) VALUES
(1, 'blog_name', 'MyBlog', '1', 'Define: '),
(2, 'blog_desc', 'Best blog service', '1', 'Define: '),
(3, 'blog_url', 'http://localhost/myblog', '1', 'Define: '),
(4, 'blog_template', 'movies', '1', 'Define: '),
(5, 'blog_public', '1', '1', 'Define: '),
(6, 'admin_email', 'webmaster@localhost', '1', 'Define: '),
(7, 'maintenance', '0', '1', 'Define: '),
(8, 'maintenace_enddate', '00/00/0000 00:00:00', '1', 'Define: '),
(9, 'language', 'en-US', '1', 'Define: ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--
-- Criação: 08/12/2020 às 14:42
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `registered` datetime NOT NULL,
  `status` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `rank` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0' COMMENT '0 - Assinante, 1 - Assinante Notificado,  2 - Assinante Premium, 3 - Moderador, 4 - Administrador, 5 - Proprietario',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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



SELECT post.* FROM posts AS post
LEFT JOIN post_cats AS cat ON post.id = cat.post_id
LEFT JOIN category AS cats ON cats.cat_id = cat.id
LEFT JOIN category AS child ON child.group = cat.id
WHERE cat.name = 'ELECTRONICS' AND child.name = 'FLASH';