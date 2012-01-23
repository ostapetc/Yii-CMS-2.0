#
# Структура для таблицы `meta_tags`: 
#

CREATE TABLE `meta_tags` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `object_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'ID объекта',
  `model_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Модель',
  `title` VARCHAR(300) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Заголовок',
  `keywords` VARCHAR(300) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Ключевые слова',
  `description` VARCHAR(300) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Описание',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  `date_update` DATETIME DEFAULT NULL COMMENT 'Отредактирован',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `object_id` USING BTREE (`object_id`, `model_id`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=9 AVG_ROW_LENGTH=4096 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `meta_tags` table  (LIMIT -495,500)
#

INSERT INTO `meta_tags` (`id`, `object_id`, `model_id`, `title`, `keywords`, `description`, `date_create`, `date_update`) VALUES

  (5,2,'Page','111','3333','222','2011-10-19 17:25:04',NULL),
  (6,17,'Page','45','567','67','2011-10-19 17:25:17',NULL),
  (7,1,'Page','www','rtyrtyry','trfyhr','2011-10-19 17:25:29',NULL),
  (8,3,'News','zzzz','keyww','oppp','2011-10-20 13:10:13','2011-10-20 13:12:40');
COMMIT;

