#
# Структура для таблицы `certificates_types`: 
#

CREATE TABLE `certificates_types` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'Тип',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=10 AVG_ROW_LENGTH=1820 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
