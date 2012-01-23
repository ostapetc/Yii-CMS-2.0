#
# Структура для таблицы `ymarket_crons`: 
#

CREATE TABLE `ymarket_crons` (
  `id` INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `method` VARCHAR(100) COLLATE utf8_general_ci NOT NULL COMMENT 'Метод',
  `is_active` TINYINT(1) NOT NULL COMMENT 'Активен',
  `priority` TINYINT(1) NOT NULL COMMENT 'Приоритет',
  `interval` INTEGER(11) NOT NULL COMMENT 'Интервал (в сек.)',
  `date_of` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата работы',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `method` USING BTREE (`method`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=5 AVG_ROW_LENGTH=8192 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `ymarket_crons` table  (LIMIT -497,500)
#

INSERT INTO `ymarket_crons` (`id`, `name`, `method`, `is_active`, `priority`, `interval`, `date_of`) VALUES

  (3,'Парсинг страниц с продуктами','ParsePages',1,3,10,'2011-09-21 17:37:34'),
  (4,'Парсинг продуктов','ParseProducts',1,4,1,'2011-09-21 15:59:56');
COMMIT;

