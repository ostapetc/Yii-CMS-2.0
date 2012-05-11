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

CREATE TABLE IF NOT EXISTS `site_actions2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Пользователь',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `module` varchar(50) NOT NULL COMMENT 'Модуль',
  `controller` varchar(50) NOT NULL COMMENT 'Контроллер',
  `action` varchar(50) NOT NULL COMMENT 'Действие',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




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
(210, 'main', 'View details'),
(212, 'main', 'Часто задаваемые вопросы'),
(213, 'main', 'Добавление вопроса'),
(214, 'main', 'задать вопрос'),
(215, 'main', 'Разделы'),
(216, 'main', 'В данном разделе вопросы отсутствуют!'),
(217, 'main', 'Вопрос'),
(218, 'main', 'Ответ'),
(219, 'main', 'Ваш вопрос успешно добавлен'),
(233, 'main', 'Подробнее'),
(234, 'main', 'ПОСЛЕДНИЕ НОВОСТИ'),
(235, 'main', 'Все новости'),
(236, 'main', 'Сохранить'),
(237, 'main', 'Отмена'),
(238, 'main', 'Название'),
(239, 'main', 'Сортировка'),
(240, 'main', 'Показывать на странице');

CREATE TABLE IF NOT EXISTS `languages_translations` (
  `id` int(11) NOT NULL,
  `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
  `translation` text COMMENT 'Перевод',
  PRIMARY KEY (`id`,`language`),
  UNIQUE KEY `id_language` (`id`,`language`),
  KEY `language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages_translations`
--

INSERT INTO `languages_translations` (`id`, `language`, `translation`) VALUES
(1, 'de', NULL),
(1, 'en', 'Hide'),
(156, 'de', NULL),
(156, 'en', 'Manage page'),
(157, 'de', NULL),
(157, 'en', 'Create page'),
(158, 'de', NULL),
(158, 'en', 'View page'),
(160, 'de', NULL),
(160, 'en', 'Delete page'),
(161, 'de', NULL),
(161, 'en', 'Get page JSON data'),
(162, 'de', 'Apparat'),
(162, 'en', 'System'),
(163, 'de', 'Site-Seiten'),
(163, 'en', 'Site pages\r\n'),
(164, 'de', NULL),
(164, 'en', 'Language'),
(165, 'de', NULL),
(165, 'en', 'Title'),
(166, 'de', NULL),
(166, 'en', 'Addess'),
(167, 'de', NULL),
(167, 'en', 'Text'),
(168, 'de', NULL),
(168, 'en', 'Published'),
(169, 'de', NULL),
(169, 'en', 'Created'),
(170, 'de', NULL),
(170, 'en', 'Yes'),
(171, 'de', NULL),
(171, 'en', 'Admin Panel'),
(172, 'de', NULL),
(172, 'en', 'Go to site'),
(173, 'de', NULL),
(173, 'en', 'Exit'),
(174, 'de', NULL),
(174, 'en', 'Quick search'),
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
(190, 'de', NULL),
(190, 'en', 'Users'),
(192, 'de', NULL),
(192, 'en', 'Create user'),
(193, 'de', NULL),
(193, 'en', 'show'),
(194, 'de', NULL),
(194, 'en', 'Base'),
(195, 'de', NULL),
(195, 'en', 'Main'),
(196, 'en', 'News'),
(197, 'de', NULL),
(197, 'en', 'Developers'),
(200, 'de', NULL),
(200, 'en', 'Documentation'),
(202, 'de', NULL),
(202, 'en', 'Languages translations'),
(203, 'de', NULL),
(203, 'en', 'Create language message'),
(204, 'de', NULL),
(204, 'en', 'Languages (messages)'),
(205, 'de', NULL),
(205, 'en', 'Languages (create message)'),
(206, 'de', NULL),
(206, 'en', 'Languages (translations)'),
(207, 'de', NULL),
(207, 'en', 'Languages (add translation)'),
(208, 'de', NULL),
(208, 'en', 'Main page'),
(209, 'de', NULL),
(209, 'en', 'Edit'),
(212, 'en', 'Faq'),
(213, 'en', 'Add a question'),
(214, 'en', 'ask a question'),
(215, 'en', 'Categories'),
(216, 'en', 'In this section, no questions!'),
(217, 'en', 'Question'),
(218, 'en', 'Answer'),
(219, 'en', 'Your question has been successfully added'),
(233, 'en', 'More'),
(234, 'en', 'LATEST NEWS'),
(235, 'en', 'All news'),
(236, 'de', NULL),
(236, 'en', 'Save'),
(237, 'de', NULL),
(237, 'en', 'Cancel'),
(238, 'de', NULL),
(238, 'en', 'Name'),
(239, 'de', NULL),
(239, 'en', 'Sorting'),
(240, 'de', NULL),
(240, 'en', 'Items on page');


--
-- Constraints for dumped tables
--

ALTER TABLE `site_actions2`
  ADD CONSTRAINT `site_actions_ibfk_1123` FOREIGN KEY (`user_id`) REFERENCES `users2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Constraints for table `languages_translations`
--

ALTER TABLE `languages_translations`
  ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `languages_messages` (`id`) ON DELETE CASCADE;
