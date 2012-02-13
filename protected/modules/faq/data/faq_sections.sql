#
# Структура для таблицы `faq_sections`: 
#

CREATE TABLE `faq_sections` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `name` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `is_published` INTEGER(1) NOT NULL DEFAULT 0 COMMENT 'Опубликован',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `faq_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

