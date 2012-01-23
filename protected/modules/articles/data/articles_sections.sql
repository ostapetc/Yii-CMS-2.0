CREATE TABLE `articles_sections` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `parent_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Родитель',
  `name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  `in_sidebar` INTEGER(1) NOT NULL DEFAULT 0 COMMENT 'разместить на главной странице',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT '',
   INDEX `parent_id` USING BTREE (`parent_id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `articles_sections_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `articles_sections` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `articles_sections_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=2 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
