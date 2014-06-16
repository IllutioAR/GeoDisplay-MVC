-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-06-2014 a las 01:13:29
-- Versión del servidor: 5.6.14
-- Versión de PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `geodisplay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Client`
--

CREATE TABLE IF NOT EXISTS `Client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `reseller_id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `plan` int(11) NOT NULL DEFAULT '0',
  `tags` int(11) NOT NULL DEFAULT '0',
  `space` float NOT NULL,
  `logo` varchar(128) NOT NULL DEFAULT 'uploadedmedia/default/logo/default.png',
  `language` varchar(20) NOT NULL DEFAULT 'English',
  `country` varchar(64) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `email` varchar(96) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`nick`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`),
  KEY `reseller_id` (`reseller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `comment` varchar(140) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`tag_id`),
  KEY `comment_tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Favorite`
--

CREATE TABLE IF NOT EXISTS `Favorite` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`tag_id`),
  KEY `favTag` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Multimedia`
--

CREATE TABLE IF NOT EXISTS `Multimedia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `type` varchar(8) NOT NULL,
  `size` float NOT NULL,
  `file_path` varchar(256) NOT NULL,
  `client_nick` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `Multimedia`
--
DROP TRIGGER IF EXISTS `decrease_space`;
DELIMITER //
CREATE TRIGGER `decrease_space` AFTER INSERT ON `Multimedia`
 FOR EACH ROW UPDATE Client SET space = space - new.size WHERE nick = new.client_nick
//
DELIMITER ;
DROP TRIGGER IF EXISTS `increase_space`;
DELIMITER //
CREATE TRIGGER `increase_space` AFTER DELETE ON `Multimedia`
 FOR EACH ROW UPDATE Client SET space = space - old.size WHERE nick = old.client_nick
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Multimedia_Tag`
--

CREATE TABLE IF NOT EXISTS `Multimedia_Tag` (
  `multimedia_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`multimedia_id`,`tag_id`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Reseller`
--

CREATE TABLE IF NOT EXISTS `Reseller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'English',
  `country` varchar(64) NOT NULL,
  `city` varchar(20) NOT NULL,
  `tags` int(11) NOT NULL,
  `space` int(11) NOT NULL,
  `email` varchar(94) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `map` varchar(128) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `url_purchase` varchar(256) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `client_nick` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `map` (`map`),
  KEY `client_id` (`client_nick`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Disparadores `Tag`
--
DROP TRIGGER IF EXISTS `decrease_tags`;
DELIMITER //
CREATE TRIGGER `decrease_tags` AFTER INSERT ON `Tag`
 FOR EACH ROW UPDATE Client SET tags = tags - 1 WHERE nick = NEW.client_nick
//
DELIMITER ;
DROP TRIGGER IF EXISTS `increase_tags`;
DELIMITER //
CREATE TRIGGER `increase_tags` AFTER DELETE ON `Tag`
 FOR EACH ROW UPDATE Client SET tags = tags + 1 WHERE nick = OLD.client_nick
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `language` varchar(20) NOT NULL,
  `country` varchar(64) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(96) NOT NULL DEFAULT 'uploadedmedia/default/profile/default.png',
  `email` varchar(96) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Client`
--
ALTER TABLE `Client`
  ADD CONSTRAINT `reseller_FK` FOREIGN KEY (`reseller_id`) REFERENCES `Reseller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `comment_tag_FK` FOREIGN KEY (`tag_id`) REFERENCES `Tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_usuario_FK` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Favorite`
--
ALTER TABLE `Favorite`
  ADD CONSTRAINT `favoriteTag_FK` FOREIGN KEY (`tag_id`) REFERENCES `Tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favoriteUser_FK` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Tag`
--
ALTER TABLE `Tag`
  ADD CONSTRAINT `client_FK` FOREIGN KEY (`client_nick`) REFERENCES `Client` (`nick`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
