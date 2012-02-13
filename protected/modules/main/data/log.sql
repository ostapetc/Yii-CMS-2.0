#
# Структура для таблицы `log`: 
#

CREATE TABLE `log` (
  `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `level` VARCHAR(128) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Тип',
  `category` VARCHAR(128) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Категория',
  `logtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время',
  `message` TEXT COLLATE utf8_general_ci COMMENT 'Сообщение',
  PRIMARY KEY USING BTREE (`id`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

