SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

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


--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `language`, `title`, `url`, `text`, `is_published`, `date_create`, `order`) VALUES
(1, 'ru', 'Главная страница', '/', '<p>Yii &mdash; это высокоэффективный основанный на компонентной структуре PHP-фреймворк для     разработки масштабных веб-приложений. Он позволяет максимально применить концепцию повторного     использования кода и может существенно ускорить процесс веб-разработки. Название Yii     (произносится как Yee или [ji:]) означает простой (easy), эффективный (efficient) и расширяемый     (extensible).</p>', 1, '2011-06-25 13:23:15', 19),
(3, 'en', 'Main page', '/', '<p><strong>Yii</strong> is pronounced as Yee or [ji:], and is an acroynym for "<strong>Yes It Is!</strong>". This is often the accurate, and most concise response to inquires from those new to Yii: <br />Is it fast? ... Is it secure? ... Is it professional? ... Is it right for my next project? ... <strong>Yes, it is!</strong></p>\r\n<p>Yii is a free, open-source Web application development framework written in PHP5 that promotes clean, <a rel="nofollow" href="http://en.wikipedia.org/wiki/Don%27t_repeat_yourself">DRY</a> design and encourages rapid development. It works to streamline your  application development and helps to ensure an extremely efficient,  extensible, and maintainable end product.</p>\r\n<p>Being extremely performance optimized, Yii is a perfect choice for  any sized project. However, it has been built with sophisticated,  enterprise applications in mind. You have full control over the  configuration from head-to-toe (presentation-to-persistence) to conform  to your enterprise development guidelines. It comes packaged with tools  to help test and debug your application, and has clear and comprehensive  documentation.</p>\r\n<p>To learn more about what Yii brings to the table, check out the <a href="http://www.yiiframework.com/features/">features section</a>.</p>', 1, '2011-09-10 21:00:53', 20);

-- --------------------------------------------------------

--
-- Constraints for table `menu_sections`
--
ALTER TABLE `menu_sections`
  ADD CONSTRAINT `menu_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_sections_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;




SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;