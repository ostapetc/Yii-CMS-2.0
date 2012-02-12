#
# Структура для таблицы `settings`: 
#

CREATE TABLE `settings` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модуль',
  `code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Код',
  `name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Заголовок',
  `value` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Значение',
  `element` ENUM('text','textarea','editor') COLLATE utf8_general_ci NOT NULL COMMENT 'Элемент',
  `hidden` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Скрыта',
  PRIMARY KEY USING BTREE (`id`),
  UNIQUE INDEX `const` USING BTREE (`code`),
  UNIQUE INDEX `title` USING BTREE (`name`)
)ENGINE=InnoDB
AUTO_INCREMENT=25 AVG_ROW_LENGTH=910 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;





