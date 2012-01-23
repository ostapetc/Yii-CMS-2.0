#
# Структура для таблицы `auth_objects`: 
#

CREATE TABLE `auth_objects` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `object_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Объект',
  `model_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модель',
  `role` VARCHAR(64) COLLATE utf8_general_ci NOT NULL COMMENT 'Роль',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `role` USING BTREE (`role`) COMMENT '',
  CONSTRAINT `auth_objects_ibfk_1` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=28 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

