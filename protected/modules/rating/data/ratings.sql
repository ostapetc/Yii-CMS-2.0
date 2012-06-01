-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: openserver:3306
-- Время создания: Июн 01 2012 г., 19:50
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
-- Структура таблицы `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `model_id` varchar(50) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`object_id`,`model_id`),
  KEY `object_id_model_id` (`object_id`,`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `object_id`, `model_id`, `value`, `date_create`) VALUES
(1, 36, 6, 'Comment', 1, '2012-06-01 15:23:42'),
(3, 36, 2, 'Comment', 1, '2012-06-01 15:24:40'),
(4, 36, 3, 'Comment', 1, '2012-06-01 15:24:42'),
(7, 36, 1, 'Comment', 1, '2012-06-01 15:24:46'),
(11, 36, 4, 'Comment', -1, '2012-06-01 15:25:41'),
(12, 36, 5, 'Comment', -1, '2012-06-01 15:25:42'),
(13, 36, 8, 'Comment', -1, '2012-06-01 15:25:44'),
(14, 36, 7, 'Comment', -1, '2012-06-01 15:25:45'),
(15, 36, 9, 'Comment', -1, '2012-06-01 15:25:46');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
