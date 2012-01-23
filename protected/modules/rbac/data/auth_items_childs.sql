#
# Структура для таблицы `auth_items_childs`: 
#

CREATE TABLE `auth_items_childs` (
  `parent` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  `child` VARCHAR(64) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY USING BTREE (`parent`, `child`) COMMENT '',
   INDEX `child` USING BTREE (`child`) COMMENT '',
  CONSTRAINT `auth_items_childs_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_items_childs_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AVG_ROW_LENGTH=131 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
