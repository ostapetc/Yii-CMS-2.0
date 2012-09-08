<?php

class m120908_211004_views_table extends DbMigration
{
	public function up()
	{
	    $this->execute("
            CREATE TABLE `views` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) UNSIGNED NOT NULL,
                `object_id` INT(11) UNSIGNED NOT NULL,
                `model_id` VARCHAR(50) NOT NULL,
                `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `user_object_model` (`user_id`, `object_id`, `model_id`),
                INDEX `object_id_model_id` (`object_id`, `model_id`),
                INDEX `user_id` (`user_id`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;
	    ");
    }


	public function down()
	{
        $this->dropTable("views");
	}
}