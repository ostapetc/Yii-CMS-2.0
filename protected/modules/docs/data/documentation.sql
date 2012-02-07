CREATE TABLE `documentation` (
  `id`  int(11) UNSIGNED NULL AUTO_INCREMENT ,
  `title`  varchar(250) NULL COMMENT 'Название' ,
  `content`  text NULL COMMENT 'Контент' ,
  `is_published`  tinyint(1) UNSIGNED NULL COMMENT 'Опубликован' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='Документация'
;
