DROP TABLE IF EXISTS `pages_blocks`;
CREATE TABLE IF NOT EXISTS `pages_blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` char(2) DEFAULT NULL COMMENT 'Язык',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `name` varchar(50) NOT NULL COMMENT 'Название (англ.)',
  `text` longtext NOT NULL COMMENT 'Текст',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  CONSTRAINT `pages_blocks_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

