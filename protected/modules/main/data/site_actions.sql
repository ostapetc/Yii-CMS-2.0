set foreign_key_checks = 0;

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


ALTER TABLE `site_actions2`
  ADD CONSTRAINT `site_actions_ibfk_1123` FOREIGN KEY (`user_id`) REFERENCES `users2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
