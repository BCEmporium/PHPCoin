-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 14-Ago-2011 às 23:25
-- Versão do servidor: 5.1.54
-- versão do PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de Dados: `phpcoin`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_name` varchar(64) NOT NULL,
  `balance` decimal(18,8) NOT NULL DEFAULT '0.00000000',
  `forward` tinyint(1) NOT NULL DEFAULT '0',
  `forward_to` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Estrutura da tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(16) NOT NULL,
  `value` varchar(32) NOT NULL,
  `explain` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`key`, `value`, `explain`) VALUES
('allow_register', 'true', 'Allow users to register with this bitcoind (values true/false)'),
('require_email', 'true', 'Whether a valid email address is needed to register a new account or not'),
('css_template', 'default', 'The CSS folder of the template to use'),
('account_prefix', 'PC', 'How to prefix accounts in bitcoind (eg. PC will result in PC_userid_account#)'),
('confirmations', '6', 'Number of block confirmations before make a deposit effective'),
('central_account', 'PC_MAIN', 'The bitcoin account that holds all the coins'),
('user_l_accounts', '5', 'The maximum allowed accounts associated with a single login');

-- --------------------------------------------------------

--
-- Estrutura da tabela `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `dtime` datetime NOT NULL,
  `message` varchar(255) NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `messages`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `movements`
--

CREATE TABLE IF NOT EXISTS `movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `dtime` datetime NOT NULL,
  `description` varchar(128) NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `credit` tinyint(1) NOT NULL DEFAULT '0',
  `balance` decimal(18,8) NOT NULL,
  `txblock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `movements`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `salt`
--

CREATE TABLE IF NOT EXISTS `salt` (
  `uid` int(11) NOT NULL,
  `salt` varchar(64) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

