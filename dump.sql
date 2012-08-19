-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 19 2012 г., 20:08
-- Версия сервера: 5.1.62-community
-- Версия PHP: 5.4.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `cms2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(500) NOT NULL COMMENT 'Наименование',
  `place` varchar(900) NOT NULL COMMENT 'Место проведения',
  `desc` text NOT NULL COMMENT 'Описание события ',
  `image` varchar(50) NOT NULL COMMENT 'Фото',
  `date` varchar(50) NOT NULL COMMENT 'Дата проведения',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignments`
--

DROP TABLE IF EXISTS `auth_assignments`;
CREATE TABLE IF NOT EXISTS `auth_assignments` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_assignments`
--

INSERT INTO `auth_assignments` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, NULL, NULL),
('admin', 3, NULL, NULL),
('user', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_items`
--

DROP TABLE IF EXISTS `auth_items`;
CREATE TABLE IF NOT EXISTS `auth_items` (
  `name` varchar(64) NOT NULL COMMENT 'Название',
  `type` int(11) NOT NULL COMMENT 'Тип',
  `description` varchar(50) DEFAULT NULL COMMENT 'Описание',
  `bizrule` text COMMENT 'Бизнес-правило',
  `data` text COMMENT 'Данные',
  `allow_for_all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Доступно всем',
  PRIMARY KEY (`name`),
  UNIQUE KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_items`
--

INSERT INTO `auth_items` (`name`, `type`, `description`, `bizrule`, `data`, `allow_for_all`) VALUES
('admin', 2, 'Администратор', '', 's:0:"";', 0),
('content', 1, 'Контент', NULL, NULL, 0),
('guest', 2, 'Гость', NULL, 's:0:"";', 0),
('MenuAdmin_create', 0, 'Добавление меню', NULL, NULL, 0),
('MenuAdmin_delete', 0, 'Удаление меню', NULL, NULL, 0),
('MenuAdmin_manage', 0, 'Управление меню', NULL, NULL, 0),
('MenuAdmin_update', 0, 'Редактирование меню', NULL, NULL, 0),
('MenuSectionAdmin_create', 0, 'Добавление ссылки меню', NULL, NULL, 0),
('MenuSectionAdmin_delete', 0, 'Удаление ссылки меню', NULL, NULL, 0),
('MenuSectionAdmin_manage', 0, 'Управление ссылками меню', NULL, NULL, 0),
('MenuSectionAdmin_sorting', 0, 'Сортировка', NULL, NULL, 0),
('MenuSectionAdmin_update', 0, 'Редактирование ссылки меню', NULL, NULL, 0),
('MenuSectionAdmin_updateTree', 0, 'Редактирование дерева', NULL, NULL, 0),
('MenuSectionAdmin_view', 0, 'Просмотр ссылки меню', NULL, NULL, 0),
('moderator', 2, 'Модератор', '', 's:0:"";', 0),
('PageAdmin_create', 0, 'Добавление страницы', NULL, NULL, 0),
('PageAdmin_delete', 0, 'Удаление страницы', NULL, NULL, 0),
('PageAdmin_getJsonData', 0, 'Получение данных страницы (JSON)', NULL, NULL, 0),
('PageAdmin_manage', 0, 'Управление страницами', NULL, NULL, 0),
('PageAdmin_update', 0, 'Редактирование страницы', NULL, NULL, 0),
('PageAdmin_view', 0, 'Просмотр страницы', NULL, NULL, 0),
('PageSectionAdmin_create', 0, 'Создание Раздела страниц', NULL, NULL, 0),
('PageSectionAdmin_delete', 0, 'Удаление Раздела страниц', NULL, NULL, 0),
('PageSectionAdmin_manage', 0, 'Управление Разделами страниц', NULL, NULL, 0),
('PageSectionAdmin_update', 0, 'Редактирование Раздела страниц', NULL, NULL, 0),
('PageSectionAdmin_view', 0, 'Просмотр Раздела страниц', NULL, NULL, 0),
('SidebarAdmin_Create', 0, 'Создание сайдбара', NULL, NULL, 0),
('SidebarAdmin_Delete', 0, 'Удаление сайдбара', NULL, NULL, 0),
('SidebarAdmin_Manage', 0, 'Управление сайдбарами', NULL, NULL, 0),
('SidebarAdmin_Update', 0, 'Редактирование сайдбара', NULL, NULL, 0),
('SidebarAdmin_View', 0, 'Просмотр сайдбара', NULL, NULL, 0),
('user', 2, 'Пользователь', '', 's:7:"s:0:"";";', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_items_childs`
--

DROP TABLE IF EXISTS `auth_items_childs`;
CREATE TABLE IF NOT EXISTS `auth_items_childs` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `auth_items_childs`
--

INSERT INTO `auth_items_childs` (`parent`, `child`) VALUES
('content', 'MenuAdmin_delete'),
('content', 'MenuAdmin_manage'),
('content', 'MenuAdmin_update'),
('content', 'MenuSectionAdmin_create'),
('content', 'MenuSectionAdmin_delete'),
('content', 'MenuSectionAdmin_manage'),
('content', 'MenuSectionAdmin_sorting'),
('content', 'MenuSectionAdmin_update'),
('content', 'MenuSectionAdmin_updateTree'),
('content', 'MenuSectionAdmin_view'),
('content', 'PageAdmin_create'),
('content', 'PageAdmin_delete'),
('content', 'PageAdmin_getJsonData'),
('content', 'PageAdmin_manage'),
('content', 'PageAdmin_update'),
('content', 'PageAdmin_view'),
('content', 'PageSectionAdmin_create'),
('content', 'PageSectionAdmin_delete'),
('content', 'PageSectionAdmin_manage'),
('content', 'PageSectionAdmin_update'),
('content', 'PageSectionAdmin_view'),
('content', 'SidebarAdmin_Create'),
('content', 'SidebarAdmin_Delete'),
('content', 'SidebarAdmin_Manage'),
('content', 'SidebarAdmin_Update'),
('content', 'SidebarAdmin_View'),
('user', 'content');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_objects`
--

DROP TABLE IF EXISTS `auth_objects`;
CREATE TABLE IF NOT EXISTS `auth_objects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned NOT NULL COMMENT 'Объект',
  `model_id` varchar(50) NOT NULL COMMENT 'Модель',
  `role` varchar(64) NOT NULL COMMENT 'Роль',
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `inherit_templates` tinyint(1) DEFAULT '1',
  `inherit_settings` tinyint(1) DEFAULT '1',
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` text,
  `meta_descr` text,
  `is_empty` tinyint(1) DEFAULT '0',
  `alias` varchar(50) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`),
  KEY `level` (`level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=141 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `inherit_templates`, `inherit_settings`, `meta_title`, `meta_keywords`, `meta_descr`, `is_empty`, `alias`, `published`, `type`, `lft`, `rgt`, `level`, `updated`) VALUES
(1, 'root', 0, 0, NULL, NULL, NULL, 0, 'root', 1, NULL, 1, 54, 1, '2011-08-10 12:31:53'),
(2, 'Создание и продвижение сайта', 1, 1, NULL, NULL, NULL, 0, 'create', 1, 'Page', 12, 13, 4, '2011-08-14 02:44:50'),
(5, 'Хостинг для сайта и регистрация доменного имени', 1, 1, NULL, NULL, NULL, 0, 'hosting', 1, 'Page', 16, 17, 4, '2011-08-14 02:44:51'),
(6, 'Создание мультимедия презентации', 1, 1, NULL, NULL, NULL, 0, 'multimedia', 1, 'Page', 14, 15, 4, '2011-08-14 10:39:10'),
(59, 'Главная', 1, 1, NULL, NULL, NULL, 0, 'index', 1, 'Page', 3, 4, 3, '2011-08-14 02:44:52'),
(22, 'Партнеры', 1, 1, NULL, NULL, NULL, 0, 'partners', 0, 'Record', 33, 34, 3, '2011-08-14 02:45:10'),
(21, 'Портфолио', 1, 1, NULL, NULL, NULL, 1, 'portfolio', 1, 'Record', 23, 30, 3, '2011-08-14 02:45:10'),
(77, 'main', 1, 1, NULL, NULL, NULL, 0, 'main', 0, 'Page', 2, 41, 2, '2011-08-14 02:44:53'),
(78, 'errors', 1, 1, NULL, NULL, NULL, 0, 'errors', 1, 'Page', 42, 45, 2, '2011-08-14 02:44:53'),
(79, 'not_found', 1, 1, NULL, NULL, NULL, 0, 'not_found', 1, 'Page', 43, 44, 3, '2011-08-14 02:44:54'),
(80, 'Услуги', 1, 1, NULL, NULL, NULL, 1, 'services', 0, 'Page', 11, 22, 3, '2011-08-14 02:44:55'),
(81, 'Новости', 1, 1, NULL, NULL, NULL, 0, 'news', 1, 'Record', 31, 32, 3, '2011-08-14 02:45:09'),
(84, 'Текст на индексе', 1, 1, NULL, NULL, NULL, 0, 'index_text', 0, 'Page', 46, 47, 2, '2011-08-14 02:44:55'),
(88, 'Клиенты', 1, 1, NULL, NULL, NULL, 0, 'clients', 0, 'Record', 35, 36, 3, '2011-08-14 02:45:07'),
(89, 'Публикации', 1, 1, NULL, NULL, NULL, 0, 'publics', 0, 'Record', 37, 38, 3, '2011-08-14 02:45:07'),
(128, 'Контакты', 1, 1, NULL, NULL, NULL, 0, 'contacts', 0, 'Page', 39, 40, 3, '2011-08-14 02:44:56'),
(129, 'О компании', 1, 1, NULL, NULL, NULL, 0, 'about', 0, 'Page', 5, 10, 3, '2011-08-14 02:44:57'),
(130, 'История, деятельность и команда', 1, 1, NULL, NULL, NULL, 0, 'history-work-and-team', 1, 'Page', 6, 7, 4, '2011-08-14 02:44:57'),
(131, 'Вакансии', 1, 1, NULL, NULL, NULL, 0, 'vacancy', 1, 'Page', 8, 9, 4, '2011-08-14 02:44:57'),
(132, 'Дизайн и верстка полиграфической продукции', 1, 1, NULL, NULL, NULL, 0, 'polygraph-design-and-makeup', 1, 'Page', 18, 19, 4, '2011-08-14 02:44:57'),
(133, 'Создание фирменного стиля', 1, 1, NULL, NULL, NULL, 0, 'corporate-identity', 1, 'Page', 20, 21, 4, '2011-08-14 02:44:58'),
(135, 'Дизайны и интерфейсы', 1, 1, NULL, NULL, NULL, 0, 'design-and-interfaces', 1, 'Record', 24, 25, 4, '2011-08-14 02:45:03'),
(136, 'Мультимедия презентации', 1, 1, NULL, NULL, NULL, 0, 'multimedia-presentations', 1, 'Record', 26, 27, 4, '2011-08-14 02:45:05'),
(137, 'Графический дизайн и печатная продукция', 1, 1, NULL, NULL, NULL, 0, 'graphic-design-and-printed', 1, 'Record', 28, 29, 4, '2011-08-14 02:45:05'),
(138, 'Карта сайта', 1, 1, NULL, NULL, NULL, 0, 'map', 1, 'Page', 49, 50, 3, '2011-08-14 02:44:59'),
(139, 'Другое ', 1, 1, NULL, NULL, NULL, 1, 'other', 1, 'Page', 48, 51, 2, '2011-08-14 02:45:00'),
(140, 'Модуль Users', 1, 1, NULL, NULL, NULL, 0, 'users', 1, 'Page', 52, 53, 2, '2011-08-14 02:45:00');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`city_id`, `name`) VALUES
(1, 'Астана'),
(3, 'Актау');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Пользователь',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
  `object_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Пользователь',
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
  KEY `object_id_model_id` (`object_id`,`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `object_id`, `model_id`, `root`, `left`, `right`, `level`, `text`, `date_create`) VALUES
(1, 36, 256, 'Page', 1, 1, 2, 1, 'daw', '2012-06-01 10:57:26'),
(2, 36, 256, 'Page', 2, 1, 2, 1, 'Являюсь сторонником zsh. В bash оттуда перетянул регистронезависимое дополнение по Таb:', '2012-06-01 12:30:10'),
(3, 36, 256, 'Page', 3, 1, 10, 1, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked)\nНо в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:30:26'),
(4, 36, 256, 'Page', 3, 2, 9, 2, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked) Но в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:52:43'),
(5, 36, 256, 'Page', 3, 3, 8, 3, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked) Но в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:52:52'),
(6, 36, 256, 'Page', 3, 4, 7, 4, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked) Но в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:53:37'),
(7, 36, 256, 'Page', 7, 1, 2, 1, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked) Но в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:53:40'),
(8, 36, 256, 'Page', 3, 5, 6, 5, 'Да, примерно про это же я и написал в статье — у меня было практически так же, но буквами (M-modified, I-index, U-untracked) Но в итоге просто подсвечиваю ветку красным, если репозиторий «грязный» — этого оказалось достаточно. ', '2012-06-01 12:53:43'),
(9, 36, 256, 'Page', 9, 1, 2, 1, 'dada', '2012-06-01 13:07:41');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(100) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`key`, `value`) VALUES
('emailToRegistraiton', 'support@daso.ir'),
('siteTitle', 'daso.ir'),
('recentCommentCount', '5'),
('recentPostCount', '5'),
('recentQuestionsCount', '5'),
('siteDescr', 'daso.ir'),
('rssImgUrl', 'images/rss_img.png'),
('baseUrl', 'http://daso.ir/');

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `first_name` varchar(40) NOT NULL COMMENT 'Имя',
  `last_name` varchar(40) DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` varchar(40) DEFAULT NULL COMMENT 'Отчество',
  `company` varchar(80) DEFAULT NULL COMMENT 'Компания',
  `position` varchar(50) DEFAULT NULL COMMENT 'Должность',
  `phone` varchar(50) DEFAULT NULL COMMENT 'Телефон',
  `email` varchar(80) NOT NULL COMMENT 'Email',
  `section_id` int(11) NOT NULL COMMENT 'Раздел',
  `question` longtext NOT NULL COMMENT 'Вопрос',
  `answer` longtext COMMENT 'Ответ',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликовано',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добалено',
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `date` (`date_create`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faq_sections`
--

DROP TABLE IF EXISTS `faq_sections`;
CREATE TABLE IF NOT EXISTS `faq_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(200) NOT NULL COMMENT 'Название',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned NOT NULL COMMENT 'Тема',
  `name` varchar(200) NOT NULL COMMENT 'Имя',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `text` text NOT NULL COMMENT 'Текст',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file_manager`
--

DROP TABLE IF EXISTS `file_manager`;
CREATE TABLE IF NOT EXISTS `file_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` varchar(100) DEFAULT NULL COMMENT 'ID объекта',
  `model_id` varchar(100) DEFAULT NULL COMMENT 'Модель',
  `name` varchar(100) NOT NULL COMMENT 'Файл',
  `tag` varchar(100) DEFAULT NULL COMMENT 'Тег',
  `title` text COMMENT 'Название',
  `descr` text COMMENT 'Описание',
  `order` int(11) unsigned NOT NULL COMMENT 'Порядок',
  `path` varchar(250) NOT NULL COMMENT 'Путь к файлу',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `file_manager`
--

