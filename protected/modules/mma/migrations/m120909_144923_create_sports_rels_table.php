<?php

class m120909_144923_create_sports_rels_table extends DbMigration
{
	public function up()
	{
        $this->execute("
            CREATE TABLE `sports_rels` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `sport_id` INT(11) UNSIGNED NOT NULL,
                `object_id` INT(11) UNSIGNED NOT NULL,
                `model_id` VARCHAR(50) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `sport_id_2` (`sport_id`, `object_id`, `model_id`),
                INDEX `sport_id` (`sport_id`),
                CONSTRAINT `sports_rels_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
        ");
    }


	public function down()
	{
        $this->dropTable('sports_rels');
	}
}