#
# Структура для таблицы `auth_assignments`: 
#

CREATE TABLE `auth_assignments` (
  `itemname` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  `userid` INTEGER(11) UNSIGNED NOT NULL,
  `bizrule` TEXT COLLATE utf8_general_ci,
  `data` TEXT COLLATE utf8_general_ci,
  PRIMARY KEY USING BTREE (`itemname`, `userid`) COMMENT '',
   INDEX `userid` USING BTREE (`userid`) COMMENT '',
  CONSTRAINT `auth_assignments_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignments_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

