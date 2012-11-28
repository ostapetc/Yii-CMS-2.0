<?php

class m121124_143109_create_table_fighters extends DbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `fighters` (
                `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `sherdog_id` INTEGER(11) UNSIGNED NOT NULL UNIQUE,
                `name` VARCHAR(100) NOT NULL COMMENT 'Имя',
                `nickname` VARCHAR(100) DEFAULT NULL COMMENT 'Прозвище',
                `birthdate` DATE DEFAULT NULL COMMENT 'Дата рождения',
                `city` VARCHAR(100) DEFAULT NULL COMMENT 'Город',
                `height` FLOAT(9,3) UNSIGNED DEFAULT NULL COMMENT 'Рост',
                `weight` FLOAT(9,3) UNSIGNED DEFAULT NULL COMMENT 'Вес',
                `class` VARCHAR(20) DEFAULT NULL COMMENT 'Класс',
                `association` VARCHAR(100) DEFAULT NULL COMMENT 'Ассоциация',
                `wins` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Победы',
                `losses` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Поражения',
                `win_ko` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Победы KO',
                `win_submissions` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Победы остановкой',
                `win_decisions` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Победы решением',
                `loss_ko` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Поражение KO',
                `loss_submissions` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Поражения остановкой',
                `loss_decisions` INTEGER(11) UNSIGNED DEFAULT NULL COMMENT 'Поражения решением',
                `image` VARCHAR(100) DEFAULT NULL COMMENT 'Фото',
                `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
                `date_update` TIMESTAMP NULL DEFAULT NULL COMMENT 'Обновлен',
                PRIMARY KEY (`id`) COMMENT 'ID'
            ) ENGINE=InnoDB
            AUTO_INCREMENT=0
            CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';
        ");
	}


	public function down()
	{
		echo "m121124_143109_create_table_fighters does not support migration down.\n";
		return false;
	}
}