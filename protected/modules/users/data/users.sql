#
# Структура для таблицы `users`: 
#

CREATE TABLE `users` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) COLLATE utf8_general_ci NOT NULL COMMENT 'Имя',
  `email` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Email',
  `phone` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Мобильный телефон',
  `password` VARCHAR(32) COLLATE utf8_general_ci NOT NULL COMMENT 'Пароль',
  `birthdate` DATE DEFAULT NULL COMMENT 'Дата рождения',
  `gender` ENUM('man','woman') COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Пол',
  `status` ENUM('active','new','blocked') COLLATE utf8_general_ci DEFAULT 'new' COMMENT 'Статус',
  `activate_code` VARCHAR(32) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Код активации',
  `activate_date` DATETIME DEFAULT NULL COMMENT 'Дата активации',
  `password_recover_code` VARCHAR(32) COLLATE utf8_general_ci DEFAULT NULL,
  `password_recover_date` DATETIME DEFAULT NULL,
  `avatar` VARCHAR(50) COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Аватар пользователя',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
  PRIMARY KEY USING BTREE (`id`),
  UNIQUE INDEX `email` USING BTREE (`email`)
)ENGINE=InnoDB
AUTO_INCREMENT=20 AVG_ROW_LENGTH=5461 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;
