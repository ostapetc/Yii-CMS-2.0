-- 
-- Structure for table `languages`
-- 

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` char(2) NOT NULL COMMENT 'ID',
  `name` varchar(15) NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `languages`
-- 

INSERT INTO `languages` (`id`, `name`) VALUES
  ('en', 'english'),
  ('ru', 'русский');

-- 
-- Structure for table `languages_messages`
-- 

DROP TABLE IF EXISTS `languages_messages`;
CREATE TABLE IF NOT EXISTS `languages_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) NOT NULL COMMENT 'Категория',
  `message` text NOT NULL COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8;

-- 
-- Data for table `languages_messages`
-- 

INSERT INTO `languages_messages` (`id`, `category`, `message`) VALUES
  ('1', 'main', 'Скрыть'),
  ('156', 'main', 'Управление страницами'),
  ('157', 'main', 'Добавление страницы'),
  ('158', 'main', 'Просмотр страницы'),
  ('159', 'main', 'Редактирование страницы'),
  ('160', 'main', 'Удаление страницы'),
  ('161', 'main', 'Получение данных страницы (JSON)'),
  ('162', 'main', 'Система'),
  ('163', 'main', 'Страницы сайта'),
  ('164', 'main', 'Язык'),
  ('165', 'main', 'Заголовок'),
  ('166', 'main', 'Адрес'),
  ('167', 'main', 'Текст'),
  ('168', 'main', 'Опубликована'),
  ('169', 'main', 'Создана'),
  ('170', 'main', 'Да'),
  ('171', 'main', 'Админ панель'),
  ('172', 'main', 'На сайт'),
  ('173', 'main', 'Выйти'),
  ('174', 'main', 'Быстрый поиск'),
  ('175', 'main', 'Контент'),
  ('176', 'main', 'Список страниц'),
  ('177', 'main', 'Добавить страницу'),
  ('178', 'main', 'Блоки страниц'),
  ('179', 'main', 'Добавить блок'),
  ('180', 'main', 'Управление меню'),
  ('181', 'main', 'Добавить меню'),
  ('182', 'main', 'Мета-теги'),
  ('183', 'main', 'Добавить мета-тег'),
  ('184', 'main', 'Логирование'),
  ('185', 'main', 'Действия сайта'),
  ('186', 'main', 'Обратная связь'),
  ('187', 'main', 'Языки'),
  ('188', 'main', 'Добавить язык'),
  ('189', 'main', 'Настройки'),
  ('190', 'main', 'Пользователи'),
  ('191', 'main', 'Все пользователи '),
  ('192', 'main', 'Добавить пользователя'),
  ('193', 'main', 'показать'),
  ('194', 'main', 'Главное'),
  ('195', 'main', 'Главная'),
  ('196', 'main', 'Новости'),
  ('197', 'main', 'Разработчики'),
  ('198', 'main', 'Инструменты'),
  ('199', 'main', 'Обзор'),
  ('200', 'main', 'Документация'),
  ('201', 'main', 'Языковые сообщения'),
  ('202', 'main', 'Языковые переводы'),
  ('203', 'main', 'Добавить Языковые сообщения'),
  ('204', 'main', 'Языки (сообщения)'),
  ('205', 'main', 'Языки (сообщения) добавить'),
  ('206', 'main', 'Языки (переводы)'),
  ('207', 'main', 'Языки (добавить перевод)'),
  ('208', 'main', 'Главная страница'),
  ('209', 'main', 'Редактировать'),
  ('210', 'main', 'View details');

-- 
-- Structure for table `languages_translations`
-- 

DROP TABLE IF EXISTS `languages_translations`;
CREATE TABLE IF NOT EXISTS `languages_translations` (
  `id` int(11) NOT NULL,
  `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
  `translation` text COMMENT 'Перевод',
  PRIMARY KEY (`id`,`language`),
  KEY `language` (`language`),
  CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `languages_messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Data for table `languages_translations`
-- 

INSERT INTO `languages_translations` (`id`, `language`, `translation`) VALUES
  ('162', 'en', 'System'),
  ('175', 'en', 'Content'),
  ('176', 'en', 'Pages list'),
  ('177', 'en', 'Create page'),
  ('178', 'en', 'Page blocks'),
  ('179', 'en', 'Create page block'),
  ('180', 'en', 'Manage menu'),
  ('181', 'en', 'Ceate menu'),
  ('182', 'en', 'Meta tags'),
  ('183', 'en', 'Add meta tag'),
  ('184', 'en', 'Logging'),
  ('185', 'en', 'Site actions'),
  ('186', 'en', 'Feedback'),
  ('187', 'en', 'Languages'),
  ('188', 'en', 'Add language'),
  ('189', 'en', 'Settings'),
  ('196', 'en', 'News');

