#
# Структура для таблицы `file_manager`: 
#

CREATE TABLE `file_manager` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `object_id` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'ID объекта',
  `model_id` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Модель',
  `name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Файл',
  `path` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Путь до файла',
  `tag` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Тег',
  `title` TEXT COLLATE utf8_general_ci COMMENT 'Название',
  `descr` TEXT COLLATE utf8_general_ci COMMENT 'Описание',
  `order` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Порядок',
  PRIMARY KEY USING BTREE (`id`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=12 AVG_ROW_LENGTH=1489 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
