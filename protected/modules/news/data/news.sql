#
# Структура для таблицы `news`: 
#

CREATE TABLE `news` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `user_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Автор',
  `title` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `text` LONGTEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст',
  `photo` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Фото',
  `state` ENUM('active','hidden') COLLATE utf8_general_ci NOT NULL COMMENT 'Состояние',
  `date` DATE NOT NULL COMMENT 'Дата',
  `date_create` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `user_id` USING BTREE (`user_id`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=14 AVG_ROW_LENGTH=2730 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

