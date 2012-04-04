CREATE TABLE `example_models` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`first_name` VARCHAR(40) NOT NULL COMMENT 'Имя',
	`last_name` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Фамилия',
	`patronymic` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Отчество',
	`email` VARCHAR(200) NOT NULL COMMENT 'Email',
	`phone` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Мобильный телефон',
	`password` VARCHAR(32) NOT NULL COMMENT 'Пароль',
	`birthdate` DATE NULL DEFAULT NULL COMMENT 'Дата рождения',
	`photo` DATE NULL DEFAULT NULL COMMENT 'Фото',
	`file` DATE NULL DEFAULT NULL COMMENT 'Файл',
	`is_published` TINYINT(4) NULL DEFAULT '0' COMMENT 'Дата рождения',
	`is_active` TINYINT(4) NULL DEFAULT '1' COMMENT 'Дата рождения',
	`gender` ENUM('man','woman') NULL DEFAULT NULL COMMENT 'Пол',
	`status` ENUM('active','new','blocked') NULL DEFAULT 'new' COMMENT 'Статус',
	`activate_code` VARCHAR(32) NULL DEFAULT NULL COMMENT 'Код активации',
	`activate_date` DATETIME NULL DEFAULT NULL COMMENT 'Дата активации',
	`password_recover_code` VARCHAR(32) NULL DEFAULT NULL,
	`password_recover_date` DATETIME NULL DEFAULT NULL,
	`date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `email` (`email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=20;
