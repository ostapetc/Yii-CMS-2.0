#
# Структура для таблицы `mailer_fields`: 
#

CREATE TABLE `mailer_fields` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Код',
  `name` VARCHAR(200) COLLATE utf8_general_ci NOT NULL COMMENT 'Наименование',
  `value` VARCHAR(250) COLLATE utf8_general_ci NOT NULL COMMENT 'Значение',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `code` USING BTREE (`code`) COMMENT '',
  UNIQUE INDEX `name` USING BTREE (`name`) COMMENT '',
  UNIQUE INDEX `value` USING BTREE (`value`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=11 AVG_ROW_LENGTH=2048 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `mailer_fields` table  (LIMIT -491,500)
#

INSERT INTO `mailer_fields` (`id`, `code`, `name`, `value`) VALUES

  (1,'{FIRST_NAME}','Имя','$user->first_name'),
  (2,'{LAST_NAME}','Фамилия','$user->last_name'),
  (3,'{PATRONYMIC}','Отчество','$user->patronymic'),
  (5,'{DATE}','Текущая дата','date(''d.m.Y'')'),
  (6,'{ROLE}','Наименование группы к которой принадлежит пользователь','$user->role->description'),
  (7,'{APPEAL}','Обращение к пользователю','$user->gender == User::GENDER_MAN ? ''Уважаемый'' : ''Уважаемая'''),
  (9,'{SITE_NAME}','Название сайта','yii_cms'),
  (10,'{ACTIVATE_ACCOUNT_URL}','URL ссылки активации аккаунта','$user->activateAccountUrl();');
COMMIT;

