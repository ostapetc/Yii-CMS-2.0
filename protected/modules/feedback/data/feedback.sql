#
# Структура для таблицы `feedback`: 
#

CREATE TABLE `feedback` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(40) COLLATE utf8_general_ci NOT NULL COMMENT 'Имя',
  `last_name` VARCHAR(40) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` VARCHAR(40) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Отчество',
  `company` VARCHAR(80) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Компания',
  `position` VARCHAR(40) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Должность',
  `phone` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Телефон',
  `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL COMMENT 'Email',
  `comment` VARCHAR(1000) COLLATE utf8_general_ci NOT NULL COMMENT 'Комментарий',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY USING BTREE (`id`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=17 AVG_ROW_LENGTH=1024 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `feedback` table  (LIMIT -483,500)
#

INSERT INTO `feedback` (`id`, `first_name`, `last_name`, `patronymic`, `company`, `position`, `phone`, `email`, `comment`, `date_create`) VALUES

  (1,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:13:31'),
  (2,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:15:47'),
  (3,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:15:55'),
  (4,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:16:39'),
  (5,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:17:02'),
  (6,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:21:32'),
  (7,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:22:39'),
  (8,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:23:13'),
  (9,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:23:34'),
  (10,'dawdawd','dawda','awdaw','dawdawd','awdawd','+7-903-5492969','dwad@mail.ru','awd','2011-09-11 23:25:31'),
  (11,'вфцв','вфцв','фцвфцв','фцвфцв','фцвфцвф','+7-903-5492969','ada@mail.ru','dadaw','2011-09-13 01:06:53'),
  (12,'wadaw','dawd','dwad','awdawd','dawddawdaw','+7-903-5492969','dadwa@mail.ru','dawd','2011-09-16 14:24:02'),
  (13,'dawdwa','dwad','dwad','dwad','dwadawd','+7-903-5492969','dawd@mail.ru','dawda','2011-09-16 14:41:54'),
  (14,'awdaw','dawd','dwd','dwad','dwadaw','+7-903-5492969','dawdw@mail.ru','dawd','2011-09-16 15:04:23'),
  (15,'adwa','dawdw','dwad','awdaw','dawd','+7-903-5492969','awda@mail.ru','dawddawd','2011-09-16 15:05:06'),
  (16,'awdwad','wwd','fawddawdaw','dawd','awdawd','+7-903-5492969','awdawd@mail.ru','dwadaw','2011-09-16 15:05:47');
COMMIT;

