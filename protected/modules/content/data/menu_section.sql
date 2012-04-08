#
# Структура для таблицы `menu_sections`:
#

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE 'utf8_general_ci' AUTO_INCREMENT=1 COMMENT='';


INSERT INTO `menu_sections` (`id`, `lang`, `page_id`, `menu_id`, `root`, `left`, `right`, `level`, `title`, `url`, `module_url`, `module_id`, `is_published`, `is_new`) VALUES
(19, 'ru', NULL, 10, 19, 1, 136, 1, 'Верхнее меню::корень', '', NULL, NULL, 0, NULL),
(32, 'ru', NULL, 10, 19, 2, 3, 2, 'Новости', '/', '/news/news/index', 'news', 1, NULL)
;