#
# Структура для таблицы `documents_files`: 
#

CREATE TABLE `documents_files` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `document_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Документ',
  `title` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `file` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Файл',
  `created_at` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `document_id` USING BTREE (`document_id`) COMMENT '',
  CONSTRAINT `documents_files_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

