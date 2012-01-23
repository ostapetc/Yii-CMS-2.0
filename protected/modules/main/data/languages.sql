#
# Структура для таблицы `languages`: 
#

CREATE TABLE `languages` (
  `id` CHAR(2) COLLATE utf8_general_ci NOT NULL COMMENT 'ID',
  `name` VARCHAR(15) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `languages` table  (LIMIT -497,500)
#

INSERT INTO `languages` (`id`, `name`) VALUES

  ('en','english'),
  ('ru','русский');
COMMIT;

