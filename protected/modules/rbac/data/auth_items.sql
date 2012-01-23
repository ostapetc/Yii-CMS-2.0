#
# Структура для таблицы `auth_items`: 
#

CREATE TABLE `auth_items` (
  `name` VARCHAR(64) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `type` INTEGER(11) NOT NULL COMMENT 'Тип',
  `description` TEXT COLLATE utf8_general_ci COMMENT 'Описание',
  `bizrule` TEXT COLLATE utf8_general_ci COMMENT 'Бизнес-правило',
  `data` TEXT COLLATE utf8_general_ci COMMENT 'Данные',
  `allow_for_all` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Доступно всем',
  PRIMARY KEY USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AVG_ROW_LENGTH=585 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
