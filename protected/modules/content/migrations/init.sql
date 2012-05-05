--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  `lang` varchar(2) DEFAULT NULL COMMENT 'Язык',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `is_published`, `lang`) VALUES
(1, 'Верхнее меню', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_sections`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `menu_sections`
--

INSERT INTO `menu_sections` (`id`, `lang`, `page_id`, `menu_id`, `root`, `left`, `right`, `level`, `title`, `url`, `module_url`, `module_id`, `is_published`) VALUES
(1, 'ru', NULL, 1, 1, 1, 8, 1, 'Верхнее меню::корень', '', NULL, NULL, 0);


--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
  `text` text NOT NULL COMMENT 'Текст',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Опубликована',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_language_fk` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Constraints for table `menu_sections`
--
ALTER TABLE `menu_sections`
  ADD CONSTRAINT `menu_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_sections_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
