#
# Структура для таблицы `mailer_templates_recipients`: 
#

CREATE TABLE `mailer_templates_recipients` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_id` INTEGER(11) UNSIGNED NOT NULL,
  `user_id` INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `template_id_2` USING BTREE (`template_id`, `user_id`) COMMENT '',
   INDEX `template_id` USING BTREE (`template_id`) COMMENT '',
   INDEX `user_id` USING BTREE (`user_id`) COMMENT '',
  CONSTRAINT `mailer_templates_recipients_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mailer_templates_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

