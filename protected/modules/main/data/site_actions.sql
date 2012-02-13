#
# Структура для таблицы `site_actions`: 
#

CREATE TABLE `site_actions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Пользователь',
  `object_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'ID объекта',
  `title` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `module` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модуль',
  `controller` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Контроллер',
  `action` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Действие',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `user_id` USING BTREE (`user_id`) COMMENT '',
  CONSTRAINT `site_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

