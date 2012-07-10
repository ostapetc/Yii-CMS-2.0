-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: openserver:3306
-- Время создания: Май 31 2012 г., 23:59
-- Версия сервера: 5.1.61
-- Версия PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yiicms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Пользователь',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
  `object_id` int(11) unsigned NOT NULL,
  `model_id` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Пользователь',
  `root` int(11) unsigned NOT NULL,
  `left` int(11) unsigned NOT NULL,
  `right` int(11) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `text` text NOT NULL COMMENT 'Комментарий',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY (`id`),
  KEY `root` (`root`),
  KEY `level` (`level`),
  KEY `left` (`left`),
  KEY `right` (`right`),
  KEY `user_id` (`user_id`),
  KEY `object_model` (`object_id`,`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `object_id`, `model_id`, `root`, `left`, `right`, `level`, `text`, `date_create`) VALUES
(1, 36, 0, 'Page_257', 1, 1, 6, 1, '1111', '2012-05-31 14:26:28'),
(2, 36, 0, 'Page_257', 2, 1, 2, 1, '2222', '2012-05-31 14:26:30'),
(3, 36, 0, 'Page_257', 3, 1, 4, 1, '3333', '2012-05-31 14:26:32'),
(4, 36, 0, 'Page_257', 4, 1, 2, 1, '4444', '2012-05-31 14:26:33'),
(5, 36, 0, 'Page_257', 1, 2, 5, 2, '1112', '2012-05-31 14:26:37'),
(6, 36, 0, 'Page_257', 1, 3, 4, 3, '111333', '2012-05-31 14:26:42'),
(7, 36, 0, 'Page_257', 3, 2, 3, 2, '33331', '2012-05-31 14:26:46');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
