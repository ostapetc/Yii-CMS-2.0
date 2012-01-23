-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 15 2011 г., 01:19
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- БД: `krut_ru`
--

-- --------------------------------------------------------

--
-- Структура таблицы `glossary`
--

CREATE TABLE IF NOT EXISTS `glossary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Автор',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `text` longtext NOT NULL COMMENT 'Текст',
  `photo` varchar(50) DEFAULT NULL COMMENT 'Фото',
  `state` enum('active','hidden') NOT NULL COMMENT 'Состояние',
  `date` date NOT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создана',
  `letter` varchar(1) DEFAULT '' COMMENT 'Буква',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lang` (`lang`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Дамп данных таблицы `glossary`
--

INSERT INTO `glossary` (`id`, `lang`, `user_id`, `title`, `text`, `photo`, `state`, `date`, `date_create`, `letter`) VALUES
(30, 'ru', 20, 'Лук', '<p><strong>Лук</strong> (от англ. <em>look</em> - внешний вид) - целостный образ человека, включающий в себя все элементы одежды, аксессуары, прическу и макияж.</p>', NULL, 'active', '2011-11-08', '2011-11-08 20:51:35', 'Л'),
(31, 'ru', 20, 'Outlet', '<p><strong>Outlet, Аутлет</strong> (от англ. <em>outlet</em> - выход, выпуск) - магазин, в котором представлена одежда, обувь и аксессуары прошлых сезонов с постоянными скидками. Может быть моно- и мультибрендовый.</p>', NULL, 'active', '2011-11-08', '2011-11-08 20:53:04', 'O'),
(32, 'ru', 20, 'Аутлет', '<p><strong>Аутлет, Outlet</strong> (от англ. <em>outlet</em> - выход, выпуск) - магазин, в котором представлена одежда, обувь и аксессуары прошлых сезонов с постоянными скидками. Может быть моно- и мультибрендовый.</p>', NULL, 'active', '2011-11-08', '2011-11-08 20:53:54', 'А'),
(28, 'ru', 20, 'Имиджмейкер', '<p><strong>Имиджмейкер</strong> (от англ. <em>image</em> - образ, <em>make</em> - делать) - специалист, который создает определенный образ (имидж) клиента в глазах окружающих, причем не только и не столько за счет одежды, сколько при помощи привлечения СМИ и механизмов формирования общественного мнения. Наиболее часто привлекается в политической сфере.</p>', NULL, 'active', '2011-11-08', '2011-11-08 20:46:26', 'И'),
(29, 'ru', 20, 'Тренд', '<p><strong>Тренд</strong> (от англ. <em>trend</em> - тенденция) - актуальное направление, веяние моды.</p>', NULL, 'active', '2011-11-08', '2011-11-08 20:49:05', 'Т');
