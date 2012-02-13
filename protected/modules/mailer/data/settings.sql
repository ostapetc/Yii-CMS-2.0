-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 21 2011 г., 17:50
-- Версия сервера: 5.1.54
-- Версия PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii_cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(50) NOT NULL COMMENT 'Модуль',
  `code` varchar(50) NOT NULL COMMENT 'Код',
  `name` varchar(100) NOT NULL COMMENT 'Заголовок',
  `value` text NOT NULL COMMENT 'Значение',
  `element` enum('text','textarea','editor') NOT NULL COMMENT 'Элемент',
  `hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Скрыта',
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`code`),
  UNIQUE KEY `title` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `module_id`, `code`, `name`, `value`, `element`, `hidden`) VALUES
(13, 'mailer', 'timeout', 'Таймаут отправки (сек.)', '30', 'text', 0),
(14, 'mailer', 'signature', 'Подпись в письме', 'Данное сообщение отправлено роботом, просим Вас на него не отвечать.', 'text', 0),
(15, 'mailer', 'encoding', 'Кодировка писем', 'KOI8-U', 'text', 0),
(16, 'mailer', 'reply_address', 'Адрес для ответа', 'reply@electro-polis.ru', 'text', 0),
(17, 'mailer', 'letters_part_count', 'Отправлять писем за раз', '10\r\n', 'text', 0),
(18, 'mailer', 'dispatch_time', 'Последнее время отправки', '2011-09-30 19:15:02', 'text', 0),
(19, 'mailer', 'from_name', 'Имя от кого', 'Yii CMS сайт', 'text', 0),
(20, 'mailer', 'host', 'Хост', 'mail.el.korolevsait.ru', 'text', 0),
(21, 'mailer', 'port', 'Порт', '25', 'text', 0),
(22, 'mailer', 'login', 'Логин', 'elpolis', 'text', 0),
(23, 'mailer', 'password', 'Пароль', 'EPdEUoTn', 'text', 0),
(24, 'mailer', 'from_email', 'От кого(Email)', 'test@ya.ru', 'text', 0);
