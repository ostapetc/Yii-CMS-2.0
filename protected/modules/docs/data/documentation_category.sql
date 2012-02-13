CREATE TABLE `documentation` (
  `id`  int(11) UNSIGNED NULL AUTO_INCREMENT ,
  `title`  varchar(250) NULL DEFAULT '' COMMENT 'Название' ,
  `content`  text NULL COMMENT 'Контент',
  `alias`  varchar(250) NULL COMMENT 'Алиас' ,
  `lft`  int(11) NULL ,
  `rgt`  int(11) NULL ,
  `depth`  int(11) NULL ,
  `is_published`  tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT 'Опубликован',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='Категории документации'
;

