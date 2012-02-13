#
# Структура для таблицы `banners`: 
#

CREATE TABLE `banners` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Раздел сайта',
  `name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Название',
  `image` VARCHAR(37) COLLATE utf8_general_ci NOT NULL COMMENT 'Изображение',
  `url` VARCHAR(500) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'URL-адрес',
  `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Активен',
  `priority` INTEGER(11) NOT NULL DEFAULT 0 COMMENT 'Приоритет',
  `date_start` DATE DEFAULT NULL COMMENT 'Дата начала показа',
  `date_end` DATE DEFAULT NULL COMMENT 'Дата окончания показа',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `page_id` USING BTREE (`page_id`) COMMENT '',
  CONSTRAINT `banners_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=20 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

