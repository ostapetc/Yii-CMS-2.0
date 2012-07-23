SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

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
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` char(2) NOT NULL COMMENT 'ID',
  `name` varchar(15) NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
('de', 'Dutch'),
('en', 'English'),
('ru', 'Русский');


CREATE TABLE IF NOT EXISTS `languages_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) NOT NULL DEFAULT 'main' COMMENT 'Категория',
  `message` text NOT NULL COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=241 ;



--
-- Dumping data for table `languages_messages`
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


CREATE TABLE `log` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `level` VARCHAR(128) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Тип',
  `category` VARCHAR(128) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Категория',
  `logtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время',
  `message` TEXT COLLATE utf8_general_ci COMMENT 'Сообщение',
  PRIMARY KEY USING BTREE (`id`)
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;


CREATE TABLE `settings` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модуль',
  `code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Код',
  `name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Значение',
  `element` ENUM('text','textarea','editor') COLLATE utf8_general_ci NOT NULL COMMENT 'Элемент',
  `hidden` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Скрыта',
  PRIMARY KEY USING BTREE (`id`),
  UNIQUE INDEX `const` USING BTREE (`code`),
  UNIQUE INDEX `title` USING BTREE (`name`)
)ENGINE=InnoDB
AUTO_INCREMENT=25 AVG_ROW_LENGTH=910 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;


--
-- Table structure for table `meta_tags`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Table structure for table `languages_translations`
--

CREATE TABLE IF NOT EXISTS `languages_translations` (
  `id` int(11) NOT NULL,
  `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
  `translation` text COMMENT 'Перевод',
  PRIMARY KEY (`id`,`language`),
  KEY `language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages_translations`
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
--
-- Constraints for dumped tables
--
--
-- Constraints for table `languages_translations`
--

ALTER TABLE `languages_translations`
  ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `languages_messages` (`id`) ON DELETE CASCADE;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;