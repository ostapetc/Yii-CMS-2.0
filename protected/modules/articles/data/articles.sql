#
# Структура для таблицы `articles`: 
#

CREATE TABLE `articles` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `section_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Раздел',
  `title` VARCHAR(400) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `text` LONGTEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст',
  `date` DATE NOT NULL COMMENT 'Дата',
  `date_create` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `section_id` USING BTREE (`section_id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `articles_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=3 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
