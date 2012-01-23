#
# Структура для таблицы `ymarket_sections`: 
#

CREATE TABLE `ymarket_sections` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Название',
  `yandex_name` VARCHAR(100) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Название(Яндекс)',
  `url` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'URL',
  `all_models_url` VARCHAR(250) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'URL на все модели',
  `brands_url` VARCHAR(250) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'URL на производителей',
  `breadcrumbs` TEXT COLLATE utf8_general_ci COMMENT 'Путь',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  `date_update` DATETIME DEFAULT NULL COMMENT 'Дата обновления',
  `date_brand_update` DATETIME DEFAULT NULL COMMENT 'Дата обновления брендов',
  `date_pages_parse` DATETIME DEFAULT NULL COMMENT 'Дата парсинга страниц',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `url` USING BTREE (`url`) COMMENT '',
  UNIQUE INDEX `yandex_name` USING BTREE (`yandex_name`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=4 AVG_ROW_LENGTH=5461 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `ymarket_sections` table  (LIMIT -496,500)
#

INSERT INTO `ymarket_sections` (`id`, `name`, `yandex_name`, `url`, `all_models_url`, `brands_url`, `breadcrumbs`, `date_create`, `date_update`, `date_brand_update`, `date_pages_parse`) VALUES

  (1,'Ноутбуки','Ноутбуки','http://market.yandex.ru/catalogmodels.xml?CAT_ID=432460&hid=91013','/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=432460-EXC=1-PG=10&hid=91013','/vendors.xml?CAT_ID=432460&hid=91013','<a class=\"b-breadcrumbs__link\" href=\"/catalog.xml?hid=91009\">Компьютеры</a>','2011-09-13 20:10:16','2011-09-21 15:56:08','2011-09-21 15:57:01','2011-09-21 15:59:15'),
  (2,NULL,'Сотовые телефоны','http://market.yandex.ru/catalogmodels.xml?CAT_ID=160043&hid=91491','/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=160043-EXC=1-PG=10&hid=91491','/vendors.xml?CAT_ID=160043&hid=91491','<a class=\"b-breadcrumbs__link\" href=\"/catalog.xml?hid=91461\">Телефоны</a>','2011-09-13 20:11:04','2011-09-21 15:56:10','2011-09-21 15:57:09','2011-09-21 17:37:32'),
  (3,NULL,'Планшеты','http://market.yandex.ru/catalogmodels.xml?CAT_ID=6427101&hid=6427100','/guru.xml?CMD=-RR=0,0,0,0-VIS=160-CAT_ID=6427101-EXC=1-PG=10&hid=6427100','/vendors.xml?CAT_ID=6427101&hid=6427100','<a class=\"b-breadcrumbs__link\" href=\"/catalog.xml?hid=91009\">Компьютеры</a>','2011-09-20 20:18:16','2011-09-21 15:56:11','2011-09-21 15:57:18','2011-09-21 15:59:45');
COMMIT;

