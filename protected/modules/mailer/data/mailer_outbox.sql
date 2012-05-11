-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: openserver:3306
-- Время создания: Апр 24 2012 г., 00:56
-- Версия сервера: 5.1.61
-- Версия PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yiicms_2.0`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mailer_outbox`
--

CREATE TABLE IF NOT EXISTS `mailer_outbox` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL COMMENT 'Шаблон',
  `email` varchar(750) DEFAULT NULL COMMENT 'Email',
  `subject` varchar(750) DEFAULT NULL COMMENT 'Тема письма',
  `body` longtext COMMENT 'Тело письма',
  `log` text COMMENT 'Лог',
  `status` enum('sent','queue','process','error') DEFAULT 'queue' COMMENT 'Статус',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата создания',
  `date_send` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `mailer_outbox`
--
ALTER TABLE `mailer_outbox`
  ADD CONSTRAINT `mailer_outbox_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
