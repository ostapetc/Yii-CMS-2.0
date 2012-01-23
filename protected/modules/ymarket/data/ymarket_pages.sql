#
# Структура для таблицы `ymarket_pages`: 
#

CREATE TABLE `ymarket_pages` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Раздел',
  `url` VARCHAR(500) COLLATE utf8_general_ci NOT NULL COMMENT 'URL',
  `num` INTEGER(11) NOT NULL COMMENT 'Номер',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_parse` DATETIME DEFAULT NULL,
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `section_id` USING BTREE (`section_id`) COMMENT '',
  CONSTRAINT `ymarket_pages_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `ymarket_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=28 AVG_ROW_LENGTH=606 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `ymarket_pages` table  (LIMIT -472,500)
#

INSERT INTO `ymarket_pages` (`id`, `section_id`, `url`, `num`, `date_create`, `date_parse`) VALUES

  (1,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=10-EXC=1-PG=10&amp;greed_mode=false',2,'2011-09-21 15:58:26','2011-09-21 15:58:26'),
  (2,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=20-EXC=1-PG=10&amp;greed_mode=false',3,'2011-09-21 15:58:26','2011-09-21 15:59:18'),
  (3,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=30-EXC=1-PG=10&amp;greed_mode=false',4,'2011-09-21 15:58:26','2011-09-21 15:59:46'),
  (4,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=40-EXC=1-PG=10&amp;greed_mode=false',5,'2011-09-21 15:58:26',NULL),
  (5,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=50-EXC=1-PG=10&amp;greed_mode=false',6,'2011-09-21 15:58:26',NULL),
  (6,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=60-EXC=1-PG=10&amp;greed_mode=false',7,'2011-09-21 15:58:26',NULL),
  (7,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=70-EXC=1-PG=10&amp;greed_mode=false',8,'2011-09-21 15:58:26',NULL),
  (8,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=10-EXC=1-PG=10&amp;greed_mode=false',2,'2011-09-21 15:59:18',NULL),
  (9,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=20-EXC=1-PG=10&amp;greed_mode=false',3,'2011-09-21 15:59:18',NULL),
  (10,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=30-EXC=1-PG=10&amp;greed_mode=false',4,'2011-09-21 15:59:18',NULL),
  (11,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=40-EXC=1-PG=10&amp;greed_mode=false',5,'2011-09-21 15:59:18',NULL),
  (12,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=50-EXC=1-PG=10&amp;greed_mode=false',6,'2011-09-21 15:59:18',NULL),
  (13,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=60-EXC=1-PG=10&amp;greed_mode=false',7,'2011-09-21 15:59:18',NULL),
  (14,1,'/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=70-EXC=1-PG=10&amp;greed_mode=false',8,'2011-09-21 15:59:18',NULL),
  (15,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=10-EXC=1-PG=10&amp;greed_mode=false',2,'2011-09-21 15:59:46',NULL),
  (16,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=20-EXC=1-PG=10&amp;greed_mode=false',3,'2011-09-21 15:59:46',NULL),
  (17,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=30-EXC=1-PG=10&amp;greed_mode=false',4,'2011-09-21 15:59:46',NULL),
  (18,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=40-EXC=1-PG=10&amp;greed_mode=false',5,'2011-09-21 15:59:46',NULL),
  (19,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=50-EXC=1-PG=10&amp;greed_mode=false',6,'2011-09-21 15:59:46',NULL),
  (20,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=60-EXC=1-PG=10&amp;greed_mode=false',7,'2011-09-21 15:59:46',NULL),
  (21,3,'/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=70-EXC=1-PG=10&amp;greed_mode=false',8,'2011-09-21 15:59:46',NULL),
  (22,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-EXC=1-PG=10&amp;greed_mode=false',1,'2011-09-21 17:37:34',NULL),
  (23,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=80-EXC=1-PG=10&amp;greed_mode=false',9,'2011-09-21 17:37:34',NULL),
  (24,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=90-EXC=1-PG=10&amp;greed_mode=false',10,'2011-09-21 17:37:34',NULL),
  (25,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=100-EXC=1-PG=10&amp;greed_mode=false',11,'2011-09-21 17:37:34',NULL),
  (26,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=110-EXC=1-PG=10&amp;greed_mode=false',12,'2011-09-21 17:37:34',NULL),
  (27,2,'/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=120-EXC=1-PG=10&amp;greed_mode=false',13,'2011-09-21 17:37:34',NULL);
COMMIT;