INSERT INTO `file_manager` (`id`, `object_id`, `model_id`, `name`, `tag`, `title`, `descr`, `order`, `path`) VALUES
(1, '13', 'News', 'e607ea11303b1ae216ce8410fb3d680f.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 1, ''),
(2, '13', 'News', '88364aee8a6ef951dcfadcdbe576e550.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 2, ''),
(3, '13', 'News', 'a627f1aa47a9cd775c348578fc23da58.png', 'files', 'wallpaper-linux-cli-commands-1280-1024.png', NULL, 3, ''),
(4, '13', 'News', 'b874601073fbc29c0ca0459d2ee7f7c8.jpg', 'files', 'OTHER-SmolovSummer2004_1024x768.jpg', NULL, 4, ''),
(5, '13', 'News', '3c664f65c64426ff95f413f48e12088d.jpg', 'files', 'ubuntualien.jpg', NULL, 5, ''),
(6, '13', 'News', 'b1d756441e6eae30632e1dc172041a8b.jpg', 'files', 'NATURE-AtTheEdgeOfAtmosphere_1024x768.jpg', NULL, 6, ''),
(7, '13', 'News', '8b45f94c61220ccf25b4c666b11a1b6b.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 7, ''),
(8, '13', 'News', '015e557b48ef1f20368f67dfd8fe3706.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 8, ''),
(9, '13', 'News', 'a91446c6617815267c8975043708464b.jpg', 'files', 'ski-resort-bad-hofgastein-1280x1024.jpg', NULL, 9, ''),
(10, '13', 'News', '1995e2446badb63bba8e92978d400d37.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x1024.JPG', NULL, 10, ''),
(11, '13', 'News', '61edbd42e55b69480b783b7054d370f5.jpg', 'files', 'awp05_alltolls_blogspot098-1280x1024.jpg', NULL, 11, ''),
(12, '2', 'Article', '[rutracker.org].t2959705.torrent', 'file', '[rutracker.org].t2959705.torrent', NULL, 1, 'upload/fileManager/95'),
(13, '2', 'Article', '[rutracker.org].t2959705.torrent', 'file', '[rutracker.org].t2959705.torrent', NULL, 2, 'upload/fileManager/06'),
(14, '2', 'Article', '[rutracker.org].t2203893.torrent', 'file', '[rutracker.org].t2203893.torrent', NULL, 3, 'upload/fileManager/d5'),
(15, '2', 'Article', '[rutracker.org].t3790516.torrent', 'file', '[rutracker.org].t3790516.torrent', NULL, 4, 'upload/fileManager/ef'),
(22, '2', 'News', '[rutracker.org].t3790516.torrent', 'file', '[rutracker.org].t3790516.torrent', NULL, 1, 'upload/fileManager/e1'),
(23, '1', 'News', '5.JPG', 'file', '5.JPG', NULL, 0, 'upload/fileManager/b8'),
(24, '1', 'News', 'IMG_1166.JPG', 'file', 'IMG_1166.JPG', NULL, 1, 'upload/fileManager/2c'),
(25, '1', 'News', 'IMG_1166.JPG', 'file', 'IMG_1166.JPG', NULL, 2, 'upload/fileManager/a8'),
(26, '1', 'News', '5.JPG', 'file', '5.JPG', NULL, 3, 'upload/fileManager/f8'),
(27, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 4, 'upload/fileManager/c2'),
(28, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 5, 'upload/fileManager/1a'),
(29, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 6, 'upload/fileManager/8e'),
(30, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 7, 'upload/fileManager/40'),
(31, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 8, 'upload/fileManager/c3'),
(32, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 9, 'upload/fileManager/a8'),
(33, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 10, 'upload/fileManager/41'),
(34, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 11, 'upload/fileManager/83'),
(35, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 12, 'upload/fileManager/55'),
(36, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 14, 'upload/fileManager/03'),
(37, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 13, 'upload/fileManager/62'),
(38, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 15, 'upload/fileManager/ae');

-- --------------------------------------------------------

--
-- Структура таблицы `image_gallery`
--

DROP TABLE IF EXISTS `image_gallery`;
CREATE TABLE IF NOT EXISTS `image_gallery` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `type_id` varchar(50) DEFAULT NULL,
  `src` varchar(255) DEFAULT NULL,
  `title` text,
  `descr` text,
  `created` timestamp NULL DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `image_gallery`
--

INSERT INTO `image_gallery` (`image_id`, `model_id`, `type_id`, `src`, `title`, `descr`, `created`, `sort`) VALUES
(62, 13, NULL, '5566_def_58.jpg', NULL, 'Сиськи', '2011-06-22 06:32:56', 18),
(59, 13, NULL, 'pr172.jpg', NULL, NULL, '2011-06-22 06:30:28', 15),
(49, 14, NULL, '6c15006e391e0410712d86a2f965a8b0.jpg', NULL, NULL, '2011-06-21 10:40:12', 5),
(50, 14, NULL, '7a92ee791c8d093fdca93b7e02093a67.jpg', NULL, NULL, '2011-06-21 10:40:17', 6),
(51, 14, NULL, '12c69b44e1cdb67fa025df540a4e6894_full.jpg', NULL, NULL, '2011-06-21 10:40:25', 7),
(52, 14, NULL, '4690b5661378af0afd3fe65569255006_full.jpg', NULL, NULL, '2011-06-21 10:40:34', 8),
(60, 13, NULL, 'b272.jpg', NULL, NULL, '2011-06-22 06:30:33', 16),
(61, 13, NULL, '120429424830_7.jpg', NULL, NULL, '2011-06-22 06:32:16', 17),
(55, 13, NULL, 'b2.jpg', NULL, 'sdfsdf', '2011-06-22 05:41:01', 11),
(56, 13, NULL, 'img169.jpg', NULL, NULL, '2011-06-22 05:43:57', 12),
(57, 13, NULL, 'img147.jpg', NULL, NULL, '2011-06-22 05:49:34', 13),
(64, 13, NULL, 'a_e062f811f.jpg', NULL, NULL, '2011-06-22 06:34:55', 20),
(65, 13, NULL, 'a_e062f8f67.jpg', NULL, NULL, '2011-06-22 06:36:52', 21),
(68, 13, NULL, 'a_e062f8f34.jpg', NULL, NULL, '2011-06-22 06:42:14', 23);

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` char(2) NOT NULL COMMENT 'ID',
  `name` varchar(15) NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
('en', 'english'),
('ru', 'русский');

-- --------------------------------------------------------

--
-- Структура таблицы `languages_messages`
--

DROP TABLE IF EXISTS `languages_messages`;
CREATE TABLE IF NOT EXISTS `languages_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) NOT NULL COMMENT 'Категория',
  `message` text NOT NULL COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=211 ;

--
-- Дамп данных таблицы `languages_messages`
--

INSERT INTO `languages_messages` (`id`, `category`, `message`) VALUES
(1, 'main', 'Скрыть'),
(156, 'main', 'Управление страницами'),
(157, 'main', 'Добавление страницы'),
(158, 'main', 'Просмотр страницы'),
(159, 'main', 'Редактирование страницы'),
(160, 'main', 'Удаление страницы'),
(161, 'main', 'Получение данных страницы (JSON)'),
(162, 'main', 'Система'),
(163, 'main', 'Страницы сайта'),
(164, 'main', 'Язык'),
(165, 'main', 'Заголовок'),
(166, 'main', 'Адрес'),
(167, 'main', 'Текст'),
(168, 'main', 'Опубликована'),
(169, 'main', 'Создана'),
(170, 'main', 'Да'),
(171, 'main', 'Админ панель'),
(172, 'main', 'На сайт'),
(173, 'main', 'Выйти'),
(174, 'main', 'Быстрый поиск'),
(175, 'main', 'Контент'),
(176, 'main', 'Список страниц'),
(177, 'main', 'Добавить страницу'),
(178, 'main', 'Блоки страниц'),
(179, 'main', 'Добавить блок'),
(180, 'main', 'Управление меню'),
(181, 'main', 'Добавить меню'),
(182, 'main', 'Мета-теги'),
(183, 'main', 'Добавить мета-тег'),
(184, 'main', 'Логирование'),
(185, 'main', 'Действия сайта'),
(186, 'main', 'Обратная связь'),
(187, 'main', 'Языки'),
(188, 'main', 'Добавить язык'),
(189, 'main', 'Настройки'),
(190, 'main', 'Пользователи'),
(191, 'main', 'Все пользователи '),
(192, 'main', 'Добавить пользователя'),
(193, 'main', 'показать'),
(194, 'main', 'Главное'),
(195, 'main', 'Главная'),
(196, 'main', 'Новости'),
(197, 'main', 'Разработчики'),
(198, 'main', 'Инструменты'),
(199, 'main', 'Обзор'),
(200, 'main', 'Документация'),
(201, 'main', 'Языковые сообщения'),
(202, 'main', 'Языковые переводы'),
(203, 'main', 'Добавить Языковые сообщения'),
(204, 'main', 'Языки (сообщения)'),
(205, 'main', 'Языки (сообщения) добавить'),
(206, 'main', 'Языки (переводы)'),
(207, 'main', 'Языки (добавить перевод)'),
(208, 'main', 'Главная страница'),
(209, 'main', 'Редактировать'),
(210, 'main', 'View details');

-- --------------------------------------------------------

--
-- Структура таблицы `languages_translations`
--

DROP TABLE IF EXISTS `languages_translations`;
CREATE TABLE IF NOT EXISTS `languages_translations` (
  `id` int(11) NOT NULL,
  `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
  `translation` text COMMENT 'Перевод',
  PRIMARY KEY (`id`,`language`),
  KEY `language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `languages_translations`
--

INSERT INTO `languages_translations` (`id`, `language`, `translation`) VALUES
(162, 'en', 'System'),
(162, 'ru', 'Система'),
(175, 'en', 'Content'),
(176, 'en', 'Pages list'),
(177, 'en', 'Create page'),
(178, 'en', 'Page blocks'),
(179, 'en', 'Create page block'),
(180, 'en', 'Manage menu'),
(181, 'en', 'Ceate menu'),
(182, 'en', 'Meta tags'),
(183, 'en', 'Add meta tag'),
(184, 'en', 'Logging'),
(185, 'en', 'Site actions'),
(186, 'en', 'Feedback'),
(187, 'en', 'Languages'),
(188, 'en', 'Add language'),
(189, 'en', 'Settings'),
(196, 'en', 'News');

-- --------------------------------------------------------

--
-- Структура таблицы `lll`
--

DROP TABLE IF EXISTS `lll`;
CREATE TABLE IF NOT EXISTS `lll` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) DEFAULT NULL COMMENT 'Тип',
  `category` varchar(128) DEFAULT NULL COMMENT 'Категория',
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время',
  `message` text COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `log`
--

INSERT INTO `log` (`id`, `level`, `category`, `logtime`, `message`) VALUES
(1, 'error', 'php', '2012-04-17 21:08:36', 'Invalid argument supplied for foreach() (W:\\html\\yiicms2\\www\\protected\\components\\ActiveRecord.php:57)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CFormInputElement.php(186): AdminFormInputElement->getLabel()\n#1 W:\\html\\yiicms2\\www\\protected\\components\\formElements\\AdminFormInputElement.php(86): AdminFormInputElement->renderLabel()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CFormInputElement.php(170): AdminFormInputElement->renderLabel()\n#3 W:\\html\\yiicms2\\www\\protected\\components\\Form.php(151): AdminFormInputElement->render()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CForm.php(477): Form->renderElement()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CForm.php(461): Form->renderElements()\n#6 W:\\html\\yiicms2\\www\\protected\\components\\Form.php(120): Form->renderBody()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CForm.php(377): Form->renderBody()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\form\\CFormElement.php(62): Form->render()\n#9 W:\\html\\yiicms2\\www\\protected\\components\\Form.php(108): Form->__toString()\n#10 W:\\html\\yiicms2\\www\\protected\\modules\\content\\views\\pageAdmin\\create.php(4): Form->__toString()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CBaseController.php(127): require()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CBaseController.php(96): PageAdminController->renderInternal()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(870): PageAdminController->renderFile()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(783): PageAdminController->renderPartial()\n#15 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(48): PageAdminController->render()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionCreate()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#22 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#23 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#24 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#25 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#26 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#27 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#28 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#29 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#30 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#31 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#32 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#33 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#34 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#35 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#36 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/create'),
(2, 'error', 'php', '2012-04-17 21:20:04', 'Undefined variable: id (W:\\html\\yiicms2\\www\\protected\\views\\layouts\\admin\\main.php:79)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(785): PageAdminController->renderFile()\n#1 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(30): PageAdminController->render()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionManage()\n#3 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#6 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#9 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#10 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#15 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#22 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/manage'),
(3, 'error', 'php', '2012-04-17 21:20:09', 'Undefined variable: id (W:\\html\\yiicms2\\www\\protected\\views\\layouts\\admin\\main.php:79)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(785): PageAdminController->renderFile()\n#1 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(30): PageAdminController->render()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionManage()\n#3 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#6 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#9 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#10 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#15 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#22 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/manage'),
(4, 'error', 'php', '2012-04-17 21:20:11', 'Undefined variable: id (W:\\html\\yiicms2\\www\\protected\\views\\layouts\\admin\\main.php:79)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(785): PageAdminController->renderFile()\n#1 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(30): PageAdminController->render()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionManage()\n#3 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#6 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#9 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#10 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#15 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#22 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/manage'),
(5, 'error', 'php', '2012-04-17 21:20:13', 'Undefined variable: id (W:\\html\\yiicms2\\www\\protected\\views\\layouts\\admin\\main.php:79)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(785): PageAdminController->renderFile()\n#1 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(30): PageAdminController->render()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionManage()\n#3 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#6 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#9 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#10 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#15 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#22 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/manage'),
(6, 'error', 'php', '2012-04-17 21:20:16', 'Undefined variable: id (W:\\html\\yiicms2\\www\\protected\\views\\layouts\\admin\\main.php:79)\nStack trace:\n#0 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(785): PageAdminController->renderFile()\n#1 W:\\html\\yiicms2\\www\\protected\\modules\\content\\controllers\\PageAdminController.php(30): PageAdminController->render()\n#2 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\actions\\CInlineAction.php(50): PageAdminController->actionManage()\n#3 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(309): CInlineAction->runWithParams()\n#4 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(134): PageAdminController->runAction()\n#5 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#6 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): ThemeFilter->filter()\n#7 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#8 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): StatisticFilter->filter()\n#9 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#10 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): XssFilter->filter()\n#11 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#12 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): HttpsFilter->filter()\n#13 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#14 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): SiteEnableFilter->filter()\n#15 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilter.php(41): CFilterChain->run()\n#16 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\filters\\CFilterChain.php(131): LanguageFilter->filter()\n#17 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(292): CFilterChain->run()\n#18 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CController.php(266): PageAdminController->runActionWithFilters()\n#19 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(276): PageAdminController->run()\n#20 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\web\\CWebApplication.php(135): WebApplication->runController()\n#21 W:\\html\\yiicms2\\www\\protected\\libs\\yii\\base\\CApplication.php(162): WebApplication->processRequest()\n#22 W:\\html\\yiicms2\\www\\index.php(29): WebApplication->run()\nREQUEST_URI=/ru/content/pageAdmin/manage');

-- --------------------------------------------------------

--
-- Структура таблицы `lookup`
--

DROP TABLE IF EXISTS `lookup`;
CREATE TABLE IF NOT EXISTS `lookup` (
  `lookup_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`lookup_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Дамп данных таблицы `lookup`
--

INSERT INTO `lookup` (`lookup_id`, `type`, `code`, `name`, `position`) VALUES
(18, 'deleteCategoryVariant', '1', 'Скопировать в другую категорию', 0),
(19, 'deleteCategoryVariant', '0', 'Удалить', 1),
(7, 'gender', '0', 'Женский', 0),
(8, 'gender', '1', 'Мужской', 1),
(12, 'role', 'admin', 'Администратор', 3),
(13, 'MPublished', '0', 'Не Опубликован', 0),
(14, 'MPublished', '1', 'Опубликован', 1),
(40, 'FPublished', '0', 'Не Опубликована', 0),
(41, 'FPublished', '1', 'Опубликована', 1),
(42, 'NPublished', '0', 'Не Опубликовано', 0),
(43, 'NPublished', '1', 'Опубликовано', 1),
(38, 'YesNo', '0', 'Нет', 0),
(39, 'YesNo', '1', 'Да', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mailer_outbox`
--

DROP TABLE IF EXISTS `mailer_outbox`;
CREATE TABLE IF NOT EXISTS `mailer_outbox` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'Получатель',
  `template_id` int(11) unsigned NOT NULL COMMENT 'Шаблон',
  `email` varchar(750) DEFAULT NULL COMMENT 'Email',
  `subject` varchar(750) DEFAULT NULL COMMENT 'Тема письма',
  `body` longtext COMMENT 'Тело письма',
  `log` text COMMENT 'Лог',
  `status` enum('sent','queue','process','error') DEFAULT 'queue' COMMENT 'Статус',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Дата создания',
  `date_send` timestamp NULL DEFAULT NULL COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `mailer_outbox`
--

INSERT INTO `mailer_outbox` (`id`, `user_id`, `template_id`, `email`, `subject`, `body`, `log`, `status`, `date_create`, `date_send`) VALUES
(10, 36, 5, 'artem-moscow@yandex.ru', 'Восстановление пароля на сайте YOO CMF', '<!doctype>\r\n<html>\r\n	<head>\r\n		<meta http-equiv="content-type" content="text/html" charset="utf-8" />\r\n		<title>Восстановление пароля на сайте {{PROJECT_NAME}}</title>\r\n        <style type="text/css">\r\n        table, tbody, tr, td, img, font, a, i {\r\n            font-family: Arial;\r\n            border:0;\r\n            padding: 0;\r\n            margin: 0;\r\n            border-collapse: collapse;\r\n        }\r\n        p {\r\n            margin: 1em 0px;\r\n        }\r\n        font {\r\n            display: inline;\r\n        }\r\n      	</style>\r\n	</head>\r\n	<body style="margin:0;padding:0;width:800px; background: white;">\r\n        <p>Для восстановления пароля перейдите&nbsp;<a href="http://yiicms2/changePassword/d986e338c2d63b727efa0fb6449be748">по этой ссылке</a>.</p>\r\n<p>Адрес ссылки: http://yiicms2/changePassword/d986e338c2d63b727efa0fb6449be748</p>\r\n	</body>\r\n</html>', NULL, 'sent', '2012-05-19 16:08:24', '2012-05-19 16:08:48');

-- --------------------------------------------------------

--
-- Структура таблицы `mailer_templates`
--

DROP TABLE IF EXISTS `mailer_templates`;
CREATE TABLE IF NOT EXISTS `mailer_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(70) NOT NULL COMMENT 'Код',
  `name` varchar(200) NOT NULL COMMENT 'Название',
  `subject` varchar(200) NOT NULL COMMENT 'Тема письма',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `mailer_templates`
--

INSERT INTO `mailer_templates` (`id`, `code`, `name`, `subject`, `date_create`) VALUES
(3, 'user_activation', 'Активация аккаунта', 'Активация аккаунта на сайте {{PROJECT_NAME}}', '2012-04-23 19:32:27'),
(4, 'user_registration', 'Регистрация пользователя', 'Вы зарегистрировались на сайте {{PROJECT_NAME}}', '2012-04-30 12:00:32'),
(5, 'user_change_password ', 'Восстановление пароля', 'Восстановление пароля на сайте {{PROJECT_NAME}}', '2012-05-18 20:29:18');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `code` varchar(50) NOT NULL COMMENT 'Код',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  `lang` varchar(2) DEFAULT NULL COMMENT 'Язык',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `menu_language_fk` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `language`, `name`, `code`, `is_published`, `lang`) VALUES
(1, 'ru', 'Верхнее меню', 'TOP_MENU', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_sections`
--

DROP TABLE IF EXISTS `menu_sections`;
CREATE TABLE IF NOT EXISTS `menu_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Привязка к странице',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
  `root` int(11) unsigned DEFAULT NULL,
  `left` int(11) unsigned NOT NULL,
  `right` int(11) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(200) NOT NULL COMMENT 'Адрес',
  `module_url` varchar(300) DEFAULT NULL COMMENT 'Раздел модуля',
  `module_id` varchar(64) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `menu_sections`
--

INSERT INTO `menu_sections` (`id`, `lang`, `page_id`, `menu_id`, `root`, `left`, `right`, `level`, `title`, `url`, `module_url`, `module_id`, `is_published`) VALUES
(1, 'ru', NULL, 1, 1, 1, 8, 1, 'Верхнее меню::корень', '', NULL, NULL, 0),
(2, 'ru', NULL, 1, 1, 2, 5, 2, 'Новости', '/', '/news/news/index', 'news', 1),
(34, 'ru', 2, 1, 1, 3, 4, 3, 'dsdf', '', NULL, NULL, 1),
(35, 'ru', NULL, 1, 1, 6, 7, 2, 'addd', '', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `meta_tags`
--

DROP TABLE IF EXISTS `meta_tags`;
CREATE TABLE IF NOT EXISTS `meta_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned DEFAULT NULL COMMENT 'ID объекта',
  `model_id` varchar(50) NOT NULL COMMENT 'Модель',
  `title` varchar(300) DEFAULT NULL COMMENT 'Заголовок',
  `keywords` varchar(300) DEFAULT NULL COMMENT 'Ключевые слова',
  `description` varchar(300) DEFAULT NULL COMMENT 'Описание',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  `date_update` datetime DEFAULT NULL COMMENT 'Отредактирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_id` (`object_id`,`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `object_id`, `model_id`, `title`, `keywords`, `description`, `date_create`, `date_update`) VALUES
(7, 1, 'Page', 'www', 'rtyrtyry', 'trfyhr', '2011-10-19 14:25:29', '2012-04-21 16:33:42'),
(8, 3, 'News', 'zzzz', 'keyww', 'oppp', '2011-10-20 10:10:13', '2011-10-20 13:12:40'),
(13, 3, 'Page', NULL, NULL, NULL, '2012-03-25 18:28:06', '2012-04-19 00:08:28'),
(14, 4, 'Page', NULL, NULL, NULL, '2012-04-21 20:40:10', NULL),
(15, 5, 'Page', NULL, NULL, NULL, '2012-04-21 20:40:46', NULL),
(16, 6, 'Page', NULL, NULL, NULL, '2012-04-21 20:41:43', NULL),
(17, 7, 'Page', NULL, NULL, NULL, '2012-04-21 20:42:22', NULL),
(18, 8, 'Page', NULL, NULL, NULL, '2012-04-21 20:42:29', NULL),
(19, 9, 'Page', NULL, NULL, NULL, '2012-04-21 20:43:07', NULL),
(20, 10, 'Page', NULL, NULL, NULL, '2012-04-21 20:44:22', NULL),
(21, 11, 'Page', NULL, NULL, NULL, '2012-04-21 20:45:19', NULL),
(22, 12, 'Page', NULL, NULL, NULL, '2012-05-12 20:19:09', NULL),
(23, 13, 'Page', NULL, NULL, NULL, '2012-05-12 20:20:27', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Автор',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `text` longtext NOT NULL COMMENT 'Текст',
  `photo` varchar(50) DEFAULT NULL COMMENT 'Фото',
  `is_published` tinyint(1) NOT NULL COMMENT 'Опубликована',
  `date` date NOT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lang` (`lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `lang`, `user_id`, `title`, `text`, `photo`, `is_published`, `date`, `date_create`) VALUES
(1, 'ru', NULL, 'IdeaPad Y570: мощный ноутбук по разумной цене', '<p>В блоге компании Lenovo на Хабре мы уделяем наибольшее внимание серии ThinkPad, что вполне логично &ndash; судя по отзывам, большинству из вас по нраву как раз эти модели, созданные для работы и творчества, крепкие и строгие внешне. Но сегодня у нас обзор модели IdeaPad Y570, яркого представителя &laquo;пользовательской&raquo; серии ноутбуков Lenovo, весьма отличающейся от унаследованных у IBM бизнес-моделей. Обойти вниманием такой ноутбук сложно: при стоимости от 30 тысяч рублей он предоставляет в ваше распоряжение одну из самых мощных видеокарт, современный процессор Intel Core, а также невероятно быструю дисковую систему. Гибрид из емкого жесткого диска и быстрого SSD именно в &laquo;пятьсот семидесятом&raquo; стал штатным: им оснащается большинство модификаций ноутбука. В этом обзоре я расскажу о том, чем хороша загрузка за 15 секунд, какие изменения произошли в новой модели Y-серии, а также о том, почему стоит выбрать именно эту модель в качестве домашнего развлекательного центра.</p>', '80f3dfc8fb0c6fe5c33950e89eed32cf.jpeg', 1, '2006-04-24', '2012-05-22 16:26:43'),
(2, 'ru', 1, 'Твиттер запустит инструмент для веб-аналитики', '<p>Сколько трафика ваш сайт получает из Твиттера? Дать ответ на этот вопрос позволит анонсированный Твиттером инструмент для веб-аналитики под названием Twitter Web Analytics.<br /><br />Новый инструмент призван дать владельцам сайтов больше данных об эффективности их интеграции с Твиттером. Он основан на технологиях компании BackType, которая занимается социальной аналитикой и которую Твиттер купил в июне.<br /><a></a><br />Как <a href="https://dev.twitter.com/blog/introducing-twitter-web-analytics">пояснил</a> основатель BackType и новый сотрудник Твиттера Кристофер Голда, Twitter Web Analytics поможет владельцам сайтов понимать три ключевых момента: сколько их контента распространяется в Твиттере, сколько трафика их сайт получает из Твиттера, и насколько эффективны кнопки Твиттера.<br /><br />Как видно на скриншоте, панель аналитики состоит из четырёх вкладок. Первая, &laquo;трафик&raquo;, отображает число твитов со ссылками на сайт и количество кликов по этим ссылкам. Графики доступны для текущего дня, прошлой недели и прошлого месяца. Вкладка &laquo;твиты&raquo; показывает все твиты, содержащие ссылки на сайт, а также все твиты, отправленные из встроенных кнопок Твиттера на сайте. Администратор может ретвитить и отвечать на твиты из этой панели. Вкладка &laquo;кнопка Твиттера&raquo; показывает, насколько активно используются кнопки Твиттера на сайте, а вкладка &laquo;контент&raquo; показывает наиболее эффективные страницы сайта.<br /><br />По словам директора Твиттера по развитию веб-бизнеса Эйприл Андервуд, данные будут очищены от ботов и спама. Твиттер также выпустит API инструмента для разработчиков.<br /><br />Twitter Web Analytics бесплатен и пока что в бета-версии. Небольшая группа партнёров получит к нему доступ на этой неделе, а для всех он будет запущен в течение нескольких недель.</p>', 'be8a93e588f5469ee426a77a66e2444a.png', 1, '2011-09-05', '0000-00-00 00:00:00'),
(3, 'ru', 1, 'Microsoft выпустил Windows 8 Developer Preview', '<p>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong><br /></strong></strong></p>\r\n<p>На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>', '328a76e70961ee6f64165f802d281e09.jpg', 1, '2011-09-14', '0000-00-00 00:00:00'),
(4, 'en', NULL, 'Intel brandishes first Google Android tablet', '<p>SAN FRANCISCO--Intel hauled out its first\r\n<a href="http://www.cnet.com/android-atlas/">Android</a>\r\n<a href="http://reviews.cnet.com/tablets/">tablet</a>\r\n running on "Medfield," an upcoming Atom chip for smartphones and \r\ntablets, while two executives also chatted with CNET about their \r\nrelationship with Google, all at Intel''s developer conference today. </p>\r\n<p>The Medfield Atom chip is one of Intel''s most power-efficient chip \r\ndesigns--a strict requirement for tablets and smartphones. It contains a\r\n single processing core--as opposed to more power-hungry dual-core Atom \r\nchips used in Netbooks--and will be available in devices in the first \r\nhalf of 2012. </p>\r\n<p>The tablet that Intel showed today (see photo below) is a so-called \r\nreference design that the company will supply to tablet makers that \r\nwould use it as a template for their own product. </p>\r\n<p>Importantly, Intel-based tablets and smartphones will be targeted at \r\nGoogle''s Android software, not Intel''s internal MeeGo operating system. \r\nThe latter has been relegated to automotive and industrial applications \r\nmostly and is no longer seen as a promising operating system for \r\nconsumer devices. To drive this point home, Intel reaffirmed its \r\nrelationship with Google today. </p>\r\n<p>CNET sat down briefly with two Intel phone executives to talk about \r\nthe relationship. The reaffirmation of the relationship is about \r\n"optimizing Intel for the Android platform for phone and for tablets," \r\nsaid Mike Bell, co-general manager of the phone division. "So, as a \r\n[device maker] you''ll be able to go out and build a device with the full\r\n blessing and backing of Intel and Google," he said. </p>\r\n<p>Intel has done an about-face of sorts. Its phone efforts had focused \r\nheavily on Nokia until that company made a dramatic switch to \r\nMicrosoft''s Windows phone platform. "We were very focused on Nokia. Mike\r\n and I took over in April and got the company very focused on the \r\nAndroid ecosystem," said Dave Whalen, the other co-manager of the phone \r\ndivision. </p><div><br />Read more: <a href="http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr">http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr</a><br /></div>  ', 'c142759dc89ae8e20abc642e1dd0e99c.jpg', 1, '2011-09-14', '2012-05-22 16:26:31'),
(5, 'en', 1, 'Windows 8 debuts at Microsoft Build (live blog)  Read more: http://news.cnet.com/8301-10805_3-20105152-75/windows-8-debuts-at-microsoft-build-live-blog/#ixzz1Xw61Mgip', '<p>A new analyst report making the rounds this morning asserts that \r\nApple''s putting the finishing touches on iOS 5, and plans to send it to \r\nits device assemblers as soon as next week. </p>\r\n<p>Analyst Ming-Chi Kuo of Concord Securities told <a href="http://www.appleinsider.com/articles/11/09/12/apple_to_release_ios_5_gm_to_assemblers_during_week_of_sept_23.html">AppleInsider</a> and <a href="http://www.macrumors.com/2011/09/12/apple-sending-ios-5-to-iphone-assemblers-at-end-of-september-no-sign-of-redesigned-iphone-5/">MacRumors</a>\r\n today that Apple should be delivering the golden master version of iOS 5\r\n between September 23 and 30. That software will then be imaged onto new\r\n devices that ship out to stores.\r\n</p>\r\n<p>The timing is of special note given expectations of a new\r\n<a href="http://www.cnet.com/apple-iphone.html">iPhone </a>and\r\n<a href="http://www.cnet.com/ipod/">iPod Touch</a> \r\nin the coming weeks. Kuo suggests it will take 10 to 12 days for \r\nshipping of new iPhones and iPod Touch units with the upgraded software,\r\n placing a higher possibility that those units won''t be available until \r\nthe second week of October. </p>\r\n<p>Apple released the latest beta version of its iOS 5 system software \r\nto developers at the tail end of August, the seventh iteration since \r\ntaking the wraps off the software at its Worldwide Developers Conference\r\n in June. So far, Apple has gone through a lengthier test process than \r\nusual, releasing a new beta of the software every few weeks ahead of the\r\n golden master, which represents the version the public gets: </p><div><br />Read more: <a href="http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q">http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q</a><br /></div>    ', '9bfe8a178df245ee90a2b5d62bfe682b.jpg', 1, '2011-09-14', '0000-00-00 00:00:00'),
(6, 'en', 1, 'Google Street View''s naked lady', '<p>It is well accepted that, if there were commercial gain involved, \r\nGoogle might not be averse to peering inside the most intimate parts of \r\nyour life.</p>\r\n<p>However, sometimes the company manages to cast its gaze without even realizing just how close to you it is.</p>\r\n<p>I am sure some will be grateful to <a href="http://www.thesmokinggun.com/buster/google/google-street-view-naked-woman-094672">the always generous Smoking Gun</a>\r\n for leading them (in a SFW way) to a street in Miami, where a woman is \r\nstanding outside her front door naked. (The story of these interesting \r\npixels was originally broken by the <a href="http://randompixels.blogspot.com/2011/09/stay-classy-miami.html">Random Pixels blog</a>) </p>\r\n<p>Oh, of course it''s on Google Street View. Where else would you find truly unguarded moments, like <a href="http://news.cnet.com/8301-17852_3-20013500-71.html">a 10-year-old playing dead</a> or, indeed, <a href="http://news.cnet.com/8301-17852_3-20023487-71.html">a naked man in an open car trunk</a>?</p><p>In the Miami case, it appears the lady may have spotted Google''s \r\nmarauding recording vehicle, for in a subsequent shot on the site she \r\nattempts to cover up.</p>\r\n<p>The nude pose was still up in all its glory last night. However, this\r\n morning it''s blurred. What remains is merely a shot of her house and \r\nthe blurry image of a naked ghost.</p>\r\n<p>There will be those who will wonder what the naked lady might have \r\nbeen doing outside her house in a clothing-optional state. The obvious \r\nanswer would be that Miami is very hot. In this case, the naked lady \r\nappeared to be washing. Though this might have merely been a scene from \r\nyet another M. Night Shyamalan movie.</p>\r\n<p>Still, one can only wonder what other gems might still exist on a \r\nservice that, with its real-time captures of a microcosm of the world, \r\ntells us how people really spend their days. </p>  ', '22285438321c76a76dc925206f5dd5bf.png', 1, '2011-09-14', '0000-00-00 00:00:00'),
(8, 'ru', 1, '1', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:14'),
(9, 'ru', 36, '2', '', NULL, 0, '0000-00-00', '2012-05-22 16:19:25'),
(10, 'ru', 1, '3', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:15'),
(11, 'ru', 1, '4', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:19'),
(12, 'ru', 36, '5', '', NULL, 0, '0000-00-00', '2012-05-22 16:19:27'),
(13, 'ru', 1, '6', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:20'),
(14, 'ru', 1, '7', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:20'),
(15, 'ru', NULL, '8', '', NULL, 0, '0000-00-00', '2012-05-22 16:26:37'),
(16, 'ru', 1, '1', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:36'),
(17, 'ru', 36, '2', '', NULL, 0, '0000-00-00', '2012-05-22 16:19:29'),
(18, 'ru', 1, '3', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:37'),
(19, 'ru', 1, '4', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:37'),
(20, 'ru', 36, '5', '', NULL, 0, '0000-00-00', '2012-05-22 16:19:33'),
(23, 'ru', 1, '6', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:38'),
(24, 'ru', NULL, '7', '', NULL, 0, '0000-00-00', '2012-05-22 16:26:34'),
(25, 'ru', 1, '8', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:39');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'Автор',
  `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
  `text` text NOT NULL COMMENT 'Текст',
  `status` enum('published','draft','unpublished') NOT NULL DEFAULT 'draft' COMMENT 'Статус',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_language_fk` (`language`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=259 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `language`, `title`, `url`, `text`, `status`, `date_create`, `order`) VALUES
(35, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'draft', '2012-05-20 14:34:34', NULL),
(239, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(240, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(241, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(242, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(243, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(244, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(245, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:25', NULL),
(246, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(247, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(248, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(249, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(250, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(251, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL);
INSERT INTO `pages` (`id`, `user_id`, `language`, `title`, `url`, `text`, `status`, `date_create`, `order`) VALUES
(252, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(253, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(254, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(255, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(256, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(257, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL),
(258, 36, 'ru', 'Map of life — каталог информации о биологических видах на Земле', '', '<img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" /><br /><br />В интернете появилась бета-версия сервиса <a href="http://www.mappinglife.org/">Map of Life</a>,\r\n который может оказаться полезным для учёных, занимающихся \r\nбиологическими и экологическими исследованиями, и просто всем \r\nлюбопытствующим. Создатели сервиса — учёные Йелльского университета \r\nсовместно с NASA — позиционируют Map of Life как «биологическую \r\nВикипедию», однако отмечают, что информация на сайте будет пополняться \r\nтолько из академических источников и после многократной проверки. На \r\nданный момент Map of life содержит информацию о приблизительно 25 000 \r\nвидах флоры и фауны со всего мира (включая и Восточную Европу), однако \r\nкаталог будет пополняться как минимум до того момента, как число \r\nподробно описанных видов достигнет двух миллионов — над этим процессом \r\nсейчас работают студенты биологического факультета Йелльского \r\nуниверситета.<br />\r\n{{cut}}<br />\r\nПоиск на Map of Life осуществляется либо по названию биологического вида\r\n (пока только на английском, однако картография сервиса русский язык \r\nподдерживает), либо просто кликая мышкой на определенном месте карты, \r\nвыбирая радиус поиска и вид животных или растений, который требуется \r\nнайти в данной области.<br />\r\n<a></a><br />\r\nПроект Map of life полностью открытый и его техническая составляющая \r\nтакже не скрывается. Клиентское приложение выполнено при HTML5 и \r\nJavaScript, за серверную обработку отвечает Google App Engine, в \r\nкачестве картографического движка базы данных используется <a href="http://cartodb.com">CartoDB</a>.<br />\r\n<br />\r\nВ качестве популяризации сервиса его создатели обещают создание \r\nмобильных клиентов — причём не только под Android и iOS, а и под Windows\r\n Phone, WebOS, Bada, Boot to Geko и Tizen.<br />\r\n<br />\r\nAPI сервиса будет доступно для разработчиков к концу этого года.  <br /><br /><img src="/upload/pages/36/7feeea212d3658552dbc790d091c2d39.jpg" />', 'published', '2012-05-20 19:31:26', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pages_sections`
--

DROP TABLE IF EXISTS `pages_sections`;
CREATE TABLE IF NOT EXISTS `pages_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `order` int(11) NOT NULL COMMENT 'Порядок',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `pages_sections`
--

INSERT INTO `pages_sections` (`id`, `parent_id`, `name`, `order`, `date_create`) VALUES
(4, NULL, 'Раздел1', 0, '2012-05-22 19:31:24'),
(5, NULL, 'Раздел2', 0, '2012-05-22 19:32:12'),
(6, NULL, 'Раздел3', 0, '2012-05-22 19:32:20'),
(7, 4, 'Подраздел 1-1', 0, '2012-05-22 19:34:56'),
(8, 4, 'Подраздел 1-2', 0, '2012-05-22 19:35:02'),
(9, 5, 'Подраздел 2-1', 0, '2012-05-22 19:35:10'),
(10, 5, 'Подраздел 2-2', 0, '2012-05-22 19:35:13');

-- --------------------------------------------------------

--
-- Структура таблицы `pages_sections_rels`
--

DROP TABLE IF EXISTS `pages_sections_rels`;
CREATE TABLE IF NOT EXISTS `pages_sections_rels` (
  `id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `section_id` int(11) unsigned NOT NULL,
  KEY `page_id` (`page_id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages_sections_rels`
--

INSERT INTO `pages_sections_rels` (`id`, `page_id`, `section_id`) VALUES
(0, 35, 4),
(0, 35, 5),
(0, 35, 6),
(0, 35, 7),
(0, 35, 8),
(0, 35, 9),
(0, 35, 10),
(0, 239, 4),
(0, 239, 5),
(0, 239, 6),
(0, 239, 7),
(0, 239, 8),
(0, 239, 9),
(0, 239, 10),
(0, 240, 4),
(0, 240, 5),
(0, 240, 6),
(0, 240, 7),
(0, 240, 8),
(0, 240, 9),
(0, 240, 10),
(0, 241, 4),
(0, 241, 5),
(0, 241, 6),
(0, 241, 7),
(0, 241, 8),
(0, 241, 9),
(0, 241, 10),
(0, 242, 4),
(0, 242, 5),
(0, 242, 6),
(0, 242, 7),
(0, 242, 8),
(0, 242, 9),
(0, 242, 10),
(0, 243, 4),
(0, 243, 5),
(0, 243, 6),
(0, 243, 7),
(0, 243, 8),
(0, 243, 9),
(0, 243, 10),
(0, 244, 4),
(0, 244, 5),
(0, 244, 6),
(0, 244, 7),
(0, 244, 8),
(0, 244, 9),
(0, 244, 10),
(0, 245, 4),
(0, 245, 5),
(0, 245, 6),
(0, 245, 7),
(0, 245, 8),
(0, 245, 9),
(0, 245, 10),
(0, 246, 4),
(0, 246, 5),
(0, 246, 6),
(0, 246, 7),
(0, 246, 8),
(0, 246, 9),
(0, 246, 10),
(0, 247, 4),
(0, 247, 5),
(0, 247, 6),
(0, 247, 7),
(0, 247, 8),
(0, 247, 9),
(0, 247, 10),
(0, 248, 4),
(0, 248, 5),
(0, 248, 6),
(0, 248, 7),
(0, 248, 8),
(0, 248, 9),
(0, 248, 10),
(0, 249, 4),
(0, 249, 5),
(0, 249, 6),
(0, 249, 7),
(0, 249, 8),
(0, 249, 9),
(0, 249, 10),
(0, 250, 4),
(0, 250, 5),
(0, 250, 6),
(0, 250, 7),
(0, 250, 8),
(0, 250, 9),
(0, 250, 10),
(0, 251, 4),
(0, 251, 5),
(0, 251, 6),
(0, 251, 7),
(0, 251, 8),
(0, 251, 9),
(0, 251, 10),
(0, 252, 4),
(0, 252, 5),
(0, 252, 6),
(0, 252, 7),
(0, 252, 8),
(0, 252, 9),
(0, 252, 10),
(0, 253, 4),
(0, 253, 5),
(0, 253, 6),
(0, 253, 7),
(0, 253, 8),
(0, 253, 9),
(0, 253, 10),
(0, 254, 4),
(0, 254, 5),
(0, 254, 6),
(0, 254, 7),
(0, 254, 8),
(0, 254, 9),
(0, 254, 10),
(0, 255, 4),
(0, 255, 5),
(0, 255, 6),
(0, 255, 7),
(0, 255, 8),
(0, 255, 9),
(0, 255, 10),
(0, 256, 4),
(0, 256, 5),
(0, 256, 6),
(0, 256, 7),
(0, 256, 8),
(0, 256, 9),
(0, 256, 10),
(0, 257, 4),
(0, 257, 5),
(0, 257, 6),
(0, 257, 7),
(0, 257, 8),
(0, 257, 9),
(0, 257, 10),
(0, 258, 4),
(0, 258, 5),
(0, 258, 6),
(0, 258, 7),
(0, 258, 8),
(0, 258, 9),
(0, 258, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `params`
--

DROP TABLE IF EXISTS `params`;
CREATE TABLE IF NOT EXISTS `params` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(50) NOT NULL COMMENT 'Модуль',
  `code` varchar(50) NOT NULL COMMENT 'Код',
  `name` varchar(100) NOT NULL COMMENT 'Заголовок',
  `value` text NOT NULL COMMENT 'Значение',
  `element` enum('text','textarea','editor','checkbox','file','select') NOT NULL COMMENT 'Элемент',
  `options` text COMMENT 'Список значений',
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`code`),
  UNIQUE KEY `title` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `params`
--

INSERT INTO `params` (`id`, `module_id`, `code`, `name`, `value`, `element`, `options`) VALUES
(9, 'users', 'registration_done_message', 'Сообщение о завершении регистрации', '<p>Вы успешно зарегистрированы в системе, на ваш Email отправлено письмо с инструкциями завершения регистрации.</p>', 'editor', NULL),
(10, 'users', 'activate_request_done_message', 'Сообщение после повторного запроса активации аккаунта', 'Мы выслали на ваш Email письмо, в котором нужно будет пройти по ссылке для активации аккаунта!', 'textarea', NULL),
(16, 'mailer', 'reply_email', 'Адрес для ответа', 'artem-moscow@yandex.ru', 'text', NULL),
(19, 'mailer', 'from_name', 'Имя от кого', 'YOO CMF сайт', 'text', NULL),
(20, 'mailer', 'host', 'Хост', 'smtp.interaxions.ru', 'text', NULL),
(21, 'mailer', 'port', 'Порт', '25', 'text', NULL),
(22, 'mailer', 'login', 'Логин', 'royal.canin@interaxions.ru', 'text', NULL),
(23, 'mailer', 'password', 'Пароль', '02mar11', 'text', NULL),
(24, 'mailer', 'from_email', 'От кого(Email)', 'test@ya.ru', 'text', NULL),
(25, 'main', 'SITE_ENABLED', 'Сайт доступен', '1', 'checkbox', NULL),
(28, 'main', 'project_name', 'Название проекта', 'YOO CMF', 'text', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `plugins`
--

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE IF NOT EXISTS `plugins` (
  `plugin_id` int(11) NOT NULL AUTO_INCREMENT,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `class` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `load_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `raiting` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `icq` int(11) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `blog_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `about` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `raiting`, `company`, `gender`, `birthday`, `icq`, `skype`, `blog_id`, `name`, `family`, `phone`, `site`, `about`) VALUES
(12, 12, NULL, '2', 1, '2011-07-30', NULL, 'двыо', NULL, 'Alexey', 'Sharov', '', '', ''),
(53, 53, NULL, '', 1, '0000-00-00', NULL, '', NULL, 'ir  Имя', 'ir Фамилия', '', '', ''),
(55, 56, NULL, '', 1, '0000-00-00', NULL, '', NULL, 'admin', 'admin', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `profiles_fields`
--

DROP TABLE IF EXISTS `profiles_fields`;
CREATE TABLE IF NOT EXISTS `profiles_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `required` tinyint(2) NOT NULL,
  `position` tinyint(5) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `varname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `field_type` varchar(255) DEFAULT NULL,
  `field_size` tinyint(5) DEFAULT NULL,
  `field_size_min` tinyint(5) DEFAULT NULL,
  `error_message` varchar(255) DEFAULT NULL,
  `default` varchar(255) DEFAULT NULL,
  `widget` varchar(255) DEFAULT NULL,
  `widgetparams` text,
  `range` text,
  `other_validator` varchar(255) DEFAULT NULL,
  `match` varchar(255) DEFAULT NULL,
  `hidden_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `profiles_fields`
--

INSERT INTO `profiles_fields` (`id`, `required`, `position`, `visible`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `error_message`, `default`, `widget`, `widgetparams`, `range`, `other_validator`, `match`, `hidden_value`) VALUES
(1, 0, 0, 1, 'company', 'Компания', NULL, 100, 0, 'company_error', '', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 1, 1, 'gender', 'Пол', NULL, 1, 0, 'gender_error', '0', NULL, NULL, '1==мужской;0==женский', NULL, NULL, NULL),
(3, 0, 2, 1, 'birthday', 'День рождения', 'DATE', NULL, NULL, 'birthday_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, 3, 1, 'icq', 'icq', NULL, 50, NULL, 'icq_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 0, 4, 1, 'skype', 'skype', NULL, 50, NULL, 'skype_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 5, 1, 'name', 'Имя', NULL, 50, NULL, 'name_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 6, 1, 'family', 'Фамилия', NULL, 50, NULL, 'family_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 0, 7, 1, 'phone', 'Телефон', NULL, 50, NULL, 'phone_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 0, 8, 1, 'site', 'Сайт', NULL, 50, NULL, 'site_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 0, 9, 1, 'about', 'О себе', 'TEXT', NULL, NULL, 'about_error', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT 'Название',
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `quiz`
--

INSERT INTO `quiz` (`id`, `name`, `date_create`) VALUES
(2, 'PHP Zend Certification', '2012-06-25 14:50:15');

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_answers`
--

DROP TABLE IF EXISTS `quiz_answers`;
CREATE TABLE IF NOT EXISTS `quiz_answers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) unsigned NOT NULL COMMENT 'Вопрос',
  `text` tinytext NOT NULL COMMENT 'Текст ответа',
  `is_right` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Верный',
  `is_free` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Свободный ответ',
  `points` tinyint(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Кол-во баллов',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4243 ;

--
-- Дамп данных таблицы `quiz_answers`
--

INSERT INTO `quiz_answers` (`id`, `question_id`, `text`, `is_right`, `is_free`, `points`) VALUES
(3358, 623, 'Dynamic, PHP, Database, HTML', 0, 0, 1),
(3359, 623, 'Embedded, Zend, HTML, XML', 0, 0, 1),
(3360, 623, 'Perl-based, PHP, Web, Static', 0, 0, 1),
(3361, 623, 'Embedded, Zend, Docbook, MySQL', 0, 0, 1),
(3362, 623, 'Zend-based, PHP, Image, HTML', 0, 0, 1),
(3363, 624, '&lt;% %&gt;', 0, 0, 1),
(3364, 624, '&lt;? ?&gt;', 0, 0, 1),
(3365, 624, '&lt;?= ?&gt;', 0, 0, 1),
(3366, 624, '&lt;! !&gt;', 0, 0, 1),
(3367, 624, '&lt;?php ?&gt;', 0, 0, 1),
(3368, 625, '$_10', 0, 0, 1),
(3369, 625, '${"MyVar"}', 0, 0, 1),
(3370, 625, '&amp;$something', 0, 0, 1),
(3371, 625, '$10_somethings', 0, 0, 1),
(3372, 625, '$aVaR', 0, 0, 1),
(3373, 626, 'The value is: Dog', 0, 0, 1),
(3374, 626, 'The value is: Cat', 0, 0, 1),
(3375, 626, 'The value is: Human', 0, 0, 1),
(3376, 626, 'The value is: 10', 0, 0, 1),
(3377, 626, 'Dog', 0, 0, 1),
(3378, 627, 'print() can be used as part of an expression, while echo() can’t', 0, 0, 1),
(3379, 627, 'echo() can be used as part of an expression, while print() can’t', 0, 0, 1),
(3380, 627, 'echo() can be used in the CLI version of PHP, while print() can’t', 0, 0, 1),
(3381, 627, 'print() can be used in the CLI version of PHP, while echo() can’t', 0, 0, 1),
(3382, 627, 'There’s no difference: both functions print out some text!', 0, 0, 1),
(3383, 628, '128', 0, 0, 1),
(3384, 628, '42', 0, 0, 1),
(3385, 628, '242.0', 0, 0, 1),
(3386, 628, '256', 0, 0, 1),
(3387, 628, '342', 0, 0, 1),
(3388, 629, 'False, True, False', 0, 0, 1),
(3389, 629, 'True, True, False', 0, 0, 1),
(3390, 629, 'False, True, True', 0, 0, 1),
(3391, 629, 'False, False, True', 0, 0, 1),
(3392, 629, 'True, True, True', 0, 0, 1),
(3393, 630, 'A string of 50 random characters', 0, 0, 1),
(3394, 630, 'A string of 49 copies of the same character, because the random number generator has not been initialized', 0, 0, 1),
(3395, 630, 'A string of 49 random characters', 0, 0, 1),
(3396, 630, 'Nothing, because $array is not an array', 0, 0, 1),
(3397, 630, 'A string of 49 ‘G’ characters', 0, 0, 1),
(3398, 631, 'A switch statement without a default case', 0, 0, 1),
(3399, 631, 'A recursive function call', 0, 0, 1),
(3400, 631, 'A while statement', 0, 0, 1),
(3401, 631, 'It is the only representation of this logic', 0, 0, 1),
(3402, 631, 'A switch statement using a default case', 0, 0, 1),
(3403, 632, 'Using a for loop', 0, 0, 1),
(3404, 632, 'Using a foreach loop', 0, 0, 1),
(3405, 632, 'Using a while loop', 0, 0, 1),
(3406, 632, 'Using a do…while loop', 0, 0, 1),
(3407, 632, 'There is no way to accomplish this goal', 0, 0, 1),
(3408, 633, 'foreach($result as $key =&gt; $val)', 0, 0, 1),
(3409, 633, 'while($idx *= 2)', 0, 0, 1),
(3410, 633, 'for($idx = 1; $idx &lt; STOP_AT; $idx *= 2)', 0, 0, 1),
(3411, 633, 'for($idx *= 2; STOP_AT &gt;= $idx; $idx = 0)', 0, 0, 1),
(3412, 633, 'while($idx &lt; STOP_AT) do $idx *= 2', 0, 0, 1),
(3413, 634, 'function is_leap($year = 2000)', 0, 0, 1),
(3414, 634, 'is_leap($year default 2000)', 0, 0, 1),
(3415, 634, 'function is_leap($year default 2000)', 0, 0, 1),
(3416, 634, 'function is_leap($year)', 0, 0, 1),
(3417, 634, 'function is_leap(2000 = $year)', 0, 0, 1),
(3418, 635, '25', 0, 0, 1),
(3419, 635, '-5', 0, 0, 1),
(3420, 635, '10', 0, 0, 1),
(3421, 635, '5', 0, 0, 1),
(3422, 635, '0', 0, 0, 1),
(3423, 636, 'Group A: 4,3,0,4,9,9 Group B: 7,8', 0, 0, 1),
(3424, 636, 'Group A: 1,3,0,4,9,9 Group B: 7,6', 0, 0, 1),
(3425, 636, 'Group A: 1,3,2,3,0,4 Group B: 5,8', 0, 0, 1),
(3426, 636, 'Group A: 0,4,9,9,9,9 Group B: 7,8', 0, 0, 1),
(3427, 636, 'Group A: 4,3,0,4,9,9 Group B: 7,8', 0, 0, 1),
(3428, 637, 'include_once, include', 0, 0, 1),
(3429, 637, 'require, include', 0, 0, 1),
(3430, 637, 'require_once, include', 0, 0, 1),
(3431, 637, 'include, require', 0, 0, 1),
(3432, 637, 'All of the above are correct', 0, 0, 1),
(3433, 638, 'When the parameter is Boolean', 0, 0, 1),
(3434, 638, 'When the function is being declared as a member of a class', 0, 0, 1),
(3435, 638, 'When the parameter is being declared as passed by reference', 0, 0, 1),
(3436, 638, 'When the function contains only one parameter', 0, 0, 1),
(3437, 638, 'Never', 0, 0, 1),
(3438, 639, 'Ваш ответ', 0, 1, 1),
(3439, 640, 'It converts them to a common compatible data type and then compares the resulting values', 0, 0, 1),
(3440, 640, 'It returns True only if they are both of the same type and value', 0, 0, 1),
(3441, 640, 'If the two values are strings, it performs a lexical comparison', 0, 0, 1),
(3442, 640, 'It bases its comparison on the C strcmp function exclusively', 0, 0, 1),
(3443, 640, 'It converts both values to strings and compares them', 0, 0, 1),
(3444, 641, '$a *= pow (2, 2);', 0, 0, 1),
(3445, 641, '$a &gt;&gt;= 2;', 0, 0, 1),
(3446, 641, '$a &lt;&lt;= 2;', 0, 0, 1),
(3447, 641, '$a += $a + $a;', 0, 0, 1),
(3448, 641, 'None of the above', 0, 0, 1),
(3449, 642, 'When exit() is called', 0, 0, 1),
(3450, 642, 'When the execution reaches the end of the current file', 0, 0, 1),
(3451, 642, 'When PHP crashes', 0, 0, 1),
(3452, 642, 'When Apache terminates because of a system problem', 0, 0, 1),
(3453, 643, 'Ваш ответ', 0, 1, 1),
(3454, 644, 'c', 0, 0, 1),
(3455, 644, 'b', 0, 0, 1),
(3456, 644, 'a', 0, 0, 1),
(3457, 644, 'd', 0, 0, 1),
(3458, 644, 'e', 0, 0, 1),
(3459, 645, 'By declaring the class as private', 0, 0, 1),
(3460, 645, 'By declaring the methods as private', 0, 0, 1),
(3461, 645, 'It cannot be done', 0, 0, 1),
(3462, 645, 'By writing a property overloading method', 0, 0, 1),
(3463, 646, 'Model-view-controller', 0, 0, 1),
(3464, 646, 'Abstract factory', 0, 0, 1),
(3465, 646, 'Singleton', 0, 0, 1),
(3466, 646, 'Proxy', 0, 0, 1),
(3467, 646, 'State', 0, 0, 1),
(3468, 647, 'One', 0, 0, 1),
(3469, 647, 'Two', 0, 0, 1),
(3470, 647, 'Depends on system resources', 0, 0, 1),
(3471, 647, 'Three', 0, 0, 1),
(3472, 647, 'As many as needed', 0, 0, 1),
(3473, 648, 'Multiple inheritance', 0, 0, 1),
(3474, 648, 'Interfaces', 0, 0, 1),
(3475, 648, 'Abstract methods', 0, 0, 1),
(3476, 648, 'Private methods', 0, 0, 1),
(3477, 648, 'Function overloading', 0, 0, 1),
(3478, 649, '__construct', 0, 0, 1),
(3479, 649, 'initialize', 0, 0, 1),
(3480, 649, 'testclass', 0, 0, 1),
(3481, 649, '__testclass', 0, 0, 1),
(3482, 649, 'Only PHP 5 supports constructors', 0, 0, 1),
(3483, 650, 'By implementing the __shutdown and __startup methods', 0, 0, 1),
(3484, 650, 'By calling register_shutdown_function()', 0, 0, 1),
(3485, 650, 'By implementing __sleep() and __wakeup()', 0, 0, 1),
(3486, 650, 'The default serialization mechanism cannot be overridden', 0, 0, 1),
(3487, 650, 'By adding the class to the output buffering mechanism using ob_start()', 0, 0, 1),
(3488, 651, 'Abstract classes', 0, 0, 1),
(3489, 651, 'PPP methods', 0, 0, 1),
(3490, 651, 'Neither PPP methods nor interfaces', 0, 0, 1),
(3491, 651, 'None of the above are available', 0, 0, 1),
(3492, 651, 'All of the above are available', 0, 0, 1),
(3493, 652, '$self=&gt;mymethod();', 0, 0, 1),
(3494, 652, '$this-&gt;mymethod();', 0, 0, 1),
(3495, 652, '$current-&gt;mymethod();', 0, 0, 1),
(3496, 652, '$this::mymethod();', 0, 0, 1),
(3497, 652, 'None of the above are correct', 0, 0, 1),
(3498, 653, '10', 0, 0, 1),
(3499, 653, 'Null', 0, 0, 1),
(3500, 653, 'Empty', 0, 0, 1),
(3501, 653, 'Nothing', 0, 0, 1),
(3502, 653, 'An error', 0, 0, 1),
(3503, 654, '10', 0, 0, 1),
(3504, 654, '5', 0, 0, 1),
(3505, 654, '2', 0, 0, 1),
(3506, 654, 'Null', 0, 0, 1),
(3507, 654, 'Nothing', 0, 0, 1),
(3508, 655, '5', 0, 0, 1),
(3509, 655, '10', 0, 0, 1),
(3510, 655, 'Nothing', 0, 0, 1),
(3511, 655, 'The constructor will throw an error', 0, 0, 1),
(3512, 655, '510', 0, 0, 1),
(3513, 656, 'The reduce_fraction function must return a value', 0, 0, 1),
(3514, 656, 'The reduce_fraction function should accept integer values', 0, 0, 1),
(3515, 656, 'The gcd function is flawed', 0, 0, 1),
(3516, 656, 'You must pass the $eight_tenths object by-reference', 0, 0, 1),
(3517, 656, 'You cannot pass instances of objects to anything but methods', 0, 0, 1),
(3518, 657, 'Calls the mymethod method in the class statically.', 0, 0, 1),
(3519, 657, 'Creates and instance of myclass and calls the mymethod method.', 0, 0, 1),
(3520, 657, 'Generates a syntax error', 0, 0, 1),
(3521, 657, 'Defaults to the last-created instance of myclass and calls mymethod()', 0, 0, 1),
(3522, 657, 'Calls the function named myclass::mymethod()', 0, 0, 1),
(3523, 658, 'Yes', 0, 0, 1),
(3524, 658, 'No', 0, 0, 1),
(3525, 659, '1', 0, 0, 1),
(3526, 659, '2', 0, 0, 1),
(3527, 659, 'An error, because a::$myvar is not defined', 0, 0, 1),
(3528, 659, 'A warning, because a::$myvar is not defined', 0, 0, 1),
(3529, 659, 'Nothing', 0, 0, 1),
(3530, 660, 'By using the __autoload magic function', 0, 0, 1),
(3531, 660, 'By defining them as forward classes', 0, 0, 1),
(3532, 660, 'By implementing a special error handler', 0, 0, 1),
(3533, 660, 'It is not possible to load classes on demand', 0, 0, 1),
(3534, 660, 'By including them in conditional include statements', 0, 0, 1),
(3535, 661, 'Ваш ответ', 0, 1, 1),
(3536, 662, 'Parent called', 0, 0, 1),
(3537, 662, 'An error', 0, 0, 1),
(3538, 662, 'A warning', 0, 0, 1),
(3539, 662, 'Nothing', 0, 0, 1),
(3540, 663, 'Through $_GET', 0, 0, 1),
(3541, 663, 'Through $_POST', 0, 0, 1),
(3542, 663, 'Through $_REQUEST', 0, 0, 1),
(3543, 663, 'Through global variables', 0, 0, 1),
(3544, 663, 'None of the above', 0, 0, 1),
(3545, 664, 'Ваш ответ', 0, 1, 1),
(3546, 665, 'By consulting the HTTP_REMOTE_COOKIE header', 0, 0, 1),
(3547, 665, 'It cannot be done', 0, 0, 1),
(3548, 665, 'By setting a different domain when calling setcookie()', 0, 0, 1),
(3549, 665, 'By sending an additional request to the browser', 0, 0, 1),
(3550, 665, 'By using Javascript to send the cookie as part of the URL', 0, 0, 1),
(3551, 666, '$_GET[''email'']', 0, 0, 1),
(3552, 666, '$_POST[''email'']', 0, 0, 1),
(3553, 666, '$_SESSION[''text’]', 0, 0, 1),
(3554, 666, '$_REQUEST[''email'']', 0, 0, 1),
(3555, 666, '$_POST[''text'']', 0, 0, 1),
(3556, 667, 'The string will become longer because the angular brackets will be converted to their HTML meta character equivalents', 0, 0, 1),
(3557, 667, 'The string will remain unchanged', 0, 0, 1),
(3558, 667, 'If the string is printed to a browser, the angular brackets will be visible', 0, 0, 1),
(3559, 667, 'If the string is printed to a browser, the angular brackets will not be visible and it will be interpreted as HTML', 0, 0, 1),
(3560, 667, 'The string is destroyed by the call to htmlentities()', 0, 0, 1),
(3561, 668, 'It expires right away', 0, 0, 1),
(3562, 668, 'It never expires', 0, 0, 1),
(3563, 668, 'It is not set', 0, 0, 1),
(3564, 668, 'It expires at the end of the user’s browser session', 0, 0, 1),
(3565, 668, 'It expires only if the script doesn’t create a server-side session', 0, 0, 1),
(3566, 669, 'Nothing', 0, 0, 1),
(3567, 669, 'Array', 0, 0, 1),
(3568, 669, 'A notice', 0, 0, 1),
(3569, 669, 'phpgreat', 0, 0, 1),
(3570, 669, 'greatphp', 0, 0, 1),
(3571, 670, 'They are passed in clear text, and the subsequent transaction is encrypted', 0, 0, 1),
(3572, 670, 'They are encrypted', 0, 0, 1),
(3573, 670, 'The URL is left in clear text, while the query string is encrypted', 0, 0, 1),
(3574, 670, 'The URL is encrypted, while the query string is passed in clear text', 0, 0, 1),
(3575, 670, 'To ensure its encryption, the query string is converted into a header and passed along with the POST information', 0, 0, 1),
(3576, 671, 'They are combined in an array and stored in the appropriate superglobal array', 0, 0, 1),
(3577, 671, 'The value of the second element is added to the value of the first in the appropriate superglobal array', 0, 0, 1),
(3578, 671, 'The value of the second element overwrites the value of the first in the appropriate superglobal array', 0, 0, 1),
(3579, 671, 'The second element is automatically renamed', 0, 0, 1),
(3580, 671, 'PHP outputs a warning', 0, 0, 1),
(3581, 672, 'By adding two square brackets ([]) to the name of the cookie', 0, 0, 1),
(3582, 672, 'By using the implode function', 0, 0, 1),
(3583, 672, 'It is not possible to store an array in a cookie due to storage limitations', 0, 0, 1),
(3584, 672, 'By using the serialize function', 0, 0, 1),
(3585, 672, 'By adding the keyword ARRAY to the name of the cookie', 0, 0, 1),
(3586, 673, '12345678910', 0, 0, 1),
(3587, 673, '1234567890', 0, 0, 1),
(3588, 673, '123456789', 0, 0, 1),
(3589, 673, 'Nothing', 0, 0, 1),
(3590, 673, 'A notice', 0, 0, 1),
(3591, 674, 'The filesystem', 0, 0, 1),
(3592, 674, 'A database', 0, 0, 1),
(3593, 674, 'Virtual memory', 0, 0, 1),
(3594, 674, 'Shared memory', 0, 0, 1),
(3595, 674, 'None of the above', 0, 0, 1),
(3596, 675, 'The browser’s binaries are corrupt', 0, 0, 1),
(3597, 675, 'The client machine’s time zone is not set properly', 0, 0, 1),
(3598, 675, 'The user has a virus-scanning program that is blocking all secure cookies', 0, 0, 1),
(3599, 675, 'The browser is set to refuse all cookies', 0, 0, 1),
(3600, 675, 'The cookie uses characters that are discarded all data from your server', 0, 0, 1),
(3601, 676, 'After exactly 1,440 seconds', 0, 0, 1),
(3602, 676, 'After the number of seconds specified in the session.gc_maxlifetime INI setting', 0, 0, 1),
(3603, 676, 'It will never expire unless it is manually deleted', 0, 0, 1),
(3604, 676, 'It will only expire when the browser is restarted', 0, 0, 1),
(3605, 676, 'None of the above', 0, 0, 1),
(3606, 677, 'Ваш ответ', 0, 1, 1),
(3607, 678, 'Float, string', 0, 0, 1),
(3608, 678, 'Positive number, negative number', 0, 0, 1),
(3609, 678, 'Even number, string', 0, 0, 1),
(3610, 678, 'String, Boolean', 0, 0, 1),
(3611, 678, 'Integer, string', 0, 0, 1),
(3612, 679, '$multi_array[''yellow''][''apple''][0]', 0, 0, 1),
(3613, 679, '$multi_array[''blue''][0][''orange''][1]', 0, 0, 1),
(3614, 679, '$multi_array[3][3][2]', 0, 0, 1),
(3615, 679, '$multi_array[''yellow''][''orange''][''cat'']', 0, 0, 1),
(3616, 679, '$multi_array[''yellow''][''orange''][1]', 0, 0, 1),
(3617, 680, 'array (''2'', ''2'')', 0, 0, 1),
(3618, 680, 'array (''1'', ''1'')', 0, 0, 1),
(3619, 680, 'array (2, 2)', 0, 0, 1),
(3620, 680, 'array (Null, Null)', 0, 0, 1),
(3621, 680, 'array (1, 1)', 0, 0, 1),
(3622, 681, 'ksort()', 0, 0, 1),
(3623, 681, 'asort()', 0, 0, 1),
(3624, 681, 'krsort()', 0, 0, 1),
(3625, 681, 'sort()', 0, 0, 1),
(3626, 681, 'usort()', 0, 0, 1),
(3627, 682, 'Ваш ответ', 0, 1, 1),
(3628, 683, 'a1, a3, a5, a10, a20', 0, 0, 1),
(3629, 683, 'a1, a20, a3, a5, a10', 0, 0, 1),
(3630, 683, 'a10, a1, a20, a3, a5', 0, 0, 1),
(3631, 683, 'a1, a10, a5, a20, a3', 0, 0, 1),
(3632, 683, 'a1, a10, a20, a3, a5', 0, 0, 1),
(3633, 684, 'array_flip()', 0, 0, 1),
(3634, 684, 'array_reverse()', 0, 0, 1),
(3635, 684, 'sort()', 0, 0, 1),
(3636, 684, 'rsort()', 0, 0, 1),
(3637, 684, 'None of the above', 0, 0, 1),
(3638, 685, '1', 0, 0, 1),
(3639, 685, 'b', 0, 0, 1),
(3640, 685, 'c', 0, 0, 1),
(3641, 685, 'A warning.', 0, 0, 1),
(3642, 685, 'a', 0, 0, 1),
(3643, 686, 'By traversing the array with a for loop', 0, 0, 1),
(3644, 686, 'By traversing the array with a foreach loop', 0, 0, 1),
(3645, 686, 'By using the array_intersect function', 0, 0, 1),
(3646, 686, 'By using the array_sum function', 0, 0, 1),
(3647, 686, 'By using array_count_values()', 0, 0, 1),
(3648, 687, '1', 0, 0, 1),
(3649, 687, '2', 0, 0, 1),
(3650, 687, '0', 0, 0, 1),
(3651, 687, 'Nothing', 0, 0, 1),
(3652, 687, '0.3', 0, 0, 1),
(3653, 688, '1 =&gt; ''b''', 0, 0, 1),
(3654, 688, 'True =&gt; ''a'', 1 =&gt; ''b''', 0, 0, 1),
(3655, 688, '0 =&gt; ''a'', 1 =&gt; ''b''', 0, 0, 1),
(3656, 688, 'None', 0, 0, 1),
(3657, 688, 'It will output NULL', 0, 0, 1),
(3658, 689, 'Yes, because the interpreter must always create a copy of the array before passing it to the function.', 0, 0, 1),
(3659, 689, 'Yes, but only if the function modifies the contents of the array.', 0, 0, 1),
(3660, 689, 'Yes, but only if the array is large.', 0, 0, 1),
(3661, 689, 'Yes, because PHP must monitor the execution of the function to determine if changes are made to the array.', 0, 0, 1),
(3662, 689, 'No.', 0, 0, 1),
(3663, 690, 'NULL', 0, 0, 1),
(3664, 690, '0 =&gt; 1, 1 =&gt; 2, 2 =&gt; 3', 0, 0, 1),
(3665, 690, 'An invalid reference error', 0, 0, 1),
(3666, 690, '2 =&gt; 1, 1 =&gt; 2, 0 =&gt; 3', 0, 0, 1),
(3667, 690, 'bool(true)', 0, 0, 1),
(3668, 691, 'Ваш ответ', 0, 1, 1),
(3669, 692, '78', 0, 0, 1),
(3670, 692, '19', 0, 0, 1),
(3671, 692, 'NULL', 0, 0, 1),
(3672, 692, '5', 0, 0, 1),
(3673, 692, '0', 0, 0, 1),
(3674, 693, 'echo chr($val);', 0, 0, 1),
(3675, 693, 'echo asc($val);', 0, 0, 1),
(3676, 693, 'echo substr($alpha, $val, 2);', 0, 0, 1),
(3677, 693, 'echo $alpha{$val};', 0, 0, 1),
(3678, 693, 'echo $alpha{$val+1}', 0, 0, 1),
(3679, 694, '$s1 + $s2', 0, 0, 1),
(3680, 694, '"{$s1}{$s2}"', 0, 0, 1),
(3681, 694, '$s1.$s2', 0, 0, 1),
(3682, 694, 'implode('''', array($s1,$s2))', 0, 0, 1),
(3683, 694, 'All of the above combine the strings', 0, 0, 1),
(3684, 695, 'substr($email, strpos($email, "@"));', 0, 0, 1),
(3685, 695, 'strstr($email, "@");', 0, 0, 1),
(3686, 695, 'strchr($email, "@");', 0, 0, 1),
(3687, 695, 'substr($email, strpos($email, "@")+1);', 0, 0, 1),
(3688, 695, 'strrpos($email, "@");', 0, 0, 1),
(3689, 696, 'strstr()', 0, 0, 1),
(3690, 696, 'Cannot be done with a single function', 0, 0, 1),
(3691, 696, 'extract()', 0, 0, 1),
(3692, 696, 'explode()', 0, 0, 1),
(3693, 696, 'strtok()', 0, 0, 1),
(3694, 697, 'Using the strpos function', 0, 0, 1),
(3695, 697, 'Using the == operator', 0, 0, 1),
(3696, 697, 'Using strcasecmp()', 0, 0, 1),
(3697, 697, 'Using strcmp()', 0, 0, 1),
(3698, 698, '.*', 0, 0, 1),
(3699, 698, '...|.........', 0, 0, 1),
(3700, 698, '\\d{3}\\|\\d{8}', 0, 0, 1),
(3701, 698, '[az]{3}\\|[az]{9}', 0, 0, 1),
(3702, 698, '[a-z][a-z][a-z]\\|\\w{9}', 0, 0, 1),
(3703, 699, 'md5()', 0, 0, 1),
(3704, 699, 'sha1()', 0, 0, 1),
(3705, 699, 'str_rot13()', 0, 0, 1),
(3706, 699, 'crypt()', 0, 0, 1),
(3707, 699, 'crc32()', 0, 0, 1),
(3708, 700, 'fopen()', 0, 0, 1),
(3709, 700, 'fread()', 0, 0, 1),
(3710, 700, 'flock()', 0, 0, 1),
(3711, 700, 'split_string()', 0, 0, 1),
(3712, 700, 'file()', 0, 0, 1),
(3713, 701, 'preg_split()', 0, 0, 1),
(3714, 701, 'ereg()', 0, 0, 1),
(3715, 701, 'str_split()', 0, 0, 1),
(3716, 701, 'explode()', 0, 0, 1),
(3717, 701, 'chop()', 0, 0, 1),
(3718, 702, 'Testing 1245', 0, 0, 1),
(3719, 702, 'Testing 345', 0, 0, 1),
(3720, 702, 'Testing 1+245', 0, 0, 1),
(3721, 702, '245', 0, 0, 1),
(3722, 702, 'Nothing', 0, 0, 1),
(3723, 703, '12345', 0, 0, 1),
(3724, 703, '12245', 0, 0, 1),
(3725, 703, '22345', 0, 0, 1),
(3726, 703, '11345', 0, 0, 1),
(3727, 703, 'Array', 0, 0, 1),
(3728, 704, '******123', 0, 0, 1),
(3729, 704, '*****_1234', 0, 0, 1),
(3730, 704, '******1234', 0, 0, 1),
(3731, 704, '_*1234', 0, 0, 1),
(3732, 704, '_*123', 0, 0, 1),
(3733, 705, '"1top" == ''1''', 0, 0, 1),
(3734, 705, '"top" == 0', 0, 0, 1),
(3735, 705, '"top" === 0', 0, 0, 1),
(3736, 705, '"a"== a', 0, 0, 1),
(3737, 705, '123 == ''123''', 0, 0, 1),
(3738, 706, 'The interpreter outputs a type mismatch error', 0, 0, 1),
(3739, 706, 'The string is converted to a number and added to the integer', 0, 0, 1),
(3740, 706, 'The string is discarded and the integer is preserved', 0, 0, 1),
(3741, 706, 'The integer and string are concatenated together in a new string', 0, 0, 1),
(3742, 706, 'The integer is discarded and the string is preserved', 0, 0, 1),
(3743, 707, 'The length of the www.php.net homepage', 0, 0, 1),
(3744, 707, 'The length of the www.php.net homepage stripped of all its &lt;p&gt; tags', 0, 0, 1),
(3745, 707, '1', 0, 0, 1),
(3746, 707, '0', 0, 0, 1),
(3747, 707, 'The length of the www.php.net homepage stripped of all its tags except for &lt;p&gt; tags', 0, 0, 1),
(3748, 708, 'strcmp()', 0, 0, 1),
(3749, 708, 'stricmp()', 0, 0, 1),
(3750, 708, 'strcasecmp()', 0, 0, 1),
(3751, 708, 'stristr()', 0, 0, 1),
(3752, 708, 'None of the above', 0, 0, 1),
(3753, 709, 'encode_hex()', 0, 0, 1),
(3754, 709, 'pack()', 0, 0, 1),
(3755, 709, 'hex2bin()', 0, 0, 1),
(3756, 709, 'bin2hex()', 0, 0, 1),
(3757, 709, 'printf()', 0, 0, 1),
(3758, 710, 'Ваш ответ', 0, 1, 1),
(3759, 711, 'Ваш ответ', 0, 1, 1),
(3760, 712, 'x', 0, 0, 1),
(3761, 712, 'axle', 0, 0, 1),
(3762, 712, 'axxle', 0, 0, 1),
(3763, 712, 'applex', 0, 0, 1),
(3764, 712, 'xapple', 0, 0, 1),
(3765, 713, 'fgets(), fseek()', 0, 0, 1),
(3766, 713, 'fread(), fgets()', 0, 0, 1),
(3767, 713, 'fputs(), fgets()', 0, 0, 1),
(3768, 713, 'fgets(), fread()', 0, 0, 1),
(3769, 713, 'fread(), fseek()', 0, 0, 1),
(3770, 714, 'Ваш ответ', 0, 1, 1),
(3771, 715, 'file_get_contents($file)', 0, 0, 1),
(3772, 715, 'file($file)', 0, 0, 1),
(3773, 715, 'read_file($file)', 0, 0, 1),
(3774, 715, 'fgets($file)', 0, 0, 1),
(3775, 715, 'fread($file)', 0, 0, 1),
(3776, 716, 'Using flock() to lock the desired file', 0, 0, 1),
(3777, 716, 'fopen()’ing a file in the operating system’s temporary directory', 0, 0, 1),
(3778, 716, 'Creating a temporary file with tempnam()', 0, 0, 1),
(3779, 716, 'Using mkdir() to create a directory and use it as a lock reference', 0, 0, 1),
(3780, 716, 'Using tmpfile() to create a temporary file', 0, 0, 1),
(3781, 717, 'file_get_contents()', 0, 0, 1),
(3782, 717, 'fgets()', 0, 0, 1),
(3783, 717, 'fopen()', 0, 0, 1),
(3784, 717, 'file()', 0, 0, 1),
(3785, 717, 'readfile()', 0, 0, 1),
(3786, 718, 'Using file() to break it up into an array', 0, 0, 1),
(3787, 718, 'Using sscanf()', 0, 0, 1),
(3788, 718, 'Using fscanf()', 0, 0, 1),
(3789, 718, 'Using fgets()', 0, 0, 1),
(3790, 718, 'Using fnmatch()', 0, 0, 1),
(3791, 719, 'Nothing, because $array is not an actual array but a string.', 0, 0, 1),
(3792, 719, 'A random sequence of 49 characters.', 0, 0, 1),
(3793, 719, 'A random sequence of 50 characters.', 0, 0, 1),
(3794, 719, 'A random sequence of 41 characters.', 0, 0, 1),
(3795, 719, 'Nothing, or the file will not exist, and the script will output an error', 0, 0, 1),
(3796, 720, 'It deletes a file', 0, 0, 1),
(3797, 720, 'It deletes a directory', 0, 0, 1),
(3798, 720, 'It unsets a variable', 0, 0, 1),
(3799, 720, 'It removes a database row', 0, 0, 1),
(3800, 720, 'This function does not exist!', 0, 0, 1),
(3801, 721, 'file_get_contents()', 0, 0, 1),
(3802, 721, 'file_put_contents()', 0, 0, 1),
(3803, 721, 'There is no equivalent function in PHP', 0, 0, 1),
(3804, 721, 'file()', 0, 0, 1),
(3805, 721, 'fputs()', 0, 0, 1),
(3806, 722, 'Change the auto_detect_line_endings INI setting', 0, 0, 1),
(3807, 722, 'Use a regular expression to detect the last letter of a line', 0, 0, 1),
(3808, 722, 'Use fpos()', 0, 0, 1),
(3809, 722, 'Use ftok()', 0, 0, 1),
(3810, 722, 'Read the file one character at a time', 0, 0, 1),
(3811, 723, 'w', 0, 0, 1),
(3812, 723, 'r', 0, 0, 1),
(3813, 723, 'a', 0, 0, 1),
(3814, 723, '+', 0, 0, 1),
(3815, 724, 'Ваш ответ', 0, 1, 1),
(3816, 725, 'fgets()', 0, 0, 1),
(3817, 725, 'file_get_contents()', 0, 0, 1),
(3818, 725, 'fread()', 0, 0, 1),
(3819, 725, 'readfile()', 0, 0, 1),
(3820, 725, 'file()', 0, 0, 1),
(3821, 726, 'Ваш ответ', 0, 1, 1),
(3822, 727, 'clearstatcache()', 0, 0, 1),
(3823, 727, 'fflush()', 0, 0, 1),
(3824, 727, 'ob_flush()', 0, 0, 1),
(3825, 727, 'touch()', 0, 0, 1),
(3826, 727, 'None of the above', 0, 0, 1),
(3827, 728, 'Ваш ответ', 0, 1, 1),
(3828, 729, 'reset()', 0, 0, 1),
(3829, 729, 'fseek(-1)', 0, 0, 1),
(3830, 729, 'fseek(0, SEEK_END)', 0, 0, 1),
(3831, 729, 'fseek(0, SEEK_SET)', 0, 0, 1),
(3832, 729, 'fseek(0, SEEK_CUR)', 0, 0, 1),
(3833, 730, 'While  stat() works on open file pointers, fstat() works on files specified by pathname', 0, 0, 1),
(3834, 730, 'While  fstat() works on open file pointers, stat() works on files specified by pathname', 0, 0, 1),
(3835, 730, 'fstat() has nothing to do with files', 0, 0, 1),
(3836, 730, 'stat() has nothing to do with files', 0, 0, 1),
(3837, 730, 'fstat() is an alias of stat()', 0, 0, 1),
(3838, 731, 'It calculates the amount of free space on the C: hard drive of a Windows machine', 0, 0, 1),
(3839, 731, 'It prints out the percentage of free space remaining on the C: drive with a precision of two decimals', 0, 0, 1),
(3840, 731, 'It prints out the total number of bytes remaining in the C: drive', 0, 0, 1),
(3841, 731, 'It calculates the ratio between total space and free space on the C: drive', 0, 0, 1),
(3842, 731, 'None of the above', 0, 0, 1),
(3843, 732, 'As a JPEG image', 0, 0, 1),
(3844, 732, 'As a binary file for display within the browser', 0, 0, 1),
(3845, 732, 'As a binary file for download', 0, 0, 1),
(3846, 732, 'As a JPEG file for download', 0, 0, 1),
(3847, 732, 'As a broken image', 0, 0, 1),
(3848, 733, '-14462', 0, 0, 1),
(3849, 733, '14462', 0, 0, 1),
(3850, 733, '-1', 0, 0, 1),
(3851, 733, '0', 0, 0, 1),
(3852, 733, 'An error', 0, 0, 1),
(3853, 734, 'Ваш ответ', 0, 1, 1),
(3854, 735, 'It measures the amount of time that the for loop requires to execute', 0, 0, 1),
(3855, 735, 'It determines the server’s internal clock frequency', 0, 0, 1),
(3856, 735, 'It calculates the deviation between the computer’s internal hardware clock and the software clock maintained by the operating system', 0, 0, 1),
(3857, 735, 'It measures the amount of time required to execute the for loop as well as one array_sum() and one microtime() call', 0, 0, 1),
(3858, 735, 'It measures the amount of time required to execute the for loop as well as two array_sum() and two microtime() calls.', 0, 0, 1),
(3859, 736, 'date()', 0, 0, 1),
(3860, 736, 'strftime()', 0, 0, 1),
(3861, 736, 'microtime()', 0, 0, 1),
(3862, 736, 'checkdate()', 0, 0, 1),
(3863, 736, 'mktime()', 0, 0, 1),
(3864, 737, 'A warning', 0, 0, 1),
(3865, 737, 'An error', 0, 0, 1),
(3866, 737, '-1 and a warning', 0, 0, 1),
(3867, 737, '-14462', 0, 0, 1),
(3868, 737, 'A notice stating that mktime is not supported', 0, 0, 1),
(3869, 738, '-3600', 0, 0, 1),
(3870, 738, '3600', 0, 0, 1),
(3871, 738, '0', 0, 0, 1),
(3872, 738, '-1', 0, 0, 1),
(3873, 738, '1', 0, 0, 1),
(3874, 739, 'Always ensure that the date values are in the same time zone as the web server', 0, 0, 1),
(3875, 739, 'If the date needs to be manipulated and converted to a UNIX timestamp, ensure that the resulting value will not cause an overflow', 0, 0, 1),
(3876, 739, 'Use the database’s facilities for testing a date’s validity', 0, 0, 1),
(3877, 739, 'If possible, use the database’s facilities for performing calculations on date values', 0, 0, 1),
(3878, 739, 'Write your code so that dates are only manipulated in PHP', 0, 0, 1),
(3879, 740, 'It would output the number 0', 0, 0, 1),
(3880, 740, 'It would output the number -1', 0, 0, 1),
(3881, 740, 'It would output the number 1', 0, 0, 1),
(3882, 740, 'It would raise an error', 0, 0, 1),
(3883, 740, 'It would output nothing', 0, 0, 1),
(3884, 741, 'It returns the number of seconds since the UNIX epoch', 0, 0, 1),
(3885, 741, 'It returns the number of seconds since the UNIX epoch expressed according to the GMT time zone', 0, 0, 1),
(3886, 741, 'It returns the number of seconds since the UNIX epoch expressed according to the local time zone', 0, 0, 1),
(3887, 741, 'It calculates the time elapsed since the UNIX epoch and expresses it as an integer number', 0, 0, 1),
(3888, 741, 'All of the above', 0, 0, 1),
(3889, 742, '0000:SepSep:ndnd', 0, 0, 1),
(3890, 742, '1212:SepSep:ndnd', 0, 0, 1),
(3891, 742, '00:i:00', 0, 0, 1),
(3892, 742, '12:i:00', 0, 0, 1),
(3893, 742, '-1', 0, 0, 1),
(3894, 743, 'time() + 3600', 0, 0, 1),
(3895, 743, 'time(3600)', 0, 0, 1),
(3896, 743, 'gmtime() + 3600', 0, 0, 1),
(3897, 743, 'gmtime(3600)', 0, 0, 1),
(3898, 743, 'Both Answers A and C are correct', 0, 0, 1),
(3899, 744, 'An integer', 0, 0, 1),
(3900, 744, 'A floating-point number', 0, 0, 1),
(3901, 744, 'An array', 0, 0, 1),
(3902, 744, 'A string', 0, 0, 1),
(3903, 744, 'A Boolean', 0, 0, 1),
(3904, 745, '$time = implode ('' '', microtime());', 0, 0, 1),
(3905, 745, '$time = explode ('' '', microtime()); $time = $time[0] + $time[1];', 0, 0, 1),
(3906, 745, '$time = microtime() + microtime();', 0, 0, 1),
(3907, 745, '$time = array_sum (explode ('' '', microtime()));', 0, 0, 1),
(3908, 745, 'None of the above', 0, 0, 1),
(3909, 746, 'time()', 0, 0, 1),
(3910, 746, 'date()', 0, 0, 1),
(3911, 746, 'strtotime()', 0, 0, 1),
(3912, 746, 'localtime()', 0, 0, 1),
(3913, 746, 'gmmktime()', 0, 0, 1),
(3914, 747, 'It depends on the number of hours between the local time zone and GMT', 0, 0, 1),
(3915, 747, 'There is no difference', 0, 0, 1),
(3916, 747, 'The two will only match if the local time zone is GMT', 0, 0, 1),
(3917, 747, 'The two will never match', 0, 0, 1),
(3918, 747, 'None of the above', 0, 0, 1),
(3919, 748, 'john@php.net', 0, 0, 1),
(3920, 748, '"John Coggeshall" &lt;someone@internetaddress.com&gt;', 0, 0, 1),
(3921, 748, 'joe @ example.com', 0, 0, 1),
(3922, 748, 'jean-cÃ³ggeshall@php.net', 0, 0, 1),
(3923, 748, 'john', 0, 0, 1),
(3924, 749, 'Windows/Novell installations require no third party software (i.e. sendmail or equivalent) to function.', 0, 0, 1),
(3925, 749, 'A UNIX installation will rely on the sendmail_from configuration directive to determine the From: header of the e-mail', 0, 0, 1),
(3926, 749, 'You cannot send e-mail with multiple recipients on Windows/Novell installations—each e-mail must be sent separately by calling mail() multiple times.', 0, 0, 1),
(3927, 749, 'Depending on the value of sendmail_path configuration directive, they may behave identically.', 0, 0, 1),
(3928, 749, 'Unlike Windows/Novell installations, in UNIX you must properly configure the MTA host and port using the SMTP and smtp_port configuration directives.', 0, 0, 1),
(3929, 750, 'Add the necessary additional headers to the $message parameter (third parameter) of the mail function.', 0, 0, 1),
(3930, 750, 'Communicate directly with the MTA using SMTP from PHP code', 0, 0, 1),
(3931, 750, 'Append additional headers to the e-mail using the extended features of the mail function’s  $additional_headers parameter (fourth parameter) as a string with a newline \\n character at the end of each needed header', 0, 0, 1),
(3932, 750, 'Although sending e-mails to multiple recipients is allowed, PHP does not support sending of MIME e-mail.', 0, 0, 1),
(3933, 750, 'Use the $additional_headers parameter of the mail function to provide a string with a newline and line feed  \\r\\n characters at the end of each needed header.', 0, 0, 1),
(3934, 751, 'Ваш ответ', 0, 1, 1),
(3935, 752, 'Providing the content of the image file directly in-line within an HTML &lt;IMG&gt; tag in the mail that the e-mail client will  automatically render', 0, 0, 1),
(3936, 752, 'Providing a URL in the SRC attribute of the &lt;IMG&gt; tag pointing to the image on a independent server where the image is hosted', 0, 0, 1),
(3937, 752, 'Embedding the image directly in the e-mail as a separate MIME content block and referencing it within the SRC attribute of the &lt;IMG&gt; tag by its assigned Content ID', 0, 0, 1),
(3938, 752, 'Adding the images directly as file attachments and reference them within the SRC attribute of the &lt;IMG&gt; tag by filename', 0, 0, 1),
(3939, 752, 'There is only one valid answer listed above', 0, 0, 1),
(3940, 753, 'Both when sending e-mail from UNIX and Windows/Novell', 0, 0, 1),
(3941, 753, 'Only when sending e-mail from Windows/Novell to provide SMTP commands to the MTA', 0, 0, 1),
(3942, 753, 'Only in conjunction with the sendmail application or a wrapper application specified by sendmail_path', 0, 0, 1),
(3943, 753, 'This parameter is deprecated and is no longer used in PHP', 0, 0, 1),
(3944, 754, 'Only when sending non-plaintext (ASCII) data to specify the encoding of the MIME segment', 0, 0, 1),
(3945, 754, 'To indicate special formatting of the e-mail, such as if it is to be rendered as HTML, plain text, or rich text', 0, 0, 1),
(3946, 754, 'It can be used at any time to specify the encoding of any segment of the MIME e-mail', 0, 0, 1),
(3947, 754, 'It can only be used to specify the encoding format (such as base64) of binary segments of a MIME e-mail.', 0, 0, 1),
(3948, 754, 'None of the above', 0, 0, 1),
(3949, 755, 'Boundaries must be at least 8 characters in length', 0, 0, 1),
(3950, 755, 'Boundaries must be used to separate MIME segments by prefixing them with two hyphens (e.g.: --abcdefghi) to begin the segment and both prefixing and appending two hyphens (for example, --abcdefghi--) to end the segment', 0, 0, 1),
(3951, 755, 'Boundaries must be unique in a MIME e-mail', 0, 0, 1),
(3952, 755, 'Boundaries cannot be embedded within other boundaries', 0, 0, 1),
(3953, 755, 'The actual text used for a boundary doesn’t matter', 0, 0, 1),
(3954, 756, 'MIME-Version', 0, 0, 1),
(3955, 756, 'Content-Disposition', 0, 0, 1),
(3956, 756, 'Content-Type', 0, 0, 1),
(3957, 756, 'Content-Transfer-Encoding', 0, 0, 1),
(3958, 756, 'Content-ID', 0, 0, 1),
(3959, 757, 'multipart/mixed', 0, 0, 1),
(3960, 757, 'multipart/alternative', 0, 0, 1),
(3961, 757, 'multipart/default', 0, 0, 1),
(3962, 757, 'multipart/related', 0, 0, 1),
(3963, 757, 'Not possible using content-types', 0, 0, 1),
(3964, 758, 'Install a sendmail server', 0, 0, 1),
(3965, 758, 'Install Microsoft Exchange', 0, 0, 1),
(3966, 758, 'Install any mailserver on your computer', 0, 0, 1),
(3967, 758, 'Change your php.ini configuration', 0, 0, 1),
(3968, 758, 'Write a script that connects to a public e-mailing service', 0, 0, 1),
(3969, 759, 'Enforcing the use of GET parameters only', 0, 0, 1),
(3970, 759, 'Calling htmlentities() on the e-mail address', 0, 0, 1),
(3971, 759, 'Enforcing the use of POST parameters only', 0, 0, 1),
(3972, 759, 'Calling htmlentities() on the body of the e-mail', 0, 0, 1),
(3973, 759, 'Ensuring that the e-mail address field contains no newline characters', 0, 0, 1),
(3974, 760, 'By transforming it into a string with serialize() and then encoding it with htmlentities()', 0, 0, 1),
(3975, 760, 'By saving it to a file and then encoding it with base64_encode()', 0, 0, 1),
(3976, 760, 'By transforming it into a string with serialize()', 0, 0, 1),
(3977, 760, 'By transforming it into a string with serialize() and encoding it with base64_encode()', 0, 0, 1),
(3978, 760, 'By saving it to a file and then encoding it with convert_uuencode()', 0, 0, 1),
(3979, 761, 'By hardcoding it in your script', 0, 0, 1),
(3980, 761, 'By creating a manual list of MIME types and selecting from it based on the file’s extension', 0, 0, 1),
(3981, 761, 'By writing a stochastic function capable of determining the file’s data type based on its contents', 0, 0, 1),
(3982, 761, 'By using the mime_content_type function', 0, 0, 1),
(3983, 761, 'By uploading the file to an external web service.', 0, 0, 1),
(3984, 762, 'By adding a From header to the message', 0, 0, 1),
(3985, 762, 'By passing -f as one of the extra parameters', 0, 0, 1),
(3986, 762, 'By adding a Reply-to header to the message', 0, 0, 1),
(3987, 762, 'By ensuring that the user under which Apache runs is marked as privileged in the sendmail configuration', 0, 0, 1),
(3988, 762, 'By ensuring the Apache process runs as root', 0, 0, 1),
(3989, 763, 'If possible, convert the query to a stored procedure', 0, 0, 1),
(3990, 763, 'If possible within your application, reduce the number of fields retrieved by the query by specifying each field individually as part of the query', 0, 0, 1),
(3991, 763, 'If possible, add a WHERE clause', 0, 0, 1),
(3992, 763, 'If supported by the DBMS, convert the query to a view', 0, 0, 1),
(3993, 763, 'If the DBMS allows it, use prepared statements', 0, 0, 1),
(3994, 764, 'Ваш ответ', 0, 1, 1),
(3995, 765, 'It joins two tables together into a third permanent table based on a common column', 0, 0, 1),
(3996, 765, 'It creates a result set based on the rows in common between two tables', 0, 0, 1),
(3997, 765, 'It creates a result set based on the rows based on one table', 0, 0, 1),
(3998, 765, 'It creates a result set by joining two tables together and taking all the rows in common plus the rows belonging to one of the tables', 0, 0, 1),
(3999, 765, 'None of the above', 0, 0, 1),
(4000, 766, 'MySQL', 0, 0, 1),
(4001, 766, 'IBM DB/2', 0, 0, 1),
(4002, 766, 'PostgreSQL', 0, 0, 1),
(4003, 766, 'Microsoft SQL Server', 0, 0, 1),
(4004, 766, 'None of the above', 0, 0, 1),
(4005, 767, 'The MYTABLE table contains more than one row', 0, 0, 1),
(4006, 767, 'This script should be modified so that user-provided data is properly escaped', 0, 0, 1),
(4007, 767, 'Calling this function will result in a row set containing the number of rows left in MYTABLE', 0, 0, 1),
(4008, 767, 'Passing the URL parameter ID=0+OR+1 will cause all the rows in MYTABLE to be deleted', 0, 0, 1),
(4009, 767, 'This query should include the database name pre-pended to the table name', 0, 0, 1),
(4010, 768, 'Ваш ответ', 0, 1, 1),
(4011, 769, 'Indexing can speed up the insertion of new rows in a table', 0, 0, 1),
(4012, 769, 'A good indexing strategy helps prevent cross-site scripting attacks', 0, 0, 1),
(4013, 769, 'Indexes should be designed based on the database’s actual usage', 0, 0, 1),
(4014, 769, 'Deleting a row from a table causes its indexes to be dropped', 0, 0, 1),
(4015, 769, 'Indexes are necessary on numeric rows only', 0, 0, 1),
(4016, 770, 'Yes', 0, 0, 1),
(4017, 770, 'No', 0, 0, 1),
(4018, 771, 'Indexing the ID column', 0, 0, 1),
(4019, 771, 'Indexing the NAME and ADDRESS1 columns', 0, 0, 1),
(4020, 771, 'Indexing the ID column, and then the NAME and ZIPCODE columns separately', 0, 0, 1),
(4021, 771, 'Indexing the ZIPCODE and NAME columns', 0, 0, 1),
(4022, 771, 'Indexing the ZIPCODE column with a full-text index', 0, 0, 1),
(4023, 772, 'The contents of OTHERTABLE will be deleted', 0, 0, 1),
(4024, 772, 'The contents of both OTHERTABLE and MYTABLE will be deleted', 0, 0, 1),
(4025, 772, 'The contents of OTHERTABLE will be deleted, as will be all the contents of MYTABLE whose ID is 1', 0, 0, 1),
(4026, 772, 'The database will remain unchanged to all users except the one that executes these queries', 0, 0, 1),
(4027, 772, 'The database will remain unchanged', 0, 0, 1),
(4028, 773, 'It causes the dataset returned by the query to be sorted in descending order', 0, 0, 1),
(4029, 773, 'It causes rows with the same ID to be sorted by NAME in ascending order', 0, 0, 1),
(4030, 773, 'It causes rows with the same ID to be sorted by NAME in descending order', 0, 0, 1),
(4031, 773, 'It causes rows to be sorted by NAME first and then by ID', 0, 0, 1),
(4032, 773, 'It causes the result set to include a description of the NAME field', 0, 0, 1),
(4033, 774, 'AVG', 0, 0, 1),
(4034, 774, 'SUM', 0, 0, 1),
(4035, 774, 'MIN', 0, 0, 1),
(4036, 774, 'MAX', 0, 0, 1),
(4037, 774, 'CURRENT_DATE()', 0, 0, 1),
(4038, 775, 'The column must be indexed', 0, 0, 1),
(4039, 775, 'The column must be included in the GROUP BY clause', 0, 0, 1),
(4040, 775, 'The column must contain an aggregate value', 0, 0, 1),
(4041, 775, 'The column must be a primary key', 0, 0, 1),
(4042, 775, 'The column must not contain NULL values', 0, 0, 1),
(4043, 776, 'The number of rows that TABLE1 and TABLE2 do not have in common', 0, 0, 1),
(4044, 776, 'A list of the rows in common between the two tables', 0, 0, 1),
(4045, 776, 'The number of rows in TABLE1 times the number of rows in TABLE2 minus the number of rows that the two tables have in common', 0, 0, 1),
(4046, 776, 'A list of the rows that the two tables do not have in common', 0, 0, 1),
(4047, 776, 'The number 2', 0, 0, 1),
(4048, 777, 'Ваш ответ', 0, 1, 1),
(4049, 778, '\\\\server\\path\\filename', 0, 0, 1),
(4050, 778, 'http://www.example.com/index.php', 0, 0, 1),
(4051, 778, 'myfile.txt', 0, 0, 1),
(4052, 778, 'compress.zlib://myfile.txt', 0, 0, 1),
(4053, 778, 'They all are valid', 0, 0, 1),
(4054, 779, 'Ваш ответ', 0, 1, 1),
(4055, 780, 'Whether there is more data to be read', 0, 0, 1),
(4056, 780, 'Whether the stream has timed out or not', 0, 0, 1),
(4057, 780, 'Whether the stream is blocking', 0, 0, 1),
(4058, 780, 'How much data has passed through the stream', 0, 0, 1),
(4059, 780, 'The component parts the stream consists of', 0, 0, 1),
(4060, 781, 'http', 0, 0, 1),
(4061, 781, 'STDIO', 0, 0, 1),
(4062, 781, 'ftp', 0, 0, 1),
(4063, 781, 'STDOUT', 0, 0, 1),
(4064, 781, 'stream', 0, 0, 1),
(4065, 782, 'Stream Filters', 0, 0, 1),
(4066, 782, 'Stream Transports', 0, 0, 1),
(4067, 782, 'File Wrappers', 0, 0, 1),
(4068, 782, 'The individual read / write streams', 0, 0, 1),
(4069, 782, 'All of the above', 0, 0, 1),
(4070, 783, 'Ваш ответ', 0, 1, 1),
(4071, 784, 'tcp', 0, 0, 1),
(4072, 784, 'udp', 0, 0, 1),
(4073, 784, 'udg', 0, 0, 1),
(4074, 784, 'pdc', 0, 0, 1),
(4075, 784, 'unix', 0, 0, 1),
(4076, 785, 'Decrease max_execution_time, thereby forcing fread() to time out faster', 0, 0, 1),
(4077, 785, 'Decrease the timeout time of the connection when calling fsockopen()', 0, 0, 1),
(4078, 785, 'Turn off blocking on the socket', 0, 0, 1),
(4079, 785, 'Turn on blocking on the socket', 0, 0, 1),
(4080, 785, 'None of the above', 0, 0, 1),
(4081, 786, 'Ваш ответ', 0, 1, 1),
(4082, 787, 'Storing the encoded data in a temporary variable and then writing that variable to the stream', 0, 0, 1),
(4083, 787, 'Using stream filters to encode the data on-the-fly', 0, 0, 1),
(4084, 787, 'Creating a lookup table for ROT13, then encoding the data character by character on the fly as you write it.', 0, 0, 1),
(4085, 787, 'There is no way to encode in ROT13 on the fly', 0, 0, 1),
(4086, 787, 'None of the above', 0, 0, 1),
(4087, 788, 'A warning', 0, 0, 1),
(4088, 788, '255.255.255.255', 0, 0, 1),
(4089, 788, '-1', 0, 0, 1),
(4090, 788, '127.0.1.0', 0, 0, 1),
(4091, 788, '127.0.256.0', 0, 0, 1),
(4092, 789, 'A list of the FTP servers on the local network', 0, 0, 1),
(4093, 789, 'The address of the FTP server called “tcp”', 0, 0, 1),
(4094, 789, 'The port associated with the TCP service called “FTP”', 0, 0, 1),
(4095, 789, 'A list of the ports associated with all services except FTP', 0, 0, 1),
(4096, 790, 'It returns the IP associated with a host name', 0, 0, 1),
(4097, 790, 'It returns a list of all the IPs associated with a host name', 0, 0, 1),
(4098, 790, 'It returns the IP associated with a host name using a long-integer representation', 0, 0, 1),
(4099, 790, 'It returns a list of all the IPs associated with a host name using a long-integer representation', 0, 0, 1),
(4100, 790, 'None of the above', 0, 0, 1),
(4101, 791, 'Reading a file', 0, 0, 1),
(4102, 791, 'Writing a file', 0, 0, 1),
(4103, 791, 'Establishing a stateful connection and changing directories interactively', 0, 0, 1),
(4104, 791, 'Creating a new directory', 0, 0, 1),
(4105, 792, 'By calling stream_wrapper_register() and defining a class to handle stream operations', 0, 0, 1),
(4106, 792, 'By registering a handler function with stream_wrapper_register()', 0, 0, 1),
(4107, 792, 'By creating a class that has the same name as the stream wrapper you want to use and then opening it with fopen()', 0, 0, 1),
(4108, 792, 'By loading the stream wrapper using stream_load()', 0, 0, 1),
(4109, 793, 'Having strong encryption algorithms', 0, 0, 1),
(4110, 793, 'Protecting database passwords', 0, 0, 1),
(4111, 793, 'Using SSL whenever possible', 0, 0, 1),
(4112, 793, 'Validating input', 0, 0, 1),
(4113, 793, 'Only using input from trusted sources', 0, 0, 1),
(4114, 794, 'Yes, it is secure. It checks for $isAdmin to be True before executing protected operations', 0, 0, 1),
(4115, 794, 'No, it is not secure because it doesn’t make sure $action is valid input', 0, 0, 1),
(4116, 794, 'No, it is not secure because $isAdmin can be hijacked by exploiting register_globals', 0, 0, 1),
(4117, 794, 'Yes, it is secure because it validates the user-data $data', 0, 0, 1),
(4118, 794, 'Both A and B', 0, 0, 1),
(4119, 795, 'Never use include or require statements that include files based on pathnames taken from user input (e.g.: include "$username/script.txt";)', 0, 0, 1),
(4120, 795, 'Disable allow_url_fopen unless it is required for the site to function', 0, 0, 1),
(4121, 795, 'Avoid using extensions like curl, which opens remote connections', 0, 0, 1),
(4122, 795, 'Use functions such as strip_tags() on input taken from one user and displayed to another', 0, 0, 1),
(4123, 795, 'All of the above', 0, 0, 1),
(4124, 796, 'Filter all data taken from untrusted sources', 0, 0, 1),
(4125, 796, 'Filter all data from foreign sources', 0, 0, 1),
(4126, 796, 'Initialize all variables prior to use', 0, 0, 1),
(4127, 796, 'Use hard-to-guess variable names to prevent malicious users from injecting data', 0, 0, 1),
(4128, 796, 'All of the above', 0, 0, 1),
(4129, 797, 'Placing a firewall between the database server and the web server', 0, 0, 1),
(4130, 797, 'Escaping user data so that it cannot be interpreted as commands by the DBMS', 0, 0, 1),
(4131, 797, 'Using stored procedures', 0, 0, 1),
(4132, 797, 'Using object-oriented programming so that each query can be defined as a separate class', 0, 0, 1),
(4133, 798, 'Always prefer the backtick operator ` to calls such as exec(), which are less secure', 0, 0, 1),
(4134, 798, 'Always use the shell_exec function when possible, as it performs security checks on commands prior to executing them', 0, 0, 1),
(4135, 798, 'Use the escapeshellcmd function to escape shell metacharacters prior to execution', 0, 0, 1),
(4136, 798, 'Enable the safe_mode configuration directive prior to executing shell commands using ini_set()', 0, 0, 1),
(4137, 798, 'Use the escapeshellarg function to escape shell command arguments prior to execution', 0, 0, 1),
(4138, 799, 'Validate the filename against what the user’s browser reported it to be before using it', 0, 0, 1),
(4139, 799, 'Use the file_exists function to make sure the file exists before trying to manipulate it', 0, 0, 1),
(4140, 799, 'Check to make sure that the file provided to your script was actually uploaded through HTTP by using the is_uploaded_file function', 0, 0, 1),
(4141, 799, 'Move the file to a secure location using move_uploaded_file()', 0, 0, 1),
(4142, 799, 'Only trust files that are stored in the directory where PHP temporarily stores uploaded files.', 0, 0, 1),
(4143, 800, 'Limit the execution of shell commands', 0, 0, 1),
(4144, 800, 'Limit access to system environment variables', 0, 0, 1),
(4145, 800, 'Limit the paths from which PHP can include files using include or require', 0, 0, 1),
(4146, 800, 'Limit the permissions of operations that can be performed against a database', 0, 0, 1),
(4147, 800, 'All of the above', 0, 0, 1),
(4148, 801, 'Enabling safe_mode', 0, 0, 1),
(4149, 801, 'Using the open_basedir directive to define the directories allowed', 0, 0, 1),
(4150, 801, 'Providing custom versions of PHP’s filesystem functions that validate the directories being accessed', 0, 0, 1),
(4151, 801, 'Setting up the permissions of your file system in such a way that PHP can only get to the directories that are allowed', 0, 0, 1),
(4152, 801, 'None of the above, PHP can’t restrict access on a per-directory basis', 0, 0, 1),
(4153, 802, 'Yes', 0, 0, 1),
(4154, 802, 'No', 0, 0, 1),
(4155, 803, 'The contents of the /etc/passwd file are displayed, thus creating a security breach', 0, 0, 1),
(4156, 803, 'The operating system will check whether the Apache user has permission to open the /etc/passwd file and act accordingly', 0, 0, 1),
(4157, 803, 'The /etc/passwd string will be available as one of the parameters to the script', 0, 0, 1),
(4158, 803, 'Nothing. PHP automatically refuses to read and interpret files passed to it as a command-line option when run in CGI mode', 0, 0, 1),
(4159, 803, 'PHP will attempt to interpret /etc/passwd as a PHP script', 0, 0, 1),
(4160, 804, 'Being aware of potential security issues as documented in the PHP manual.', 0, 0, 1),
(4161, 804, 'Logging all circumstances in which your script data validation fails', 0, 0, 1),
(4162, 804, 'Keeping up to date with the latest versions of PHP, especially those that contain security fixes', 0, 0, 1),
(4163, 804, 'When using third-party PHP packages, being aware of any security holes found in them and keeping fixes up to date', 0, 0, 1),
(4164, 804, 'All of the above', 0, 0, 1),
(4165, 805, 'An error message should be displayed to the user with technical information regarding its apparent cause, so that the web master can address it', 0, 0, 1),
(4166, 805, 'The error should be logged, and a polite message indicating a server malfunction should be presented to the user', 0, 0, 1),
(4167, 805, 'An error message with technical information regarding the error should be displayed so that the user can send it to the webmaster and the error should be logged', 0, 0, 1),
(4168, 805, 'Errors should redirect the users to the home page, as to not indicate a malfunction', 0, 0, 1),
(4169, 805, 'None of the above', 0, 0, 1),
(4170, 806, 'Always—the worst case here is that the anonymous function newfunc() will always return a number', 0, 0, 1),
(4171, 806, 'Only when register_globals is enabled', 0, 0, 1),
(4172, 806, 'Never. The anonymous function newfunc() runs the risk of allowing the user to manipulate the math performed', 0, 0, 1),
(4173, 806, 'Never. The anonymous function newfunct() runs the risk of allowing the user to execute arbitrary code on the server', 0, 0, 1),
(4174, 806, 'Only if allow_url_fopen is enabled', 0, 0, 1),
(4175, 807, 'Shared Apache module', 0, 0, 1),
(4176, 807, 'Compiled-in Apache module', 0, 0, 1),
(4177, 807, 'CGI', 0, 0, 1),
(4178, 807, 'ISAPI module under IIS', 0, 0, 1),
(4179, 808, '$x = ($a &lt; 10 || $b &gt; 11 || $c == 1 &amp;&amp; $d != $c) ? 0 : 1;', 0, 0, 1),
(4180, 808, '$x = ($a &lt; 10 || $b &gt; 11 || ($c == 1 &amp;&amp; $d != $c)) ? 0 : 1;', 0, 0, 1),
(4181, 808, '$x = (($a &lt; 10 &amp;&amp; $b &gt; 11) || ($c == 1 &amp;&amp; $d != $c)) ? 0 : 1;', 0, 0, 1),
(4182, 808, '$x = ($a &lt; 10 &amp;&amp; $b &gt; 11 &amp;&amp; $c == 1 &amp;&amp; $d != $c) ? 1 : 0;', 0, 0, 1),
(4183, 808, 'None of the above', 0, 0, 1),
(4184, 809, 'Installing an opcode cache', 0, 0, 1),
(4185, 809, 'Optimizing or upgrading your network connection', 0, 0, 1),
(4186, 809, 'Adding more hardware to your web farm', 0, 0, 1),
(4187, 809, 'Increasing the RAM available on your server', 0, 0, 1),
(4188, 809, 'Using a content cache', 0, 0, 1),
(4189, 810, 'Turning off error reporting', 0, 0, 1),
(4190, 810, 'Turning on error logging', 0, 0, 1),
(4191, 810, 'Turning off error logging', 0, 0, 1),
(4192, 810, 'Turning off the display of errors', 0, 0, 1),
(4193, 810, 'Using the @ error-suppression operator', 0, 0, 1),
(4194, 811, 'Ваш ответ', 0, 1, 1),
(4195, 812, 'It compiles scripts into binary objects to make them run faster', 0, 0, 1),
(4196, 812, 'It replaces the Zend Engine to provide a faster interpreter', 0, 0, 1),
(4197, 812, 'It caches a script’s output to improve its performance', 0, 0, 1),
(4198, 812, 'It improves performance by caching the intermediate code produced by the parser', 0, 0, 1),
(4199, 812, 'It caches a script in memory, thus eliminating the need for reloading it from disk at every iteration', 0, 0, 1),
(4200, 813, 'Using too little RAM', 0, 0, 1),
(4201, 813, 'Using a connection capable of low bandwidth only', 0, 0, 1),
(4202, 813, 'Increasing virtual memory beyond 2GB', 0, 0, 1),
(4203, 813, 'Allowing too many web server processes to run at the same time', 0, 0, 1),
(4204, 813, 'None of the above', 0, 0, 1),
(4205, 814, 'Parameter escapement', 0, 0, 1);
INSERT INTO `quiz_answers` (`id`, `question_id`, `text`, `is_right`, `is_free`, `points`) VALUES
(4206, 814, 'Output formatting', 0, 0, 1),
(4207, 814, 'Error checking', 0, 0, 1),
(4208, 814, 'A SQL query', 0, 0, 1),
(4209, 814, 'None of the above', 0, 0, 1),
(4210, 815, 'E_WARNING', 0, 0, 1),
(4211, 815, 'E_ERROR', 0, 0, 1),
(4212, 815, 'E_USER_ERROR', 0, 0, 1),
(4213, 815, 'E_PARSE', 0, 0, 1),
(4214, 815, 'E_NOTICE', 0, 0, 1),
(4215, 816, 'Cast the variable to int', 0, 0, 1),
(4216, 816, 'Use identity operators', 0, 0, 1),
(4217, 816, 'Ensure that the constant is the first operand', 0, 0, 1),
(4218, 816, 'Use ternary operators', 0, 0, 1),
(4219, 816, 'Enclose the operation in parentheses', 0, 0, 1),
(4220, 817, 'By building a custom function that connects to a remote SMTP server', 0, 0, 1),
(4221, 817, 'By using the mail function', 0, 0, 1),
(4222, 817, 'By using the error_log function', 0, 0, 1),
(4223, 817, 'By calling sendmail as an external application', 0, 0, 1),
(4224, 817, 'By using a webservice', 0, 0, 1),
(4225, 818, 'Yes', 0, 0, 1),
(4226, 818, 'No', 0, 0, 1),
(4227, 819, 'To create a profile of a script’s structure', 0, 0, 1),
(4228, 819, 'To transform a script into a UML diagram', 0, 0, 1),
(4229, 819, 'To accurately measure the times needed to execute different portions of a script', 0, 0, 1),
(4230, 819, 'To calculate the dimensions of a script output when executed through a webserver', 0, 0, 1),
(4231, 819, 'To identify potential bugs by scanning a script’s source for common mistakes', 0, 0, 1),
(4232, 820, 'Ваш ответ', 0, 1, 1),
(4233, 821, 'trigger_error() also allows a script to throw system-level errors', 0, 0, 1),
(4234, 821, 'user_error() also allows a script to throw system-level errors', 0, 0, 1),
(4235, 821, 'user_error() cannot be used in an error handler', 0, 0, 1),
(4236, 821, 'trigger_error() is only available in PHP 5', 0, 0, 1),
(4237, 821, 'There is no difference', 0, 0, 1),
(4238, 822, 'print_r', 0, 0, 1),
(4239, 822, 'var_dump', 0, 0, 1),
(4240, 822, 'stack_dump', 0, 0, 1),
(4241, 822, 'debug_backtrace', 0, 0, 1),
(4242, 822, 'None of the above', 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_choices`
--

DROP TABLE IF EXISTS `quiz_choices`;
CREATE TABLE IF NOT EXISTS `quiz_choices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `result_id` int(11) unsigned NOT NULL,
  `question_id` int(11) unsigned NOT NULL,
  `inner_choice` varchar(200) DEFAULT NULL,
  `free_choice` varchar(200) DEFAULT NULL,
  `is_right` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `result_id_question_id` (`result_id`,`question_id`),
  KEY `question` (`question_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Дамп данных таблицы `quiz_choices`
--

INSERT INTO `quiz_choices` (`id`, `result_id`, `question_id`, `inner_choice`, `free_choice`, `is_right`) VALUES
(2, 1, 678, NULL, NULL, NULL),
(3, 1, 679, NULL, NULL, NULL),
(4, 1, 680, NULL, NULL, NULL),
(5, 1, 681, NULL, NULL, NULL),
(6, 1, 682, NULL, NULL, NULL),
(7, 1, 683, NULL, NULL, NULL),
(8, 1, 684, NULL, NULL, NULL),
(9, 1, 685, NULL, NULL, NULL),
(10, 1, 686, NULL, NULL, NULL),
(11, 1, 687, NULL, NULL, NULL),
(12, 1, 688, NULL, NULL, NULL),
(13, 1, 689, NULL, NULL, NULL),
(14, 1, 690, NULL, NULL, NULL),
(15, 1, 691, NULL, NULL, NULL),
(16, 1, 692, NULL, NULL, NULL),
(17, 1, 693, NULL, NULL, NULL),
(18, 1, 694, NULL, NULL, NULL),
(19, 1, 695, NULL, NULL, NULL),
(20, 1, 696, NULL, NULL, NULL),
(21, 1, 697, NULL, NULL, NULL),
(22, 1, 698, NULL, NULL, NULL),
(23, 1, 699, NULL, NULL, NULL),
(24, 1, 700, NULL, NULL, NULL),
(25, 1, 701, NULL, NULL, NULL),
(26, 1, 702, NULL, NULL, NULL),
(27, 1, 703, NULL, NULL, NULL),
(28, 1, 704, NULL, NULL, NULL),
(29, 1, 705, NULL, NULL, NULL),
(30, 1, 706, NULL, NULL, NULL),
(31, 1, 707, NULL, NULL, NULL),
(32, 1, 708, NULL, NULL, NULL),
(33, 1, 709, NULL, NULL, NULL),
(34, 1, 710, NULL, NULL, NULL),
(35, 1, 711, NULL, NULL, NULL),
(36, 1, 712, NULL, NULL, NULL),
(37, 1, 793, NULL, NULL, NULL),
(38, 1, 794, NULL, NULL, NULL),
(39, 1, 795, NULL, NULL, NULL),
(40, 1, 796, NULL, NULL, NULL),
(41, 1, 797, NULL, NULL, NULL),
(42, 1, 798, NULL, NULL, NULL),
(43, 1, 799, NULL, NULL, NULL),
(44, 1, 800, NULL, NULL, NULL),
(45, 1, 801, NULL, NULL, NULL),
(46, 1, 802, NULL, NULL, NULL),
(47, 1, 803, NULL, NULL, NULL),
(48, 1, 804, NULL, NULL, NULL),
(49, 1, 805, NULL, NULL, NULL),
(50, 1, 806, NULL, NULL, NULL),
(51, 1, 807, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
CREATE TABLE IF NOT EXISTS `quiz_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned NOT NULL COMMENT 'Тематика',
  `text` text NOT NULL COMMENT 'Вопрос',
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`),
  KEY `topic` (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=823 ;

--
-- Дамп данных таблицы `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `topic_id`, `text`, `date_create`) VALUES
(623, 47, '1. Choose the selection that best matches the following statements:\n\nPHP is a _____ scripting language based on the ____ engine. It is primarily used to develop dynamic _____ content, although it can be used to generate ____ documents (among others) as well.', '2012-06-25 14:49:18'),
(624, 47, '2. Which of the following tags is not a valid way to begin and end a PHP code block?', '2012-06-25 14:49:18'),
(625, 47, '3. Which of the following is not valid PHP code?', '2012-06-25 14:49:18'),
(626, 47, '4. What is displayed when the following script is executed? \n\n<code><span style="color: #000000">\n <span style="color: #0000BB">&lt;?php <br /> <br />    define</span><span style="color: #007700">(</span><span style="color: #0000BB">myvalue</span><span style="color: #007700">, </span><span style="color: #DD0000">"10"</span><span style="color: #007700">); <br />   <br />    </span><span style="color: #0000BB">$myarray</span><span style="color: #007700">[</span><span style="color: #0000BB">10</span><span style="color: #007700">] = </span><span style="color: #DD0000">"Dog"</span><span style="color: #007700">; <br />    </span><span style="color: #0000BB">$myarray</span><span style="color: #007700">[] = </span><span style="color: #DD0000">"Human"</span><span style="color: #007700">; <br />    </span><span style="color: #0000BB">$myarray</span><span style="color: #007700">[</span><span style="color: #DD0000">''myvalue''</span><span style="color: #007700">] = </span><span style="color: #DD0000">"Cat"</span><span style="color: #007700">; <br />    </span><span style="color: #0000BB">$myarray</span><span style="color: #007700">[</span><span style="color: #DD0000">"Dog"</span><span style="color: #007700">] = </span><span style="color: #DD0000">"Cat"</span><span style="color: #007700">; <br /> <br />    print </span><span style="color: #DD0000">"The value is: "</span><span style="color: #007700">; <br />    print </span><span style="color: #0000BB">$myarray</span><span style="color: #007700">[</span><span style="color: #0000BB">myvalue</span><span style="color: #007700">].</span><span style="color: #DD0000">"\\n"</span><span style="color: #007700">;<br /><br /> </span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:18'),
(627, 47, '5. What is the difference between print() and echo()?', '2012-06-25 14:49:18'),
(628, 47, '6. What is the output of the following script? \n\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br />  $a </span><span style="color: #007700">= </span><span style="color: #0000BB">10</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">20</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$c </span><span style="color: #007700">= </span><span style="color: #0000BB">4</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$d </span><span style="color: #007700">= </span><span style="color: #0000BB">8</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$e </span><span style="color: #007700">= </span><span style="color: #0000BB">1.0</span><span style="color: #007700">; <br /> <br />  </span><span style="color: #0000BB">$f </span><span style="color: #007700">= </span><span style="color: #0000BB">$c </span><span style="color: #007700">+ </span><span style="color: #0000BB">$d </span><span style="color: #007700">* </span><span style="color: #0000BB">2</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$g </span><span style="color: #007700">= </span><span style="color: #0000BB">$f </span><span style="color: #007700">% </span><span style="color: #0000BB">20</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$h </span><span style="color: #007700">= </span><span style="color: #0000BB">$b </span><span style="color: #007700">- </span><span style="color: #0000BB">$a </span><span style="color: #007700">+ </span><span style="color: #0000BB">$c </span><span style="color: #007700">+ </span><span style="color: #0000BB">2</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">$h </span><span style="color: #007700">&lt;&lt; </span><span style="color: #0000BB">$c</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$j </span><span style="color: #007700">= </span><span style="color: #0000BB">$i </span><span style="color: #007700">* </span><span style="color: #0000BB">$e</span><span style="color: #007700">; <br /> <br /> print </span><span style="color: #0000BB">$j</span><span style="color: #007700">; <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:18'),
(629, 47, '7. Which values should be assigned to the variables $a,  $b and $c in order for the following script to display the string Hello, World!? \n \n<code><span style="color: #000000">\n <span style="color: #0000BB">&lt;?php <br />  $string </span><span style="color: #007700">= </span><span style="color: #DD0000">"Hello, World!"</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$a </span><span style="color: #007700">= ?; <br />  </span><span style="color: #0000BB">$b </span><span style="color: #007700">= ?; <br />  </span><span style="color: #0000BB">$c </span><span style="color: #007700">= ?; <br /> <br /> if(</span><span style="color: #0000BB">$a</span><span style="color: #007700">) { <br />    if(</span><span style="color: #0000BB">$b </span><span style="color: #007700">&amp;&amp; !</span><span style="color: #0000BB">$c</span><span style="color: #007700">) { <br />   echo </span><span style="color: #DD0000">"Goodbye Cruel World!"</span><span style="color: #007700">; <br />    } else if(!</span><span style="color: #0000BB">$b </span><span style="color: #007700">&amp;&amp; !</span><span style="color: #0000BB">$c</span><span style="color: #007700">) { <br />   echo </span><span style="color: #DD0000">"Nothing here"</span><span style="color: #007700">; <br />  }  <br /> } else { <br />  if(!</span><span style="color: #0000BB">$b</span><span style="color: #007700">) { <br />   if(!</span><span style="color: #0000BB">$a </span><span style="color: #007700">&amp;&amp; (!</span><span style="color: #0000BB">$b </span><span style="color: #007700">&amp;&amp; </span><span style="color: #0000BB">$c</span><span style="color: #007700">)) { <br />         echo </span><span style="color: #DD0000">"Hello, World!"</span><span style="color: #007700">; <br />   } else { <br />         echo </span><span style="color: #DD0000">"Goodbye World!"</span><span style="color: #007700">; <br />   } <br />  } else { <br />   echo </span><span style="color: #DD0000">"Not quite."</span><span style="color: #007700">; <br />  } <br /> } <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:18'),
(630, 47, '8. What will the following script output?\n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /><br />$array </span><span style="color: #007700">= </span><span style="color: #DD0000">''0123456789ABCDEFG''</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">$s </span><span style="color: #007700">= </span><span style="color: #DD0000">''''</span><span style="color: #007700">;<br /><br />for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">1</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">50</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++) {<br />  </span><span style="color: #0000BB">$s </span><span style="color: #007700">.= </span><span style="color: #0000BB">$array</span><span style="color: #007700">[</span><span style="color: #0000BB">rand</span><span style="color: #007700">(</span><span style="color: #0000BB">0</span><span style="color: #007700">,</span><span style="color: #0000BB">strlen </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">) - </span><span style="color: #0000BB">1</span><span style="color: #007700">)];<br />}<br /><br />echo </span><span style="color: #0000BB">$s</span><span style="color: #007700">;<br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:18'),
(631, 47, '9. Which language construct can best represent the following series of if conditionals? \n\n<code><span style="color: #000000">\n <span style="color: #0000BB">&lt;?php <br />  </span><span style="color: #007700">if(</span><span style="color: #0000BB">$a </span><span style="color: #007700">== </span><span style="color: #DD0000">''a''</span><span style="color: #007700">) { <br />  </span><span style="color: #0000BB">somefunction</span><span style="color: #007700">(); <br />  } else if (</span><span style="color: #0000BB">$a </span><span style="color: #007700">== </span><span style="color: #DD0000">''b''</span><span style="color: #007700">) { <br />  </span><span style="color: #0000BB">anotherfunction</span><span style="color: #007700">(); <br />  } else if (</span><span style="color: #0000BB">$a </span><span style="color: #007700">== </span><span style="color: #DD0000">''c''</span><span style="color: #007700">) { <br />  </span><span style="color: #0000BB">dosomething</span><span style="color: #007700">(); <br /> } else { <br />  </span><span style="color: #0000BB">donothing</span><span style="color: #007700">(); <br /> } <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:18'),
(632, 47, '10. What is the best way to iterate through the $myarray array, assuming you want to modify the value of each element as you do? \n\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />  $myarray </span><span style="color: #007700">= array (</span><span style="color: #DD0000">"My String"</span><span style="color: #007700">,  <br />                    </span><span style="color: #DD0000">"Another String"</span><span style="color: #007700">,  <br />                    </span><span style="color: #DD0000">"Hi, Mom!"</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:19'),
(633, 47, '11. Consider the following segment of code: \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> define</span><span style="color: #007700">(</span><span style="color: #DD0000">"STOP_AT"</span><span style="color: #007700">, </span><span style="color: #0000BB">1024</span><span style="color: #007700">); <br /> <br /> </span><span style="color: #0000BB">$result </span><span style="color: #007700">= array(); <br /> <br />  </span><span style="color: #FF8000">/* Missing code */ <br /> </span><span style="color: #007700">{ <br />  </span><span style="color: #0000BB">$result</span><span style="color: #007700">[] = </span><span style="color: #0000BB">$idx</span><span style="color: #007700">; <br /> } <br />  <br /> </span><span style="color: #0000BB">print_r</span><span style="color: #007700">(</span><span style="color: #0000BB">$result</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code> \nWhat should go in the marked segment to produce the following array output? \n \n<code><span style="color: #000000">\n Array <br />{  <br />  [0] =&gt; 1 <br />  [1] =&gt; 2 <br />  [2] =&gt; 4 <br />  [3] =&gt; 8 <br />  [4] =&gt; 16 <br />  [5] =&gt; 32 <br />  [6] =&gt; 64 <br />  [7] =&gt; 128 <br />  [8] =&gt; 256 <br />  [9] =&gt; 512 <br />} </span>\n</code>', '2012-06-25 14:49:19'),
(634, 47, '12. Choose the appropriate function declaration for the user-defined function is_leap(). Assume that, if not otherwise defined, the is_leap function uses the year 2000 as a default value: \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #FF8000">/* Function declaration here */ <br /></span><span style="color: #007700">{ <br />  </span><span style="color: #0000BB">$is_leap </span><span style="color: #007700">= (!(</span><span style="color: #0000BB">$year </span><span style="color: #007700">%</span><span style="color: #0000BB">4</span><span style="color: #007700">) &amp;&amp; ((</span><span style="color: #0000BB">$year </span><span style="color: #007700">% </span><span style="color: #0000BB">100</span><span style="color: #007700">) || !(</span><span style="color: #0000BB">$year </span><span style="color: #007700">% </span><span style="color: #0000BB">400</span><span style="color: #007700">))); <br />    return </span><span style="color: #0000BB">$is_leap</span><span style="color: #007700">;<br />} <br /> <br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">is_leap</span><span style="color: #007700">(</span><span style="color: #0000BB">1987</span><span style="color: #007700">));  </span><span style="color: #FF8000">/* Displays false */ <br /></span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">is_leap</span><span style="color: #007700">());     </span><span style="color: #FF8000">/* Displays true */ <br /> <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:19'),
(635, 47, '13. What is the value displayed when the following is executed? Assume that the code was executed using the following URL: \n \n<code><span style="color: #000000">\n testscript.php?c=25 </span>\n</code> \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />  </span><span style="color: #007700">function </span><span style="color: #0000BB">process</span><span style="color: #007700">(</span><span style="color: #0000BB">$c</span><span style="color: #007700">, </span><span style="color: #0000BB">$d </span><span style="color: #007700">= </span><span style="color: #0000BB">25</span><span style="color: #007700">) <br /> { <br />  global </span><span style="color: #0000BB">$e</span><span style="color: #007700">; <br />    </span><span style="color: #0000BB">$retval </span><span style="color: #007700">= </span><span style="color: #0000BB">$c </span><span style="color: #007700">+ </span><span style="color: #0000BB">$d </span><span style="color: #007700">- </span><span style="color: #0000BB">$_GET</span><span style="color: #007700">[</span><span style="color: #DD0000">''c''</span><span style="color: #007700">] - </span><span style="color: #0000BB">$e</span><span style="color: #007700">; <br />  return </span><span style="color: #0000BB">$retval</span><span style="color: #007700">; <br /> } <br />  </span><span style="color: #0000BB">$e </span><span style="color: #007700">= </span><span style="color: #0000BB">10</span><span style="color: #007700">; <br /> echo </span><span style="color: #0000BB">process</span><span style="color: #007700">(</span><span style="color: #0000BB">5</span><span style="color: #007700">);   <br />      <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:19'),
(636, 47, '14. Consider the following script: \n \n<code><span style="color: #000000">\n <span style="color: #0000BB">&lt;?php <br /></span><span style="color: #007700">function </span><span style="color: #0000BB">myfunction</span><span style="color: #007700">(</span><span style="color: #0000BB">$a</span><span style="color: #007700">, </span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">true</span><span style="color: #007700">) <br />{ <br />   if(</span><span style="color: #0000BB">$a </span><span style="color: #007700">&amp;&amp; !</span><span style="color: #0000BB">$b</span><span style="color: #007700">) { <br />   echo </span><span style="color: #DD0000">"Hello, World!\\n"</span><span style="color: #007700">; <br />  } <br />}<br /> <br />  </span><span style="color: #0000BB">$s </span><span style="color: #007700">= array(</span><span style="color: #0000BB">0 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">"my"</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">1 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">"call"</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">2 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''$function''</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">3 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">'' ''</span><span style="color: #007700">, <br />                   </span><span style="color: #0000BB">4 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">"function"</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">5 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''$a''</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">6 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''$b''</span><span style="color: #007700">,  <br />                   </span><span style="color: #0000BB">7 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''a''</span><span style="color: #007700">,  <br /> <br />                   </span><span style="color: #0000BB">8 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''b''</span><span style="color: #007700">, <br />                   </span><span style="color: #0000BB">9 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''''</span><span style="color: #007700">); <br /> <br />  </span><span style="color: #0000BB">$a </span><span style="color: #007700">= </span><span style="color: #0000BB">true</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">false</span><span style="color: #007700">; <br />  </span><span style="color: #FF8000">/* Group A */ <br />  </span><span style="color: #0000BB">$name </span><span style="color: #007700">= </span><span style="color: #0000BB">$s</span><span style="color: #007700">[?].</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?].</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?].</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?].</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?].</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?]; <br /> <br />  </span><span style="color: #FF8000">/* Group B */ <br /> </span><span style="color: #0000BB">$name</span><span style="color: #007700">(${</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?]}, ${</span><span style="color: #0000BB">$s</span><span style="color: #007700">[?]}); <br /> <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code> \nEach  ?  in the above script represents an integer index against the $s  array. In order to display the Hello, World! string when executed, what must the missing integer indexes be?', '2012-06-25 14:49:19'),
(637, 47, '15. Run-time inclusion of a PHP script is performed using the ________ construct, while compile-time inclusion of PHP scripts is performed using the _______ construct.', '2012-06-25 14:49:19'),
(638, 47, '16. Under what circumstance is it impossible to assign a default value to a parameter while declaring a function?', '2012-06-25 14:49:19'),
(639, 47, '17. The ____ operator returns True if either of its operands can be evaluated as True, but not both. (enter as text, not symbol)', '2012-06-25 14:49:19'),
(640, 47, '18. How does the identity operator === compare two values?', '2012-06-25 14:49:19'),
(641, 47, '19. Which of the following expressions multiply the value of the integer variable $a by 4? (Choose 2)', '2012-06-25 14:49:19'),
(642, 47, '20. How can a script come to a clean termination?', '2012-06-25 14:49:19'),
(643, 48, '1. What is the construct used to define the blueprint of an object called?', '2012-06-25 14:49:19'),
(644, 48, '2. At the end of the execution of the following script, which values will be stored in the $a-&gt;my_value array? (Choose 3)\n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">my_class<br /></span><span style="color: #007700">{ <br /> <br /> var </span><span style="color: #0000BB">$my_value </span><span style="color: #007700">= array(); <br />  <br /> function </span><span style="color: #0000BB">my_class </span><span style="color: #007700">(</span><span style="color: #0000BB">$value</span><span style="color: #007700">) <br /> { <br />  </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value</span><span style="color: #007700">[] = </span><span style="color: #0000BB">$value</span><span style="color: #007700">; <br /> } <br />  <br /> function </span><span style="color: #0000BB">set_value </span><span style="color: #007700">(</span><span style="color: #0000BB">$value</span><span style="color: #007700">) <br /> { <br />  </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">$my_value </span><span style="color: #007700">= </span><span style="color: #0000BB">$value</span><span style="color: #007700">; <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">$a </span><span style="color: #007700">= new </span><span style="color: #0000BB">my_class </span><span style="color: #007700">(</span><span style="color: #DD0000">''a''</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value</span><span style="color: #007700">[] = </span><span style="color: #DD0000">''b''</span><span style="color: #007700">; <br /></span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">set_value </span><span style="color: #007700">(</span><span style="color: #DD0000">''c''</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_class</span><span style="color: #007700">(</span><span style="color: #DD0000">''d''</span><span style="color: #007700">); <br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:19'),
(645, 48, '3. How can you write a class so that some of its properties cannot be accessed from outside its methods?', '2012-06-25 14:49:19'),
(646, 48, '4. Which object-oriented pattern would you use to implement a class that must be instantiated only once for the entire lifespan of a script?', '2012-06-25 14:49:20'),
(647, 48, '5. A class can be built as an extension of other classes using a process known as inheritance. In PHP, how many parents can a child class inherit from?', '2012-06-25 14:49:20'),
(648, 48, '6. What OOP construct unavailable in PHP 4 does the following script approximate? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">my_class <br /></span><span style="color: #007700">{ <br />  function </span><span style="color: #0000BB">my_funct </span><span style="color: #007700">(</span><span style="color: #0000BB">$my_param</span><span style="color: #007700">) <br /> { <br />    </span><span style="color: #0000BB">user_error </span><span style="color: #007700">(</span><span style="color: #DD0000">"Please define me"</span><span style="color: #007700">, </span><span style="color: #0000BB">E_ERROR</span><span style="color: #007700">); <br /> } <br /> <br /> function </span><span style="color: #0000BB">b</span><span style="color: #007700">() <br /> { <br />  return </span><span style="color: #0000BB">10</span><span style="color: #007700">; <br /> } <br />} <br /> </span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:20'),
(649, 48, '7. Assume that a class called testclass is defined. What must the name of its constructor method be?', '2012-06-25 14:49:20'),
(650, 48, '8. How can a class override the default serialization mechanism for its objects?', '2012-06-25 14:49:20'),
(651, 48, '9. In PHP 4, which object-oriented constructs from the following list are not available? \n \nÂ  Abstract classes \nÂ  Final classes \nÂ  Public, private, protected (PPP) methods \nÂ  Interfaces', '2012-06-25 14:49:20'),
(652, 48, '10. How would you call the mymethod method of a class within the class itself?', '2012-06-25 14:49:20'),
(653, 48, '11. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">my_class <br /></span><span style="color: #007700">{ <br /> var  </span><span style="color: #0000BB">$my_var</span><span style="color: #007700">; <br />  <br /> function </span><span style="color: #0000BB">_my_class </span><span style="color: #007700">(</span><span style="color: #0000BB">$value</span><span style="color: #007700">) <br /> { <br />  </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_var </span><span style="color: #007700">= </span><span style="color: #0000BB">$value</span><span style="color: #007700">; <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">$a </span><span style="color: #007700">= new </span><span style="color: #0000BB">my_class </span><span style="color: #007700">(</span><span style="color: #0000BB">10</span><span style="color: #007700">); <br /> <br />echo </span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_var</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(654, 48, '12. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">my_class <br /></span><span style="color: #007700">{ <br /> var </span><span style="color: #0000BB">$my_value</span><span style="color: #007700">; <br />} <br /> <br /></span><span style="color: #0000BB">$a </span><span style="color: #007700">= new </span><span style="color: #0000BB">my_class</span><span style="color: #007700">; <br /></span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value </span><span style="color: #007700">= </span><span style="color: #0000BB">5</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">$a</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$b</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value </span><span style="color: #007700">= </span><span style="color: #0000BB">10</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(655, 48, '13. Consider the following script. What will it output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$global_obj </span><span style="color: #007700">= </span><span style="color: #0000BB">null</span><span style="color: #007700">; <br /> <br />class </span><span style="color: #0000BB">my_class <br /></span><span style="color: #007700">{ <br /> var </span><span style="color: #0000BB">$my_value</span><span style="color: #007700">; <br />  <br /> function </span><span style="color: #0000BB">my_class</span><span style="color: #007700">() <br /> { <br />  global </span><span style="color: #0000BB">$global_obj</span><span style="color: #007700">; <br />   <br />  </span><span style="color: #0000BB">$global_obj </span><span style="color: #007700">= &amp;</span><span style="color: #0000BB">$this</span><span style="color: #007700">; <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">$a </span><span style="color: #007700">= new </span><span style="color: #0000BB">my_class</span><span style="color: #007700">; <br /></span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value </span><span style="color: #007700">= </span><span style="color: #0000BB">5</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$global_obj</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value </span><span style="color: #007700">= </span><span style="color: #0000BB">10</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">$a</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">my_value</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(656, 48, '14. Consider the following segment of PHP code. When it is executed, the string returned by the $eight_tenths-&gt;to_string method is 8 / 10 instead of the expected 4 / 5. Why? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />  </span><span style="color: #007700">class </span><span style="color: #0000BB">fraction </span><span style="color: #007700">{ <br />  var </span><span style="color: #0000BB">$numerator</span><span style="color: #007700">; <br />  var </span><span style="color: #0000BB">$denominator</span><span style="color: #007700">; <br /> <br />  function </span><span style="color: #0000BB">fraction</span><span style="color: #007700">(</span><span style="color: #0000BB">$n</span><span style="color: #007700">, </span><span style="color: #0000BB">$d</span><span style="color: #007700">) { <br />   </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">set_numerator</span><span style="color: #007700">(</span><span style="color: #0000BB">$n</span><span style="color: #007700">); <br />   </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">set_denominator</span><span style="color: #007700">(</span><span style="color: #0000BB">$d</span><span style="color: #007700">); <br />  } <br /> <br />  function </span><span style="color: #0000BB">set_numerator</span><span style="color: #007700">(</span><span style="color: #0000BB">$num</span><span style="color: #007700">) { <br />   </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">numerator </span><span style="color: #007700">= (int)</span><span style="color: #0000BB">$num</span><span style="color: #007700">; <br />  } <br /> <br />  function </span><span style="color: #0000BB">set_denominator</span><span style="color: #007700">(</span><span style="color: #0000BB">$num</span><span style="color: #007700">) { <br />   </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">denominator </span><span style="color: #007700">= (int)</span><span style="color: #0000BB">$num</span><span style="color: #007700">; <br />  } <br /> <br />  function </span><span style="color: #0000BB">to_string</span><span style="color: #007700">() { <br />   return </span><span style="color: #DD0000">"</span><span style="color: #007700">{</span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">numerator</span><span style="color: #007700">}</span><span style="color: #DD0000">  <br />                             / </span><span style="color: #007700">{</span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">denominator</span><span style="color: #007700">}</span><span style="color: #DD0000">"</span><span style="color: #007700">; <br />  } <br /> <br /> } <br /> <br />  function </span><span style="color: #0000BB">gcd</span><span style="color: #007700">(</span><span style="color: #0000BB">$a</span><span style="color: #007700">, </span><span style="color: #0000BB">$b</span><span style="color: #007700">) { <br />    return (</span><span style="color: #0000BB">$b </span><span style="color: #007700">&gt; </span><span style="color: #0000BB">0</span><span style="color: #007700">) ? </span><span style="color: #0000BB">gcd</span><span style="color: #007700">(</span><span style="color: #0000BB">$b</span><span style="color: #007700">, </span><span style="color: #0000BB">$a </span><span style="color: #007700">% </span><span style="color: #0000BB">$b</span><span style="color: #007700">) : </span><span style="color: #0000BB">$a</span><span style="color: #007700">; <br /> } <br /> <br /> function </span><span style="color: #0000BB">reduce_fraction</span><span style="color: #007700">(</span><span style="color: #0000BB">$fraction</span><span style="color: #007700">) { <br />   <br />  </span><span style="color: #0000BB">$gcd </span><span style="color: #007700">= </span><span style="color: #0000BB">gcd</span><span style="color: #007700">(</span><span style="color: #0000BB">$fraction</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">numerator</span><span style="color: #007700">, <br />  </span><span style="color: #0000BB">$fraction</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">denominator</span><span style="color: #007700">); <br />  </span><span style="color: #0000BB">$fraction</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">numerator </span><span style="color: #007700">/= </span><span style="color: #0000BB">$gcd</span><span style="color: #007700">; <br />  </span><span style="color: #0000BB">$fraction</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">denominator </span><span style="color: #007700">/= </span><span style="color: #0000BB">$gcd</span><span style="color: #007700">; <br /> } <br /> <br />  </span><span style="color: #0000BB">$eight_tenths </span><span style="color: #007700">= new </span><span style="color: #0000BB">fraction</span><span style="color: #007700">(</span><span style="color: #0000BB">8</span><span style="color: #007700">,</span><span style="color: #0000BB">10</span><span style="color: #007700">); <br /> <br /></span><span style="color: #FF8000">/* Reduce the fraction */ <br /> </span><span style="color: #0000BB">reduce_fraction</span><span style="color: #007700">(</span><span style="color: #0000BB">$eight_tenths</span><span style="color: #007700">); <br />  <br /> </span><span style="color: #0000BB">var_dump</span><span style="color: #007700">(</span><span style="color: #0000BB">$eight_tenths</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">to_string</span><span style="color: #007700">()); <br /> <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:20'),
(657, 48, '15. What does the following PHP code segment do? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php  <br /> <br /> </span><span style="color: #007700">require_once(</span><span style="color: #DD0000">"myclass.php"</span><span style="color: #007700">); <br /> </span><span style="color: #0000BB">myclass</span><span style="color: #007700">::</span><span style="color: #0000BB">mymethod</span><span style="color: #007700">(); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(658, 48, '16. Do static class variables exist in PHP?', '2012-06-25 14:49:20'),
(659, 48, '17. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">a </span><span style="color: #007700">{<br /> function </span><span style="color: #0000BB">a </span><span style="color: #007700">(</span><span style="color: #0000BB">$x </span><span style="color: #007700">= </span><span style="color: #0000BB">1</span><span style="color: #007700">) <br /> { <br />  </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">myvar </span><span style="color: #007700">= </span><span style="color: #0000BB">$x</span><span style="color: #007700">; <br /> } <br />} <br /> <br />class </span><span style="color: #0000BB">b </span><span style="color: #007700">extends </span><span style="color: #0000BB">a </span><span style="color: #007700">{ <br /> var </span><span style="color: #0000BB">$myvar</span><span style="color: #007700">;<br />  <br /> function </span><span style="color: #0000BB">b </span><span style="color: #007700">(</span><span style="color: #0000BB">$x </span><span style="color: #007700">= </span><span style="color: #0000BB">2</span><span style="color: #007700">) <br /> { <br />  </span><span style="color: #0000BB">$this</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">myvar </span><span style="color: #007700">= </span><span style="color: #0000BB">$x</span><span style="color: #007700">; <br />   </span><span style="color: #0000BB">parent</span><span style="color: #007700">::</span><span style="color: #0000BB">a</span><span style="color: #007700">(); <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">$obj </span><span style="color: #007700">= new </span><span style="color: #0000BB">b</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">$obj</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">myvar</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(660, 48, '18. How can you load classes on demand as they are required by the interpreter?', '2012-06-25 14:49:20'),
(661, 48, '19. _____________________ are used to provide high-quality solutions to a recurrent design problem using object-oriented programming.', '2012-06-25 14:49:20'),
(662, 48, '20. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /></span><span style="color: #007700">class </span><span style="color: #0000BB">a <br /></span><span style="color: #007700">{ <br /> function </span><span style="color: #0000BB">a</span><span style="color: #007700">() <br /> { <br />  echo </span><span style="color: #DD0000">''Parent called''</span><span style="color: #007700">;<br /> }<br />} <br /> <br />class </span><span style="color: #0000BB">b <br /></span><span style="color: #007700">{ <br /> function </span><span style="color: #0000BB">b</span><span style="color: #007700">() <br /> { <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">$c </span><span style="color: #007700">= new </span><span style="color: #0000BB">b</span><span style="color: #007700">();<br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:20'),
(663, 49, '1. How are session variables accessed?', '2012-06-25 14:49:21'),
(664, 49, '2. What function causes the following header to be added to your server’s output?\n<code><span style="color: #000000">\nSet-Cookie: foo=bar; </span>\n</code>', '2012-06-25 14:49:21'),
(665, 49, '3. Under normal circumstances—and ignoring any browser bugs—how can a cookie be accessed from a domain other than the one it was set for?', '2012-06-25 14:49:21'),
(666, 49, '4. How can the index.php script access the email form element of the following HTML form? (Choose 2)\n<code><span style="color: #000000">\n&lt;form action="index.php" method="post"&gt;<br />  &lt;input type="text" name="email"/&gt; <br />&lt;/form&gt;</span>\n</code>', '2012-06-25 14:49:21'),
(667, 49, '5. What will be the net effect of running the following script on the $s string? (Choose 2) \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$s </span><span style="color: #007700">= </span><span style="color: #DD0000">''&lt;p&gt;Hello&lt;/p&gt;''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$ss </span><span style="color: #007700">= </span><span style="color: #0000BB">htmlentities </span><span style="color: #007700">(</span><span style="color: #0000BB">$s</span><span style="color: #007700">); <br /><br />echo </span><span style="color: #0000BB">$s</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:21'),
(668, 49, '6. If no expiration time is explicitly set for a cookie, what happens to it?', '2012-06-25 14:49:21'),
(669, 49, '7. Consider the following form and subsequent script. What will the script print out if the user \ntypes the word “php” and “great” in the two text boxes respectively? \n \n<code><span style="color: #000000">\n&lt;form action="index.php" method="post"&gt;<br />&lt;input type="text" name="element[]"&gt;<br />&lt;input type="text" name="element[]"&gt;<br /> <br />&lt;/form&gt;<br /><span style="color: #0000BB">&lt;?php<br /><br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">$_GET</span><span style="color: #007700">[</span><span style="color: #DD0000">''element''</span><span style="color: #007700">];<br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:21'),
(670, 49, '8. In an HTTPS transaction, how are URLs and query strings passed from the browser to the web server?', '2012-06-25 14:49:21'),
(671, 49, '9. What happens when a form submitted to a PHP script contains two elements with the same name?', '2012-06-25 14:49:21'),
(672, 49, '10. How would you store an array in a cookie?', '2012-06-25 14:49:21'),
(673, 49, '11. What will the following script output? \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />ob_start</span><span style="color: #007700">(); <br /> <br />for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">10</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++) { <br /> echo </span><span style="color: #0000BB">$i</span><span style="color: #007700">;  <br />} <br /> <br /></span><span style="color: #0000BB">$output </span><span style="color: #007700">= </span><span style="color: #0000BB">ob_get_contents</span><span style="color: #007700">(); <br /> <br /></span><span style="color: #0000BB">ob_end_clean</span><span style="color: #007700">(); <br /> <br />echo </span><span style="color: #0000BB">$ouput</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:21'),
(674, 49, '12. By default, PHP stores session data in ________________.', '2012-06-25 14:49:21'),
(675, 49, '13. When you write a cookie with an expiration date in the future to a particular machine, the cookie never seem to be set. The technique usually works with other computers, and you have checked that the time on the machine corresponds to the time on the server within a reasonable margin by verifying the date reported by the operating system on the client computer’s desktop. The browser on the client machine seems to otherwise work fine on most other websites. What could be likely causes of this problem? (Choose 2)', '2012-06-25 14:49:21'),
(676, 49, '14. Assuming that the client browser is never restarted, how long after the last access will a session “expire” and be subject to garbage collection?', '2012-06-25 14:49:21'),
(677, 49, '15. The ___________ function automatically transforms newline characters into HTML &lt;br /&gt; tags', '2012-06-25 14:49:21'),
(678, 50, '1. Array values are keyed by ______ values (called indexed arrays) or using ______ values (called associative arrays). Of course, these key methods can be combined as well.', '2012-06-25 14:49:21'),
(679, 50, '2. Consider the following array, called $multi_array. How would the value cat be referenced within the $multi_array array?\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$multi_array </span><span style="color: #007700">= array(</span><span style="color: #DD0000">"red"</span><span style="color: #007700">, <br />  </span><span style="color: #DD0000">"green"</span><span style="color: #007700">,<br />  </span><span style="color: #0000BB">42 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">"blue"</span><span style="color: #007700">, <br />  </span><span style="color: #DD0000">"yellow" </span><span style="color: #007700">=&gt; array(</span><span style="color: #DD0000">"apple"</span><span style="color: #007700">, <br />       </span><span style="color: #0000BB">9 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">"pear"</span><span style="color: #007700">, <br />       </span><span style="color: #DD0000">"banana"</span><span style="color: #007700">, <br />       </span><span style="color: #DD0000">"orange" </span><span style="color: #007700">=&gt; array(</span><span style="color: #DD0000">"dog"</span><span style="color: #007700">, <br />                             </span><span style="color: #DD0000">"cat"</span><span style="color: #007700">, <br />                             </span><span style="color: #DD0000">"iguana"</span><span style="color: #007700">) <br />       )<br />); <br /> </span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:21'),
(680, 50, '3. What will the $array array contain at the end of the execution of the following script? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /><br />$array </span><span style="color: #007700">= array (</span><span style="color: #DD0000">''1''</span><span style="color: #007700">, </span><span style="color: #DD0000">''1''</span><span style="color: #007700">); <br />foreach (</span><span style="color: #0000BB">$array </span><span style="color: #007700">as </span><span style="color: #0000BB">$k </span><span style="color: #007700">=&gt; </span><span style="color: #0000BB">$v</span><span style="color: #007700">) { <br />  </span><span style="color: #0000BB">$v </span><span style="color: #007700">= </span><span style="color: #0000BB">2</span><span style="color: #007700">;<br />} <br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:21'),
(681, 50, '4. Assume you would like to sort an array in ascending order by value while preserving key associations.  Which of the following PHP sorting functions would you use?', '2012-06-25 14:49:22'),
(682, 50, '5. What is the name of a function used to convert an array into a string?', '2012-06-25 14:49:22');
INSERT INTO `quiz_questions` (`id`, `topic_id`, `text`, `date_create`) VALUES
(683, 50, '6. In what order will the following script output the contents of the $array array? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #DD0000">''a1''</span><span style="color: #007700">, </span><span style="color: #DD0000">''a3''</span><span style="color: #007700">, </span><span style="color: #DD0000">''a5''</span><span style="color: #007700">, </span><span style="color: #DD0000">''a10''</span><span style="color: #007700">, </span><span style="color: #DD0000">''a20''</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">natsort </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">var_dump </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(684, 50, '7. Which function would you use to rearrange the contents of the following array so that they are reversed (i.e.: array (''d'', ''c'', ''b'', ''a'') as the final result)? (Choose 2) \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #DD0000">''a''</span><span style="color: #007700">, </span><span style="color: #DD0000">''b''</span><span style="color: #007700">, </span><span style="color: #DD0000">''c''</span><span style="color: #007700">, </span><span style="color: #DD0000">''d''</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(685, 50, '8. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #DD0000">''3'' </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''a''</span><span style="color: #007700">, </span><span style="color: #DD0000">''1b'' </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''b''</span><span style="color: #007700">, </span><span style="color: #DD0000">''c''</span><span style="color: #007700">, </span><span style="color: #DD0000">''d''</span><span style="color: #007700">); <br /> <br />echo (</span><span style="color: #0000BB">$array</span><span style="color: #007700">[</span><span style="color: #0000BB">1</span><span style="color: #007700">]); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(686, 50, '9. What is the simplest method of computing the sum of all the elements of an array?', '2012-06-25 14:49:22'),
(687, 50, '10. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #0000BB">0.1 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''a''</span><span style="color: #007700">, </span><span style="color: #0000BB">0.2 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''b''</span><span style="color: #007700">); <br /> <br />echo </span><span style="color: #0000BB">count </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(688, 50, '11. What elements will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #0000BB">true </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''a''</span><span style="color: #007700">, </span><span style="color: #0000BB">1 </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">''b''</span><span style="color: #007700">);<br /> <br /></span><span style="color: #0000BB">var_dump </span><span style="color: #007700">(</span><span style="color: #0000BB">$aray</span><span style="color: #007700">);<br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(689, 50, '12. Absent any actual need for choosing one method over the other, does passing arrays by value to a read-only function reduce performance compared to passing them by reference?', '2012-06-25 14:49:22'),
(690, 50, '13. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /></span><span style="color: #007700">function </span><span style="color: #0000BB">sort_my_array </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">) <br />{<br />  return </span><span style="color: #0000BB">sort </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">);<br />}<br /><br /></span><span style="color: #0000BB">$a1 </span><span style="color: #007700">= array (</span><span style="color: #0000BB">3</span><span style="color: #007700">, </span><span style="color: #0000BB">2</span><span style="color: #007700">, </span><span style="color: #0000BB">1</span><span style="color: #007700">);<br /> <br /></span><span style="color: #0000BB">var_dump </span><span style="color: #007700">(</span><span style="color: #0000BB">sort_my_array </span><span style="color: #007700">(&amp;</span><span style="color: #0000BB">$a1</span><span style="color: #007700">));<br /><br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(691, 50, '14. What will be the output of the following script? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$result </span><span style="color: #007700">= </span><span style="color: #DD0000">''''</span><span style="color: #007700">; <br /> <br />function </span><span style="color: #0000BB">glue </span><span style="color: #007700">(</span><span style="color: #0000BB">$val</span><span style="color: #007700">) <br />{ <br /> global </span><span style="color: #0000BB">$result</span><span style="color: #007700">; <br />  <br />  </span><span style="color: #0000BB">$result </span><span style="color: #007700">.= </span><span style="color: #0000BB">$val</span><span style="color: #007700">; <br />} <br /> <br /></span><span style="color: #0000BB">$array </span><span style="color: #007700">= array (</span><span style="color: #DD0000">''a''</span><span style="color: #007700">, </span><span style="color: #DD0000">''b''</span><span style="color: #007700">, </span><span style="color: #DD0000">''c''</span><span style="color: #007700">, </span><span style="color: #DD0000">''d''</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">array_walk </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">, </span><span style="color: #DD0000">''glue''</span><span style="color: #007700">); <br /> <br />echo </span><span style="color: #0000BB">$result</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(692, 50, '15. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$array </span><span style="color: #007700">= array (</span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">2</span><span style="color: #007700">, </span><span style="color: #0000BB">3</span><span style="color: #007700">, </span><span style="color: #0000BB">5</span><span style="color: #007700">, </span><span style="color: #0000BB">8</span><span style="color: #007700">, </span><span style="color: #0000BB">13</span><span style="color: #007700">, </span><span style="color: #0000BB">21</span><span style="color: #007700">, </span><span style="color: #0000BB">34</span><span style="color: #007700">, </span><span style="color: #0000BB">55</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">$sum </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; <br /> <br />for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">5</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++) { <br />  </span><span style="color: #0000BB">$sum </span><span style="color: #007700">+= </span><span style="color: #0000BB">$array</span><span style="color: #007700">[</span><span style="color: #0000BB">$array</span><span style="color: #007700">[</span><span style="color: #0000BB">$i</span><span style="color: #007700">]]; <br />} <br /> <br />echo </span><span style="color: #0000BB">$sum</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(693, 51, '1. Consider the following script. What line of code should be inserted in the marked location in order to display the string php when this script is executed? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /> $alpha </span><span style="color: #007700">= </span><span style="color: #DD0000">''abcdefghijklmnopqrstuvwxyz''</span><span style="color: #007700">; <br /> <br />  </span><span style="color: #0000BB">$letters </span><span style="color: #007700">= array(</span><span style="color: #0000BB">15</span><span style="color: #007700">, </span><span style="color: #0000BB">7</span><span style="color: #007700">, </span><span style="color: #0000BB">15</span><span style="color: #007700">); <br /> <br />  foreach(</span><span style="color: #0000BB">$letters </span><span style="color: #007700">as </span><span style="color: #0000BB">$val</span><span style="color: #007700">) { <br /> <br />    </span><span style="color: #FF8000">/* What should be here */ <br />   <br /> </span><span style="color: #007700">} <br />  <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:22'),
(694, 51, '2. Which of the following will not combine strings $s1 and $s2 into a single string?', '2012-06-25 14:49:22'),
(695, 51, '3. Given a variable $email containing the string user@example.com, which of the following statements would extract the string example.com?', '2012-06-25 14:49:22'),
(696, 51, '4. Given a comma-separated list of values in a string, which function from the given list can create an array of each individual value with a single call?', '2012-06-25 14:49:22'),
(697, 51, '5. What is the best all-purpose way of comparing two strings?', '2012-06-25 14:49:22'),
(698, 51, '6. Which of the following PCRE regular expressions best matches the string php|architect?', '2012-06-25 14:49:22'),
(699, 51, '7. Which of the following functions can be used to determine the integrity of a string? (Choose 3)', '2012-06-25 14:49:23'),
(700, 51, '8. Which PHP function does the following script simulate on a UNIX machine? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">function </span><span style="color: #0000BB">my_funct </span><span style="color: #007700">(</span><span style="color: #0000BB">$filename</span><span style="color: #007700">) <br />{ <br />  </span><span style="color: #0000BB">$f </span><span style="color: #007700">= </span><span style="color: #0000BB">file_get_contents </span><span style="color: #007700">(</span><span style="color: #0000BB">$filename</span><span style="color: #007700">); <br />  <br />  return </span><span style="color: #0000BB">explode </span><span style="color: #007700">(</span><span style="color: #DD0000">"\\n"</span><span style="color: #007700">, </span><span style="color: #0000BB">$f</span><span style="color: #007700">); <br /> <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(701, 51, '9. Which of the following functions can be used to break a string into an array based on a specific pattern? (Choose 2)', '2012-06-25 14:49:23'),
(702, 51, '10. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /></span><span style="color: #007700">echo </span><span style="color: #DD0000">''Testing '' </span><span style="color: #007700">. </span><span style="color: #0000BB">1 </span><span style="color: #007700">+ </span><span style="color: #0000BB">2 </span><span style="color: #007700">. </span><span style="color: #DD0000">''45''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(703, 51, '11. What will be the output of the following script? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$s </span><span style="color: #007700">= </span><span style="color: #DD0000">''12345''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$s</span><span style="color: #007700">[</span><span style="color: #0000BB">$s</span><span style="color: #007700">[</span><span style="color: #0000BB">1</span><span style="color: #007700">]] = </span><span style="color: #DD0000">''2''</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">$s</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(704, 51, '12. Which of the strings below will be matched by the following PCRE regular expression? (Choose 2) \n \n<code>/.*\\*123\\d/</code>', '2012-06-25 14:49:23'),
(705, 51, '13. Which of the following comparisons will return True? (Choose 2)', '2012-06-25 14:49:23'),
(706, 51, '14. What happens if you add a string to an integer using the + operator?', '2012-06-25 14:49:23'),
(707, 51, '15. Consider the following script. Assuming that http://www.php.net can be successfully read, what will it output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$s </span><span style="color: #007700">= </span><span style="color: #0000BB">file_get_contents </span><span style="color: #007700">(</span><span style="color: #DD0000">"http://www.php.net"</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">strip_tags </span><span style="color: #007700">(</span><span style="color: #0000BB">$s</span><span style="color: #007700">, array (</span><span style="color: #DD0000">''p''</span><span style="color: #007700">)); <br /> <br />echo </span><span style="color: #0000BB">count </span><span style="color: #007700">(</span><span style="color: #0000BB">$s</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(708, 51, '16. The ___________ function can be used to compare two strings using a case-insensitive binary algorithm', '2012-06-25 14:49:23'),
(709, 51, '17. Which of the following functions can be used to convert the binary data stored in a string into its hexadecimal representation? (Choose 2)', '2012-06-25 14:49:23'),
(710, 51, '18. The ________________ function can be used to ensure that a string always reaches a specific minimum length.', '2012-06-25 14:49:23'),
(711, 51, '19. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$a </span><span style="color: #007700">= </span><span style="color: #DD0000">''able osts indy''</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">wordwrap </span><span style="color: #007700">(</span><span style="color: #0000BB">$a</span><span style="color: #007700">, </span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #DD0000">"c"</span><span style="color: #007700">, </span><span style="color: #0000BB">false</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(712, 51, '20. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$x </span><span style="color: #007700">= </span><span style="color: #DD0000">''apple''</span><span style="color: #007700">; <br /> <br />echo </span><span style="color: #0000BB">substr_replace </span><span style="color: #007700">(</span><span style="color: #0000BB">$x</span><span style="color: #007700">, </span><span style="color: #DD0000">''x''</span><span style="color: #007700">, </span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">2</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(713, 52, '1. The _______ function is used to read a single line from a file and is used when dealing with text files. For reading binary data or other specific segments of a file, you should use the _______ function instead.', '2012-06-25 14:49:23'),
(714, 52, '2. Although file resources will automatically be closed at the end of a request in PHP, you can close them explicitly by calling the _______ function.', '2012-06-25 14:49:23'),
(715, 52, '3. Consider the following PHP script, which reads a file, line-by-line, from a text file. Which function call should be inserted in place of the question marks in order for the script to function correctly?\n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br />        $file </span><span style="color: #007700">= </span><span style="color: #0000BB">fopen</span><span style="color: #007700">(</span><span style="color: #DD0000">"test"</span><span style="color: #007700">, </span><span style="color: #DD0000">"r"</span><span style="color: #007700">); <br />        while(!</span><span style="color: #0000BB">feof</span><span style="color: #007700">(</span><span style="color: #0000BB">$file</span><span style="color: #007700">)) { <br />                echo ????????????; <br />        } <br />        </span><span style="color: #0000BB">fclose</span><span style="color: #007700">(</span><span style="color: #0000BB">$file</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:23'),
(716, 52, '4. Which of the following techniques will guarantee a lock safe from any race condition?', '2012-06-25 14:49:23'),
(717, 52, '5. Which of the following functions retrieve the entire contents of a file in such a way that it can be used as part of an expression? (Choose 2)', '2012-06-25 14:49:24'),
(718, 52, '6. How would you parse the contents of a multi-line text file formatted using a fixed pattern without preloading its contents into a variable and then processing them in memory?', '2012-06-25 14:49:24'),
(719, 52, '7. Consider the following script. What will the file myfile.txt contain at the end of its execution? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$array </span><span style="color: #007700">= </span><span style="color: #DD0000">''0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">$f </span><span style="color: #007700">= </span><span style="color: #0000BB">fopen </span><span style="color: #007700">(</span><span style="color: #DD0000">"myfile.txt"</span><span style="color: #007700">, </span><span style="color: #DD0000">"r"</span><span style="color: #007700">); <br /> <br />for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">50</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++) { <br />  </span><span style="color: #0000BB">fwrite </span><span style="color: #007700">(</span><span style="color: #0000BB">$f</span><span style="color: #007700">, </span><span style="color: #0000BB">$array</span><span style="color: #007700">[</span><span style="color: #0000BB">rand</span><span style="color: #007700">(</span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">strlen </span><span style="color: #007700">(</span><span style="color: #0000BB">$array</span><span style="color: #007700">) - </span><span style="color: #0000BB">1</span><span style="color: #007700">)]); <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:24'),
(720, 52, '8. What does the built-in delete function do?', '2012-06-25 14:49:24'),
(721, 52, '9. Consider the following script. Which PHP function best approximates its behaviour? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">function </span><span style="color: #0000BB">my_funct </span><span style="color: #007700">(</span><span style="color: #0000BB">$file_name</span><span style="color: #007700">, </span><span style="color: #0000BB">$data</span><span style="color: #007700">) <br />{ <br />  </span><span style="color: #0000BB">$f </span><span style="color: #007700">= </span><span style="color: #0000BB">fopen </span><span style="color: #007700">(</span><span style="color: #0000BB">$file_name</span><span style="color: #007700">, </span><span style="color: #DD0000">''w''</span><span style="color: #007700">); <br />  </span><span style="color: #0000BB">fwrite </span><span style="color: #007700">(</span><span style="color: #0000BB">$f</span><span style="color: #007700">, </span><span style="color: #0000BB">$data</span><span style="color: #007700">); <br /> </span><span style="color: #0000BB">fclose </span><span style="color: #007700">(</span><span style="color: #0000BB">$f</span><span style="color: #007700">); <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:24'),
(722, 52, '10. What should you do if your script is having problem recognizing file endings from a text file saved on a platform different from the one you’re reading it on?', '2012-06-25 14:49:24'),
(723, 52, '11. Which parameters would you pass to fopen() in order to open a file for reading and writing (Choose 2)?', '2012-06-25 14:49:24'),
(724, 52, '12. The function used to open a general-purpose file reference for reading and writing binary data in PHP is ________. The resource returned by it is used with functions such as fgets().', '2012-06-25 14:49:24'),
(725, 52, '13. Which of the following functions reads the entire contents of a file? (Choose 3)', '2012-06-25 14:49:24'),
(726, 52, '14. Which function is specifically designed to write a string to a text file?', '2012-06-25 14:49:24'),
(727, 52, '15. Consider the following script. When you run it, you obtain the output 1, 1, even though the file test.txt has been deleted by your call to unlink() as expected. Which function would you add before the last call to file_exists() to ensure that this problem will not repeat itself? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$f </span><span style="color: #007700">= </span><span style="color: #0000BB">fopen </span><span style="color: #007700">(</span><span style="color: #DD0000">"test.txt"</span><span style="color: #007700">, </span><span style="color: #DD0000">"w"</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">fwrite </span><span style="color: #007700">(</span><span style="color: #0000BB">$f</span><span style="color: #007700">, </span><span style="color: #DD0000">"test"</span><span style="color: #007700">); <br /></span><span style="color: #0000BB">fclose </span><span style="color: #007700">(</span><span style="color: #0000BB">$f</span><span style="color: #007700">); <br /> <br />echo (int) </span><span style="color: #0000BB">file_exists</span><span style="color: #007700">(</span><span style="color: #DD0000">"test.txt"</span><span style="color: #007700">) . </span><span style="color: #DD0000">'', ''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">unlink </span><span style="color: #007700">(</span><span style="color: #DD0000">"c:\\\\test.txt"</span><span style="color: #007700">); <br /> <br />echo (int) </span><span style="color: #0000BB">file_exists </span><span style="color: #007700">(</span><span style="color: #DD0000">"test.txt"</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:24'),
(728, 52, '16. The _______________ function determines whether a file can be written to.', '2012-06-25 14:49:24'),
(729, 52, '17. Which of the following function calls will cause a file pointer to be returned to the beginning of the file?', '2012-06-25 14:49:24'),
(730, 52, '18. What is the difference between stat() and fstat()?', '2012-06-25 14:49:24'),
(731, 52, '19. Which of the answers below best describes what the following script does? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">number_format </span><span style="color: #007700">(</span><span style="color: #0000BB">disk_free_space </span><span style="color: #007700">(</span><span style="color: #DD0000">''c:\\\\''</span><span style="color: #007700">) / <br />     </span><span style="color: #0000BB">disk_total_space</span><span style="color: #007700">(</span><span style="color: #DD0000">''c:\\\\''</span><span style="color: #007700">) * </span><span style="color: #0000BB">100</span><span style="color: #007700">, </span><span style="color: #0000BB">2</span><span style="color: #007700">) . </span><span style="color: #DD0000">''%''</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:24'),
(732, 52, '20. Assuming that image.jpg exists and is readable by PHP, how will the following script be displayed if called directly from a browser? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />header </span><span style="color: #007700">(</span><span style="color: #DD0000">"Content-type: image/jpeg"</span><span style="color: #007700">);<br /> <br /></span><span style="color: #0000BB">?&gt;<br /></span> <br /><span style="color: #0000BB">&lt;?php <br /> <br /> readfile </span><span style="color: #007700">(</span><span style="color: #DD0000">"image.jpg"</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:24'),
(733, 53, '1. What will the following script output on a Windows machine?<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">strtotime </span><span style="color: #007700">(</span><span style="color: #DD0000">"November 11, 1952"</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:25'),
(734, 53, '2. Which function can be used to format a local timestamp according to a specific locale?', '2012-06-25 14:49:25'),
(735, 53, '3. What does the following script do? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$a </span><span style="color: #007700">= </span><span style="color: #0000BB">array_sum </span><span style="color: #007700">(</span><span style="color: #0000BB">explode </span><span style="color: #007700">(</span><span style="color: #DD0000">'' ''</span><span style="color: #007700">, </span><span style="color: #0000BB">microtime</span><span style="color: #007700">())); <br /> <br />for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">10000</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++); <br /> <br /></span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">array_sum </span><span style="color: #007700">(</span><span style="color: #0000BB">explode </span><span style="color: #007700">(</span><span style="color: #DD0000">'' ''</span><span style="color: #007700">, </span><span style="color: #0000BB">microtime</span><span style="color: #007700">())); <br /> <br />echo </span><span style="color: #0000BB">$b </span><span style="color: #007700">- </span><span style="color: #0000BB">$a</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(736, 53, '4. What function name should replace the question marks in the following script?\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">for (</span><span style="color: #0000BB">$i </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; </span><span style="color: #0000BB">$i </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">100</span><span style="color: #007700">; </span><span style="color: #0000BB">$i</span><span style="color: #007700">++) { <br />  </span><span style="color: #0000BB">$day </span><span style="color: #007700">= </span><span style="color: #0000BB">rand </span><span style="color: #007700">(</span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">31</span><span style="color: #007700">); <br />  </span><span style="color: #0000BB">$month </span><span style="color: #007700">= </span><span style="color: #0000BB">rand </span><span style="color: #007700">(</span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">12</span><span style="color: #007700">); <br />  </span><span style="color: #0000BB">$year </span><span style="color: #007700">= </span><span style="color: #0000BB">rand </span><span style="color: #007700">(</span><span style="color: #0000BB">1000</span><span style="color: #007700">, </span><span style="color: #0000BB">2500</span><span style="color: #007700">); <br />  <br /> if (????????? (</span><span style="color: #0000BB">$month</span><span style="color: #007700">, </span><span style="color: #0000BB">$day</span><span style="color: #007700">, </span><span style="color: #0000BB">$year</span><span style="color: #007700">)) { <br />    echo </span><span style="color: #DD0000">"</span><span style="color: #0000BB">$month</span><span style="color: #DD0000">/</span><span style="color: #0000BB">$day</span><span style="color: #DD0000">/</span><span style="color: #0000BB">$year</span><span style="color: #DD0000"> is a valid date\\n"</span><span style="color: #007700">; <br /> } else { <br />    echo </span><span style="color: #DD0000">"</span><span style="color: #0000BB">$month</span><span style="color: #DD0000">/</span><span style="color: #0000BB">$day</span><span style="color: #DD0000">/</span><span style="color: #0000BB">$year</span><span style="color: #DD0000"> is not a valid date\\n"</span><span style="color: #007700">; <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(737, 53, '5. What will the following script output on a Windows machine? (Choose 2) \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">mktime </span><span style="color: #007700">(</span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">11</span><span style="color: #007700">, </span><span style="color: #0000BB">11</span><span style="color: #007700">, </span><span style="color: #0000BB">1952</span><span style="color: #007700">); </span><span style="color: #FF8000">// November 11, 1952 <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(738, 53, '6. Keeping into consideration that the EST time zone is one hour ahead of the CST time zone (that is, at any given time it will be one hour later in EST than in CST), what will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$a </span><span style="color: #007700">= </span><span style="color: #0000BB">strtotime </span><span style="color: #007700">(</span><span style="color: #DD0000">''00:00:00 Feb 23 1976 EST''</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">$b </span><span style="color: #007700">= </span><span style="color: #0000BB">strtotime </span><span style="color: #007700">(</span><span style="color: #DD0000">''00:00:00 Feb 23 1976 CST''</span><span style="color: #007700">); <br /> <br />echo </span><span style="color: #0000BB">$a </span><span style="color: #007700">- </span><span style="color: #0000BB">$b</span><span style="color: #007700">; <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(739, 53, '7. When retrieving and manipulating date values from a database, which of the following techniques will help prevent bugs? (Choose 3)', '2012-06-25 14:49:25'),
(740, 53, '8. What would happen if the following script were run on a Windows server set to Moscow, Russia’s time zone?\n\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">gmmktime</span><span style="color: #007700">(</span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">0</span><span style="color: #007700">, </span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">1</span><span style="color: #007700">, </span><span style="color: #0000BB">1970</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(741, 53, '9. Which of the following definitions describes the time function?', '2012-06-25 14:49:25'),
(742, 53, '10. What will the following script output?\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$time </span><span style="color: #007700">= </span><span style="color: #0000BB">strtotime </span><span style="color: #007700">(</span><span style="color: #DD0000">''2004/01/01''</span><span style="color: #007700">); <br /> <br />echo </span><span style="color: #0000BB">date </span><span style="color: #007700">(</span><span style="color: #DD0000">''H:\\i:s''</span><span style="color: #007700">, </span><span style="color: #0000BB">$time</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:25'),
(743, 53, '11. Which of the following expressions will make a cookie expire in exactly one hour (assuming that the client machine on which the browser is set to the correct time and time zone—and that it resides in a time zone different from your server’s)?', '2012-06-25 14:49:25'),
(744, 53, '12. The getdate() function returns ______________.', '2012-06-25 14:49:25'),
(745, 53, '13. What is the simplest way of transforming the output of microtime() into a single numeric value?', '2012-06-25 14:49:25'),
(746, 53, '14. Which of the following functions do not return a timestamp? (Choose 2)', '2012-06-25 14:49:25'),
(747, 53, '15. What is the difference, in seconds, between the current timestamp in the GMT time zone and the current timestamp in your local time zone?', '2012-06-25 14:49:25'),
(748, 54, '1. Which one of the following is not a valid e-mail address?', '2012-06-25 14:49:26'),
(749, 54, '2. In PHP, the way e-mail is sent from a Windows- or Novell-based machine is different when compared to the behaviour of a UNIX-based machine that uses the sendmail application. In which of the following ways does it differ? (Choose 2):', '2012-06-25 14:49:26'),
(750, 54, '3. Which of the following steps would you need to undertake if you wanted to send e-mails to multiple recipients or MIME compatible e-mails from PHP?', '2012-06-25 14:49:26'),
(751, 54, '4. When sending e-mails that have file attachments using MIME (multi-part e-mails), the body of the message and the attachment must be separated by a special string called a boundary. What MIME e-mail header defines this boundary?', '2012-06-25 14:49:26'),
(752, 54, '5. When sending HTML e-mail using MIME, it is often desirable to use classic HTML tags such as &lt;IMG&gt; to embed images within your text. Which of the following methods are acceptable for doing so? (Choose 2)', '2012-06-25 14:49:26'),
(753, 54, '6. Under which of the following conditions can the fifth (last) parameter of the mail function, called $additional_parameters, be used?', '2012-06-25 14:49:26'),
(754, 54, '7. Under which of the following circumstances is the Content-Transfer-Encoding MIME header used?', '2012-06-25 14:49:26'),
(755, 54, '8. Which of the following hold true for MIME boundaries specified by the boundary field in a Content-Type header? (Choose 3)', '2012-06-25 14:49:26'),
(756, 54, '9. Consider the following e-mail: \n \n<code>From: John Coggeshall &lt;john@php.net&gt;\nTo: Joe User &lt;joe@example.comt&gt;\nSubject: Hello from John!\nDate: Wed, 20 Dec 2004 20:18:47 -0400\nMessage-ID: &lt;1234@local.machine.example&gt;\n\nHello, How are you?</code>\n\nWhat headers must be added to this e-mail to make it a MIME e-mail? (Select all that apply)', '2012-06-25 14:49:26'),
(757, 54, '10. Which MIME content type would be used to send an e-mail that contains HTML, rich text, and plain text versions of the same message so that the e-mail client will choose the most appropriate version?', '2012-06-25 14:49:26'),
(758, 54, '11. What do you need to do in order for the mail function to work under Windows, assuming that sendmail is not installed on your machine?', '2012-06-25 14:49:26'),
(759, 54, '12. Which of the following measures will help prevent cross-site attacks on a form that sends a pre-defined text-only e-mail to a user-provided e-mail address? (Choose 2)', '2012-06-25 14:49:26'),
(760, 54, '13. How would you manipulate an array so that it can be sent as an attachment to an e-mail and then reconstructed when the e-mail is received?', '2012-06-25 14:49:26'),
(761, 54, '14. Which of the following is the best way to determine the content type of a file that you want to embed in a MIME/multipart e-mail?', '2012-06-25 14:49:26'),
(762, 54, '15. In an UNIX environment that makes use of a local sendmail installation, how would you ensure that your script will be able to arbitrarily set the sender’s name and address in an e-mail? (Choose 3)', '2012-06-25 14:49:26'),
(763, 55, '1. Consider the following SQL statement. Which of the following could be good ideas for limiting the amount of data returned by it? (Choose 2)\n\n<code>SELECT * FROM MY_TABLE </code>', '2012-06-25 14:49:27'),
(764, 55, '2. The dataset returned by a query can be filtered by adding a ________ clause to it.', '2012-06-25 14:49:27'),
(765, 55, '3. What does an “inner join” construct do?', '2012-06-25 14:49:27'),
(766, 55, '4. Which of the following DBMSs do not have a native PHP extension?', '2012-06-25 14:49:27'),
(767, 55, '5. Consider the following script. Assuming that the mysql_query function sends an unfiltered query to a database connection already established elsewhere, which of the following are true? (Choose 2) \n\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />$r </span><span style="color: #007700">= </span><span style="color: #0000BB">mysql_query </span><span style="color: #007700">(</span><span style="color: #DD0000">''DELETE FROM MYTABLE WHERE ID='' </span><span style="color: #007700">. </span><span style="color: #0000BB">$_GET</span><span style="color: #007700">[</span><span style="color: #DD0000">''ID''</span><span style="color: #007700">]); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:27'),
(768, 55, '6. The ___________ statement can be used to add a new row to an existing table.', '2012-06-25 14:49:27'),
(769, 55, '7. Which of the following is true?', '2012-06-25 14:49:27'),
(770, 55, '8. Can joins be nested?', '2012-06-25 14:49:27'),
(771, 55, '9. Consider the following database table and query. Which of the indexes below will help speed up the process of executing the query? \n \n<code>CREATE TABLE MYTABLE ( \n  ID     INT, \n  NAME   VARCHAR (100), \n  ADDRESS1   VARCHAR (100), \n  ADDRESS2  VARCHAR (100), \n  ZIPCODE  VARCHAR (10), \n  CITY    VARCHAR (50), \n  PROVINCE  VARCHAR (2) \n) \n \nSELECT ID, VARCHAR \nFROM MYTABLE \nWHERE ID BETWEEN 0 AND 100 \nORDER BY NAME, ZIPCODE</code>', '2012-06-25 14:49:27'),
(772, 55, '10. What will happen at the end of the following sequence of SQL commands? \n \n<code>BEGIN TRANSACTION \n \nDELETE FROM MYTABLE WHERE ID=1 \nDELETE FROM OTHERTABLE \n \nROLLBACK TRANSACTION </code>', '2012-06-25 14:49:27'),
(773, 55, '11. What does the DESC keyword do in the following query? \n \n<code>SELECT * \nFROM MY_TABLE \nWHERE ID &gt; 0 \nORDER BY ID, NAME DESC</code>', '2012-06-25 14:49:27'),
(774, 55, '12. Which of the following is not an SQL aggregate function?', '2012-06-25 14:49:27'),
(775, 55, '13. Which of the following correctly identify the requirements for a column to be part of the result set of a query that contains a GROUP BY clause?', '2012-06-25 14:49:27'),
(776, 55, '14. What will the following query output? \n\n<code>SELECT COUNT(*) FROM TABLE1 INNER JOIN TABLE2 \nON TABLE1.ID &lt;&gt; TABLE2.ID </code>', '2012-06-25 14:49:27'),
(777, 55, '15. _____________ are used to treat sets of SQL statements atomically.', '2012-06-25 14:49:27'),
(778, 56, '1. Which of the following is not a valid PHP file wrapper resource?', '2012-06-25 14:49:28'),
(779, 56, '2. What function can you use to create your own streams using the PHP stream wrappers and register them within PHP?', '2012-06-25 14:49:28'),
(780, 56, '3. The Stream API provides all but which of the following pieces of information using the stream_get_meta_data function?', '2012-06-25 14:49:28'),
(781, 56, '4. Which of the following are valid PHP stream transports? (Choose 2)', '2012-06-25 14:49:28'),
(782, 56, '5. The stream context provides information about the data being transported over a given stream and can be used to pass configuration options to which of the following aspects of the stream? (Choose 2)', '2012-06-25 14:49:28'),
(783, 56, '6. What function would you use to open a socket connection manually with the purpose of communicating with a server not supported by a file wrapper?', '2012-06-25 14:49:28'),
(784, 56, '7. Which of the following network transports doesn’t PHP support?', '2012-06-25 14:49:28'),
(785, 56, '8. Assume that you are attempting to communicate with a server that periodically sends data to you over the tcp network transport. The intervals at which this data is sent cannot be predicted, yet you must process it as soon as it arrives. Your script must also perform actions in between data transmissions from the server. When you write your script, you find that it often hangs on the call to fread() if the server takes too long to respond and your other actions aren’t being executed properly. How can this problem be fixed?', '2012-06-25 14:49:28'),
(786, 56, '9. When dealing with timeout values in sockets, the connection timeout can be changed independently of the read/write time out. Which function must be used for this purpose?', '2012-06-25 14:49:28'),
(787, 56, '10. Assume that you would like to write a script that reads plain-text data from an arbitrary stream and writes it back to a second stream ROT13-encoded. The encoding must be performed as you are writing to the second stream. What approach would be best suited for these purposes?', '2012-06-25 14:49:28'),
(788, 56, '11. What will the following script output? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">long2ip </span><span style="color: #007700">(</span><span style="color: #0000BB">ip2long </span><span style="color: #007700">(</span><span style="color: #DD0000">''127.0.256''</span><span style="color: #007700">)); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:28'),
(789, 56, '12. What will the following script do? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">getservbyname </span><span style="color: #007700">(</span><span style="color: #DD0000">''ftp''</span><span style="color: #007700">, </span><span style="color: #DD0000">''tcp''</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:28'),
(790, 56, '13. What does the gethostbynamel function do?', '2012-06-25 14:49:28'),
(791, 56, '14. Which of the following operations cannot be performed using the standard ftp:// stream wrapper? (Choose 2)', '2012-06-25 14:49:28'),
(792, 56, '15. How do you create a custom stream handler?', '2012-06-25 14:49:28'),
(793, 57, '1. Which of the following is the single most important technique that can help you make your PHP application secure from external intrusion?', '2012-06-25 14:49:28');
INSERT INTO `quiz_questions` (`id`, `topic_id`, `text`, `date_create`) VALUES
(794, 57, '2. Consider the following code snippet. Is this code acceptable from a security standpoint? Assume that the $action and $data variables are designed to be accepted from the user and  register_globals is enabled. \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php<br /> <br />    </span><span style="color: #007700">if(</span><span style="color: #0000BB">isUserAdmin</span><span style="color: #007700">()) { </span><span style="color: #0000BB">$isAdmin </span><span style="color: #007700">= </span><span style="color: #0000BB">true</span><span style="color: #007700">; } <br /> <br />    </span><span style="color: #0000BB">$data </span><span style="color: #007700">= </span><span style="color: #0000BB">validate_and_return_input</span><span style="color: #007700">(</span><span style="color: #0000BB">$data</span><span style="color: #007700">); <br /> <br />    switch(</span><span style="color: #0000BB">$action</span><span style="color: #007700">) <br />    { <br />        case </span><span style="color: #DD0000">''add''</span><span style="color: #007700">: <br />             </span><span style="color: #0000BB">addSomething</span><span style="color: #007700">(</span><span style="color: #0000BB">$data</span><span style="color: #007700">); <br />             break; <br /> <br />        case </span><span style="color: #DD0000">''delete''</span><span style="color: #007700">: <br />             if(</span><span style="color: #0000BB">$isAdmin</span><span style="color: #007700">) { <br />                 </span><span style="color: #0000BB">deleteSomething</span><span style="color: #007700">(</span><span style="color: #0000BB">$data</span><span style="color: #007700">); <br />             } <br />             break; <br /> <br />        case </span><span style="color: #DD0000">''edit''</span><span style="color: #007700">: <br />             if(</span><span style="color: #0000BB">$isAdmin</span><span style="color: #007700">) { <br />                 </span><span style="color: #0000BB">editSomething</span><span style="color: #007700">(</span><span style="color: #0000BB">$data</span><span style="color: #007700">); <br />             } <br />            break; <br /> <br />         default:  <br />             print </span><span style="color: #0000BB">“Bad Action</span><span style="color: #007700">.</span><span style="color: #0000BB">”</span><span style="color: #007700">; <br />    } <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:29'),
(795, 57, '3. To prevent cross-site scripting attacks, one should do the following (Choose 3):', '2012-06-25 14:49:29'),
(796, 57, '4. Although the best practice is to disable register_globals entirely, if it must be enabled, what should your scripts do to prevent malicious users from compromising their security?', '2012-06-25 14:49:29'),
(797, 57, '5. Often, SQL queries are constructed based on data taken from the user (for instance, a search engine). Which of the following activities can help prevent security breaches?', '2012-06-25 14:49:29'),
(798, 57, '6. Sometimes, it is desirable to use a third-party utility from within a PHP script to perform operations that the language does not support internally (for instance, calling a compression program to compress a file using a format that PHP does not provide an extension for). When executing system commands from PHP scripts, which of the following functions should always be used to ensure no malicious commands are injected? (Choose 2)', '2012-06-25 14:49:29'),
(799, 57, '7. When dealing with files uploaded through HTTP, PHP stores references to them in the $_FILES superglobal array. These files must be processed or moved from their temporary location during the lifetime of the PHP script execution or they will be automatically deleted. What should be done to ensure that, when performing manipulations on a file uploaded from HTTP, the file being accessed is indeed the correct file? (Choose 2)', '2012-06-25 14:49:29'),
(800, 57, '8. In PHP’s “Safe Mode,” what can configuration directives do to help reduce security risks? (Choose 3)', '2012-06-25 14:49:29'),
(801, 57, '9. Which of the following actions represents the simplest solution, both from an implementation and maintenance standpoint, to limiting script access to the filesystem to a specific set of directories?', '2012-06-25 14:49:29'),
(802, 57, '10. When uploading a file, is there a way to ensure that the client browser will disallow sending a document larger than a certain size?', '2012-06-25 14:49:29'),
(803, 57, '11. Your web server runs PHP as a CGI interpreter with Apache on your Linux machine in the cgi-bin directory, in which it is marked as executable. What happens if someone opens the following URL on your site? \n \n<code>/cgi-bin/php?/etc/passwd</code>', '2012-06-25 14:49:29'),
(804, 57, '12. Although not necessarily foolproof, what of the following can help identify and prevent potential security risks in your code? (Choose the most appropriate answer)', '2012-06-25 14:49:29'),
(805, 57, '13. When an error occurs on your web site, how should it be treated?', '2012-06-25 14:49:29'),
(806, 57, '14. Under what circumstances can the following code be considered secure? \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />    $newfunc </span><span style="color: #007700">= </span><span style="color: #0000BB">create_function</span><span style="color: #007700">(</span><span style="color: #DD0000">''$a''</span><span style="color: #007700">, </span><span style="color: #DD0000">"return </span><span style="color: #0000BB">$a</span><span style="color: #DD0000"> * </span><span style="color: #007700">{</span><span style="color: #0000BB">$_POST</span><span style="color: #007700">[</span><span style="color: #DD0000">''number''</span><span style="color: #007700">]}</span><span style="color: #DD0000">;"</span><span style="color: #007700">); <br /> <br />    </span><span style="color: #0000BB">$newfunc</span><span style="color: #007700">(</span><span style="color: #0000BB">10</span><span style="color: #007700">); <br /> <br /></span><span style="color: #0000BB">?&gt;</span> </span>\n</code>', '2012-06-25 14:49:29'),
(807, 57, '15. Which of the following PHP setups presents the highest number of potential security pitfalls and the lowest performance?', '2012-06-25 14:49:29'),
(808, 58, '1. Which of the ternary operations below is the equivalent of this script?\n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br /></span><span style="color: #007700">if (</span><span style="color: #0000BB">$a </span><span style="color: #007700">&lt; </span><span style="color: #0000BB">10</span><span style="color: #007700">) { <br />  if (</span><span style="color: #0000BB">$b </span><span style="color: #007700">&gt; </span><span style="color: #0000BB">11</span><span style="color: #007700">) { <br />    if (</span><span style="color: #0000BB">$c </span><span style="color: #007700">== </span><span style="color: #0000BB">10 </span><span style="color: #007700">&amp;&amp; </span><span style="color: #0000BB">$d </span><span style="color: #007700">!= </span><span style="color: #0000BB">$c</span><span style="color: #007700">) { <br />   </span><span style="color: #0000BB">$x </span><span style="color: #007700">= </span><span style="color: #0000BB">0</span><span style="color: #007700">; <br />  } else { <br />   </span><span style="color: #0000BB">$x </span><span style="color: #007700">= </span><span style="color: #0000BB">1</span><span style="color: #007700">; <br />  } <br /> } <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:30'),
(809, 58, '2. Which of the following measures can help improving the performance of a script that is slow due to the fact that it needs to pull data from a remote source that is not under your control? (Choose 2)', '2012-06-25 14:49:30'),
(810, 58, '3. Which of the following are good steps to undertake when setting up a production webserver? (Choose 2)', '2012-06-25 14:49:30'),
(811, 58, '4. The __________ operator makes comparisons stricter by checking the types of its operands against each other.', '2012-06-25 14:49:30'),
(812, 58, '5. What does an opcode cache do?', '2012-06-25 14:49:30'),
(813, 58, '6. Which of the following could result in resource starvation? (Choose 2)', '2012-06-25 14:49:30'),
(814, 58, '7. What’s missing from the following script? (Choose 2) \n \n<code><span style="color: #000000">\n<span style="color: #0000BB">&lt;?php <br /> <br />$rs </span><span style="color: #007700">= </span><span style="color: #0000BB">database_query </span><span style="color: #007700">(</span><span style="color: #DD0000">"select * from mytable where id = " </span><span style="color: #007700">. <br />                      </span><span style="color: #0000BB">$my_id</span><span style="color: #007700">); <br /> <br />while (</span><span style="color: #0000BB">$a </span><span style="color: #007700">= </span><span style="color: #0000BB">database_get_data </span><span style="color: #007700">(</span><span style="color: #0000BB">$rs</span><span style="color: #007700">)) { <br /> </span><span style="color: #0000BB">var_dump </span><span style="color: #007700">(</span><span style="color: #0000BB">$a</span><span style="color: #007700">); <br />} <br /> <br /></span><span style="color: #0000BB">?&gt;</span>\n</span>\n</code>', '2012-06-25 14:49:30'),
(815, 58, '8. Which of the following error types cannot be caught by setting up a custom error handler? (Select two)', '2012-06-25 14:49:30'),
(816, 58, '9. When comparing a constant value against a variable, what is a good way to ensure that you will not mistakenly perform an assignment instead?', '2012-06-25 14:49:30'),
(817, 58, '10. What is the easiest way to send an error message to a systems administrator via e-mail?', '2012-06-25 14:49:30'),
(818, 58, '11. Can you turn off all error reporting from within a script with a single PHP function call?', '2012-06-25 14:49:30'),
(819, 58, '12. What is the role of a profiler?', '2012-06-25 14:49:30'),
(820, 58, '13. A ____________ can help identify and solve bugs.', '2012-06-25 14:49:30'),
(821, 58, '14. What is the difference between trigger_error() and user_error()?', '2012-06-25 14:49:30'),
(822, 58, '15. The _______________ function can be used to retrieve the sequence of code function calls that led to the execution of an arbitrary line of code in a script. This function is often used for debugging purposes to determine how errors occur.', '2012-06-25 14:49:30');

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_results`
--

DROP TABLE IF EXISTS `quiz_results`;
CREATE TABLE IF NOT EXISTS `quiz_results` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
  `quiz_id` int(11) unsigned NOT NULL COMMENT 'Тест',
  `date_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата начала',
  `date_finish` timestamp NULL DEFAULT NULL COMMENT 'Дата окончания',
  `status` enum('process','finished') NOT NULL DEFAULT 'process' COMMENT 'Статус',
  PRIMARY KEY (`id`),
  KEY `quiz` (`quiz_id`),
  KEY `user` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `quiz_id`, `date_start`, `date_finish`, `status`) VALUES
(1, 1, 2, '2012-06-27 13:20:13', NULL, 'process');

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_topics`
--

DROP TABLE IF EXISTS `quiz_topics`;
CREATE TABLE IF NOT EXISTS `quiz_topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `name` varchar(100) NOT NULL COMMENT 'Название',
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `parent_id_name` (`parent_id`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Дамп данных таблицы `quiz_topics`
--

INSERT INTO `quiz_topics` (`id`, `parent_id`, `name`, `date_create`) VALUES
(1, NULL, 'PHP', '2012-06-19 13:19:54'),
(47, 1, 'PHP Programming Basics', '2012-06-25 14:49:18'),
(48, 1, 'Object-oriented Programming with PHP 4', '2012-06-25 14:49:19'),
(49, 1, 'PHP as a Web Development Language', '2012-06-25 14:49:20'),
(50, 1, 'Working with Arrays', '2012-06-25 14:49:21'),
(51, 1, 'Strings and Regular Expressions', '2012-06-25 14:49:22'),
(52, 1, 'Manipulating Files and the Filesystem', '2012-06-25 14:49:23'),
(53, 1, 'Date and Time Management', '2012-06-25 14:49:24'),
(54, 1, 'E-mail Handling and Manipulation', '2012-06-25 14:49:25'),
(55, 1, 'Database Programming with PHP', '2012-06-25 14:49:26'),
(56, 1, 'Stream and Network Programming', '2012-06-25 14:49:27'),
(57, 1, 'Writing Secure PHP Applications', '2012-06-25 14:49:28'),
(58, 1, 'Debugging Code and Managing Performance', '2012-06-25 14:49:29'),
(59, NULL, 'MySQL', '2012-06-26 11:49:11'),
(60, 59, 'Inno DB', '2012-06-26 11:49:22'),
(61, 59, 'Myisam', '2012-06-26 11:49:40');

-- --------------------------------------------------------

--
-- Структура таблицы `quiz_topics_rels`
--

DROP TABLE IF EXISTS `quiz_topics_rels`;
CREATE TABLE IF NOT EXISTS `quiz_topics_rels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quiz_id_topic_id` (`quiz_id`,`topic_id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- Дамп данных таблицы `quiz_topics_rels`
--

INSERT INTO `quiz_topics_rels` (`id`, `quiz_id`, `topic_id`) VALUES
(66, 2, 50),
(65, 2, 51),
(67, 2, 57);

-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

DROP TABLE IF EXISTS `ratings`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

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

-- --------------------------------------------------------

--
-- Структура таблицы `records`
--

DROP TABLE IF EXISTS `records`;
CREATE TABLE IF NOT EXISTS `records` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `descr` text,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '0',
  `index_text` text,
  `second_title` text,
  `title` text,
  `sidebar_text` text,
  `portfolio_work_type_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `activity` int(11) DEFAULT NULL,
  `text` text,
  `result_url` varchar(255) DEFAULT NULL,
  `result_title` varchar(255) DEFAULT NULL,
  `service` text,
  `icon` varchar(255) DEFAULT NULL,
  `icon_big` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `updaetd` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `records`
--

INSERT INTO `records` (`record_id`, `sort`, `alias`, `category_id`, `descr`, `month`, `year`, `published`, `index_text`, `second_title`, `title`, `sidebar_text`, `portfolio_work_type_id`, `city_id`, `activity`, `text`, `result_url`, `result_title`, `service`, `icon`, `icon_big`, `img`, `updaetd`, `created`) VALUES
(1, 2, 'companyPi', 135, NULL, 9, 2011, 1, '<p>Мы писали, рисовали и верстали, забивали - наши пальчики устали!</p>', 'Сайт зафигачили для ПиКомпании!', 'Сайт "{more}Компании Пи...{/more}"', '<p>xxx: ТИИИИИИИИИХА В ЛЕСУ<br />xxx: только не спииииит совааааааа<br />xxx: ставит сова на видюху дрова, вот и не спииит соваааа</p>', NULL, 1, NULL, '<p>Узнаете места? Верно, теперь Панорамы улиц добрались до Кирова, Иркутска, Курска, Ярославля и даже известного в Украине туристического центра &ndash; Каменца-Подольского.<img style="display: block; margin-left: auto; margin-right: auto;" src="../../images/imgdat/04a0ff12ef2caa6df46cb1d8282_prev.jpg" alt="" width="590" height="425" /><br /><br />Теперь можно разглядеть со всех сторон церковь Иоанна Предтечи в Ярославле (известную не только благодаря своей красоте, но и изображению на тысячерублевой купюре) и пройтись мимо церкви св.Георгия или Триумфальной арки в Курске. Погрузиться в атмосферу позапрошлого века на перекрестке улиц Дрелевского и Большевиков в Кирове, а после прогуляться по пешеходной улице в Иркутске, совмещающей архитектуру 19 века и современные магазины. И даже заглянуть внутрь старинной крепости в Каменце-Подольском!<br /><br />Куда отправиться дальше &ndash; решать вам. Выбирайте интересные места для прогулок с помощью списка городов.</p>', 'pi.ru', 'www.pi.ru', NULL, 'b153.jpg', 'pr1.jpg', NULL, '2011-07-09 07:36:08', '0000-00-00 00:00:00'),
(14, 3, 'weqwe', 135, NULL, 11, 2009, 1, '<p>sdfsdfs</p>', 'asdsad', 'sdfdsfsdf', '<p>sdfsdfsdfsdf</p>', 1, 1, NULL, '<p>sdfdsf</p>', 'fsdfsd', '342423', NULL, NULL, NULL, NULL, '2011-08-13 15:35:07', '2011-06-21 16:19:26'),
(15, 4, NULL, 135, NULL, 10, 2005, 1, '<p>Я рад рассказать о том, что Microsoft в сотрудничестве с Joyent предоставит ресурсы для портирования Node на Windows. Как вы уже могли слышать ранее в этом году, мы начали работу над нативным портом на Windows &mdash; с целью использовать высокопроизводительный IOCP API.<br /><br /> Эта работа требует в значительной степени модифицировать базовую структуру и мы очень рады тому, что теперь получаем официальное руководство и инженерные ресурсы от Microsoft. От Rackspace так же выделено время Bert Belder для выполнения этой работы.<br /><br /> Результатом будет официальный бинарный релиз node.exe опубликованный на nodejs.org, который будет работать на Windows Azure и других версиях Windows начиная с Windows Server 2003.</p>', 'Сайт для финпола', 'Сайт (линк)Финпола(/линк)', '<p>Перевод статьи Влада Савова (Vlad Savov) из блога Engadget. Это его авторская колонка и подразумевает личное мнение журналиста.</p>', 2, 1, NULL, '<p>После ивента Google Inside Search на прошлой неделе старший вице-президент Google по поиску Алан Юстас немного рассказал о том, что главный исполнительный директор Ларри Пейдж думает о поиске.<br /><br /> Вот некоторые долгосрочные цели:<br />Ответы, а не просто результаты. Пейдж недоволен тем, что Google по запросу предоставляет только набор разрозненных ссылок, и хочет, чтобы поисковая система предоставляла более организованные и последовательные результаты. Например, по запросу &laquo;какой лучший способ создать скафандр?&raquo; Google могла бы показывать набор обучающих видео, а затем компании, которые могут предоставить материалы, инженерные ресурсы и так далее для выполнения задачи.</p>', 'finpol.kz', 'finpol.kz', NULL, 'b1.jpg', 'shit.jpg', 'IMG_116664.JPG', '2011-07-05 11:43:27', '2011-06-24 10:55:38');

-- --------------------------------------------------------

--
-- Структура таблицы `site_actions`
--

DROP TABLE IF EXISTS `site_actions`;
CREATE TABLE IF NOT EXISTS `site_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Пользователь',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `module` varchar(50) NOT NULL COMMENT 'Модуль',
  `controller` varchar(50) NOT NULL COMMENT 'Контроллер',
  `action` varchar(50) NOT NULL COMMENT 'Действие',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `sphinx_view_content`
--
DROP VIEW IF EXISTS `sphinx_view_content`;
CREATE TABLE IF NOT EXISTS `sphinx_view_content` (
`id` varbinary(16)
,`title` varchar(200)
,`user_id` int(11)
,`text` text
);
-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(43, ' Тег2'),
(21, '1112'),
(24, '221312'),
(22, '23213213'),
(6, '34t34'),
(5, '34t43t'),
(4, '4tw4t'),
(3, 'adaw'),
(27, 'awd'),
(28, 'awdaw'),
(36, 'Behaviors'),
(30, 'd'),
(32, 'dadw'),
(1, 'dadwad'),
(18, 'dawd'),
(23, 'dawd2'),
(33, 'dawdawdaw'),
(29, 'dawdd'),
(40, 'dawddawd'),
(19, 'dawdwad'),
(25, 'dawsd'),
(34, 'dccccc'),
(20, 'ddd'),
(31, 'dwadwdaw'),
(2, 'dwd'),
(37, 'Models'),
(38, 'MySQL'),
(39, 'PHP5'),
(26, 'wdawd'),
(35, 'Yii'),
(8, 'в'),
(14, 'Введите тэгифцвф'),
(11, 'вфц'),
(16, 'вфцв'),
(17, 'вфцвфв'),
(10, 'вц'),
(7, 'вцвц'),
(12, 'вывцй'),
(41, 'Тег1'),
(42, 'Тег2'),
(15, 'ф'),
(9, 'фц'),
(13, 'фцвф');

-- --------------------------------------------------------

--
-- Структура таблицы `tags_rels`
--

DROP TABLE IF EXISTS `tags_rels`;
CREATE TABLE IF NOT EXISTS `tags_rels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `model_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_id` (`tag_id`,`object_id`,`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=400 ;

--
-- Дамп данных таблицы `tags_rels`
--

INSERT INTO `tags_rels` (`id`, `tag_id`, `object_id`, `model_id`) VALUES
(72, 41, 34, 'Page'),
(357, 41, 35, 'Page'),
(360, 41, 239, 'Page'),
(362, 41, 240, 'Page'),
(364, 41, 241, 'Page'),
(366, 41, 242, 'Page'),
(368, 41, 243, 'Page'),
(370, 41, 244, 'Page'),
(372, 41, 245, 'Page'),
(374, 41, 246, 'Page'),
(376, 41, 247, 'Page'),
(378, 41, 248, 'Page'),
(380, 41, 249, 'Page'),
(382, 41, 250, 'Page'),
(384, 41, 251, 'Page'),
(386, 41, 252, 'Page'),
(388, 41, 253, 'Page'),
(390, 41, 254, 'Page'),
(392, 41, 255, 'Page'),
(394, 41, 256, 'Page'),
(396, 41, 257, 'Page'),
(398, 41, 258, 'Page'),
(73, 42, 34, 'Page'),
(358, 42, 35, 'Page'),
(361, 42, 239, 'Page'),
(363, 42, 240, 'Page'),
(365, 42, 241, 'Page'),
(367, 42, 242, 'Page'),
(369, 42, 243, 'Page'),
(371, 42, 244, 'Page'),
(373, 42, 245, 'Page'),
(375, 42, 246, 'Page'),
(377, 42, 247, 'Page'),
(379, 42, 248, 'Page'),
(381, 42, 249, 'Page'),
(383, 42, 250, 'Page'),
(385, 42, 251, 'Page'),
(387, 42, 252, 'Page'),
(389, 42, 253, 'Page'),
(391, 42, 254, 'Page'),
(393, 42, 255, 'Page'),
(395, 42, 256, 'Page'),
(397, 42, 257, 'Page'),
(399, 42, 258, 'Page');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`, `module`) VALUES
('m000000_000000_base_fileManager', 1342855036, 'fileManager'),
('m120603_143144_add_albums', 1342855036, 'fileManager'),
('m000000_000000_base_comments', 1342855036, 'comments'),
('m120701_004346_comments_create', 1342855036, 'comments'),
('m000000_000000_base_content', 1342855036, 'content'),
('m120701_004612_pages_create', 1342855036, 'content'),
('m120701_004620_pages_sections_create', 1342855036, 'content'),
('m120701_004626_pages_sections_rels_create', 1342855037, 'content'),
('m120701_004651_menu_create', 1342855037, 'content'),
('m120701_004658_menu_sections_create', 1342855037, 'content'),
('m000000_000000_base_mailer', 1342855037, 'mailer'),
('m120701_005013_mailer_outbox_create', 1342855037, 'mailer'),
('m120701_005105_mailer_templates_create', 1342855252, 'mailer'),
('m000000_000000_base_main', 1342855252, 'main'),
('m120701_005157_feedback_create', 1342855252, 'main'),
('m120701_005219_languages_create', 1342856425, 'main'),
('m120701_005225_languages_messages_create', 1342856344, 'main'),
('m120701_005231_languages_translations_create', 1342856344, 'main'),
('m120701_005242_log_create', 1342856344, 'main'),
('m120701_005251_meta_tags_create', 1342856344, 'main'),
('m120701_005259_params_create', 1342856344, 'main'),
('m120701_005307_site_actions_create', 1342856344, 'main'),
('m000000_000000_base_social', 1342856344, 'social'),
('m120701_005352_favorites_create', 1342856344, 'social'),
('m120701_005357_ratings_create', 1342856344, 'social'),
('m000000_000000_base_tags', 1342856344, 'tags'),
('m120701_005414_tags_create', 1342856344, 'tags'),
('m120701_005423_tags_rels_create', 1342856344, 'tags'),
('m000000_000000_base_users', 1342856344, 'users'),
('m120701_005441_users_create', 1342857853, 'users'),
('m120710_232834_friends_create', 1342857853, 'social'),
('m120711_215433_labels_create', 1342857853, 'social'),
('m120711_215440_labels_rels_create', 1342857853, 'social'),
('m120808_103857_longer_password', 1345290956, 'users');

-- --------------------------------------------------------

--
-- Структура таблицы `templates_blocks_widgets_relations`
--

DROP TABLE IF EXISTS `templates_blocks_widgets_relations`;
CREATE TABLE IF NOT EXISTS `templates_blocks_widgets_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) DEFAULT NULL,
  `widget_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `templates_blocks_widgets_relations`
--

INSERT INTO `templates_blocks_widgets_relations` (`id`, `block_id`, `widget_id`) VALUES
(1, 2, 1),
(2, 3, 2),
(3, 2, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `template_blocks`
--

DROP TABLE IF EXISTS `template_blocks`;
CREATE TABLE IF NOT EXISTS `template_blocks` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(50) DEFAULT NULL,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `template_blocks`
--

INSERT INTO `template_blocks` (`block_id`, `alias`, `json_settings`, `published`, `category_id`) VALUES
(1, 'header', '{}', 0, 1),
(2, 'content', '{}', 0, 1),
(3, 'left', NULL, 0, 1),
(33, 'header', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `template_widgets`
--

DROP TABLE IF EXISTS `template_widgets`;
CREATE TABLE IF NOT EXISTS `template_widgets` (
  `widget_id` int(11) NOT NULL AUTO_INCREMENT,
  `json_settings` text,
  `published` tinyint(1) DEFAULT '0',
  `class` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `template_widgets`
--

INSERT INTO `template_widgets` (`widget_id`, `json_settings`, `published`, `class`, `title`) VALUES
(1, '{}', 1, 'MainContent', 'Главный контент'),
(2, '{"alias":"main","title":"Главное меню"}', 1, 'Menu', 'Менюшка'),
(10, '{}', 1, 'Dummy', 'Текст');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT 'Имя',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `password` varchar(60) NOT NULL COMMENT 'Пароль',
  `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
  `gender` enum('man','woman') DEFAULT NULL COMMENT 'Пол',
  `status` enum('active','new','blocked') DEFAULT 'new' COMMENT 'Статус',
  `photo` varchar(50) DEFAULT NULL COMMENT 'Фото',
  `activate_code` varchar(32) DEFAULT NULL COMMENT 'Код активации',
  `activate_date` timestamp NULL DEFAULT NULL COMMENT 'Дата активации',
  `password_recover_code` varchar(32) DEFAULT NULL,
  `password_recover_date` timestamp NULL DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `birthdate`, `gender`, `status`, `photo`, `activate_code`, `activate_date`, `password_recover_code`, `password_recover_date`, `date_create`) VALUES
(1, 'Иван', 'admin@ya.ru', 'e10adc3949ba59abbe56e057f20f883e', '2003-05-20', 'man', 'active', NULL, '070a63ae33af0eb7986992e774dc53e8', '2011-05-21 09:18:39', NULL, NULL, '2011-05-19 00:25:50'),
(2, 'artos1', 'artem-moscow@yandex.ru', 'ce75287f5b0f666d015f6cd86003bcc6', NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, '2012-05-19 16:05:24'),
(3, '', 'www.pismeco@gmail.com', '$2a$12$I02MSYzrOlTmNR5ts1kVa.bP9MupSk7j.QaVZrXc4asJZ23pmw7AK', NULL, NULL, 'active', NULL, NULL, '2012-08-18 11:55:09', NULL, NULL, '2012-05-19 16:05:24');

-- --------------------------------------------------------

--
-- Структура для представления `sphinx_view_content`
--
DROP TABLE IF EXISTS `sphinx_view_content`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sphinx_view_content` AS (select concat('page_',`t`.`id`) AS `id`,`t`.`title` AS `title`,NULL AS `user_id`,`t`.`text` AS `text` from `pages` `t`) union (select concat('page_',`t`.`id`) AS `id`,`t`.`title` AS `title`,`t`.`user_id` AS `user_id`,`t`.`text` AS `text` from `pages` `t`);
