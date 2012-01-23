#
# Структура для таблицы `mailer_templates`: 
#

CREATE TABLE `mailer_templates` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `subject` VARCHAR(150) COLLATE utf8_general_ci NOT NULL COMMENT 'Тема письма',
  `text` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст письма',
  `is_basic` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Основной',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

