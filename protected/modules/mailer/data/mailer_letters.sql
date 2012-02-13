#
# Структура для таблицы `mailer_letters`: 
#

CREATE TABLE `mailer_letters` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_id` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Шаблон',
  `subject` VARCHAR(150) COLLATE utf8_general_ci NOT NULL COMMENT 'Тема письма',
  `text` TEXT COLLATE utf8_general_ci NOT NULL COMMENT 'Текст письма',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
   INDEX `template_id` USING BTREE (`template_id`) COMMENT '',
  CONSTRAINT `mailer_letters_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=6 AVG_ROW_LENGTH=16384 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `mailer_letters` table  (LIMIT -498,500)
#

INSERT INTO `mailer_letters` (`id`, `template_id`, `subject`, `text`, `date_create`) VALUES

  (5,NULL,'Письмо с тегами {SITE_NAME}','{SITE_NAME}  !<br /><br />{APPEAL}  {FIRST_NAME}&nbsp;  {LAST_NAME}  &nbsp;{PATRONYMIC}  .<br /><br />{DATE}&nbsp;  - {ROLE}  <br />Yo  ','2011-09-30 19:18:22');
COMMIT;

