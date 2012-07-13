#
# Структура для таблицы `auth_items`:
#

CREATE TABLE IF NOT EXISTS `auth_items` (
  `name` VARCHAR(64) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `type` INTEGER(11) NOT NULL COMMENT 'Тип',
  `description` TEXT COLLATE utf8_general_ci COMMENT 'Описание',
  `bizrule` TEXT COLLATE utf8_general_ci COMMENT 'Бизнес-правило',
  `data` TEXT COLLATE utf8_general_ci COMMENT 'Данные',
  `allow_for_all` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Доступно всем',
  PRIMARY KEY USING BTREE (`name`)
)ENGINE=InnoDB
AVG_ROW_LENGTH=585 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;


#
# Структура для таблицы `auth_assignments`:
#

CREATE TABLE IF NOT EXISTS  `auth_assignments` (
  `itemname` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  `userid` INTEGER(11) UNSIGNED NOT NULL,
  `bizrule` TEXT COLLATE utf8_general_ci,
  `data` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY USING BTREE (`itemname`, `userid`),
   INDEX `userid` USING BTREE (`userid`),
  CONSTRAINT `auth_assignments_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignments_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Структура для таблицы `auth_items_childs`:
#

CREATE TABLE IF NOT EXISTS  `auth_items_childs` (
  `parent` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  `child` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY USING BTREE (`parent`, `child`),
   INDEX `child` USING BTREE (`child`),
  CONSTRAINT `auth_items_childs_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_items_childs_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AVG_ROW_LENGTH=131 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;


CREATE TABLE IF NOT EXISTS  `auth_objects` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `object_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Объект',
  `model_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модель',
  `role` VARCHAR(64) COLLATE utf8_general_ci NOT NULL COMMENT 'Роль',
  PRIMARY KEY USING BTREE (`id`),
   INDEX `role` USING BTREE (`role`),
  CONSTRAINT `auth_objects_ibfk_1` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=28 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

