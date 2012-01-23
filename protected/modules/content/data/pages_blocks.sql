#
# Структура для таблицы `pages_blocks`: 
#

CREATE TABLE `pages_blocks` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `title` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Название (англ.)',
  `text` LONGTEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `lang_2` USING BTREE (`lang`, `title`) COMMENT '',
  UNIQUE INDEX `lang_3` USING BTREE (`lang`, `name`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `pages_blocks_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=6 AVG_ROW_LENGTH=4096 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
