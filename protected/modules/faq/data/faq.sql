#
# Структура для таблицы `faq`: 
#

CREATE TABLE `faq` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `lang` CHAR(2) COLLATE utf8_general_ci DEFAULT 'ru' COMMENT 'Язык',
  `first_name` VARCHAR(40) COLLATE utf8_general_ci NOT NULL COMMENT 'Имя',
  `last_name` VARCHAR(40) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` VARCHAR(40) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Отчество',
  `company` VARCHAR(80) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Компания',
  `position` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Должность',
  `phone` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Телефон',
  `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL COMMENT 'Email',
  `section_id` INTEGER(11) NOT NULL COMMENT 'Раздел',
  `question` LONGTEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Вопрос',
  `answer` LONGTEXT COLLATE utf8_general_ci COMMENT 'Ответ',
  `is_published` INTEGER(1) NOT NULL DEFAULT 0 COMMENT 'Опубликовано',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добалено',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `section_id` USING BTREE (`section_id`) COMMENT '',
   INDEX `date` USING BTREE (`date_create`) COMMENT '',
   INDEX `lang` USING BTREE (`lang`) COMMENT '',
  CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `faq_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `faq_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

