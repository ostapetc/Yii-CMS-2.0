<?php

class m120908_185053_create_sports_table extends DbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `sports` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(30) NULL DEFAULT NULL,
                `caption` VARCHAR(30) NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `name` (`name`),
                UNIQUE INDEX `caption` (`caption`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
        ");
	}


	public function down()
	{
        $this->execute("
            DROP TABLE `sports`
        ");
	}
}