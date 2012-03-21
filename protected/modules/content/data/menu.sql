#
# Структура для таблицы `menu`: 
#

CREATE TABLE `menu` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `is_visible` TINYINT(1) NOT NULL COMMENT 'Отображать',
  PRIMARY KEY USING BTREE (`id`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=7 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
