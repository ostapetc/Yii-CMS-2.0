#
# Структура для таблицы `mailer_recipients`: 
#

CREATE TABLE `mailer_recipients` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `letter_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Рассылка',
  `user_id` INTEGER(11) UNSIGNED NOT NULL COMMENT 'Пользователь',
  `status` ENUM('accepted','fail','waiting','sent') COLLATE utf8_general_ci DEFAULT 'waiting' COMMENT 'Статус',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `letter_id_2` USING BTREE (`letter_id`, `user_id`) COMMENT '',
   INDEX `letter_id` USING BTREE (`letter_id`) COMMENT '',
   INDEX `user_id` USING BTREE (`user_id`) COMMENT '',
  CONSTRAINT `mailer_recipients_ibfk_1` FOREIGN KEY (`letter_id`) REFERENCES `mailer_letters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mailer_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB
AUTO_INCREMENT=11 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

