#
# Структура для таблицы `cities`: 
#

CREATE TABLE `cities` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=22 AVG_ROW_LENGTH=1170 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `cities` table  (LIMIT -485,500)
#

INSERT INTO `cities` (`id`, `name`) VALUES

  (3,'Москва'),
  (4,'Санкт-Петербург'),
  (5,'Новосибирск'),
  (6,'Екатеринбург'),
  (7,'Нижний Новгород'),
  (8,'Самара'),
  (9,'Омск'),
  (10,'Казань'),
  (11,'Челябинск'),
  (12,'Ростов-на-Дону'),
  (13,'Волгоград'),
  (17,'Ялта'),
  (20,'Майями'),
  (21,'Симферополь');
COMMIT;

