#
# Структура для таблицы `documents`: 
#

CREATE TABLE `documents` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `name` VARCHAR(500) COLLATE utf8_general_ci NOT NULL COMMENT 'Наименование',
  `desc` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Описание',
  `is_published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Опубликовано',
  `date_publish` DATE NOT NULL COMMENT 'Дата публикации',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

