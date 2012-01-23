CREATE TABLE `actions` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `name` VARCHAR(500) COLLATE utf8_general_ci NOT NULL COMMENT 'Наименование',
  `place` VARCHAR(900) COLLATE utf8_general_ci NOT NULL COMMENT 'Место проведения',
  `desc` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Описание события',
  `image` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Фото',
  `date` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Дата проведения',
  `date_create` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

