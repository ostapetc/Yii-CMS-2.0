#
# Структура для таблицы `pages`: 
#

CREATE TABLE `pages` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `title` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `url` VARCHAR(250) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Адрес',
  `text` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст',
  `is_published` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Опубликована',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=18 AVG_ROW_LENGTH=3276 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
