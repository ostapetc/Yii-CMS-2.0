<?php

class m120603_143144_add_albums extends EDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE `file_albums` (
        `id`  int(11) UNSIGNED NULL AUTO_INCREMENT COMMENT 'id' ,
        `title`  varchar(250) NULL COMMENT 'Название' ,
        `descr`  text NULL COMMENT 'Описание' ,
        `status`  enum('deleted','active') NULL COMMENT 'Статус' ,
        `model_id`  varchar(50) NULL ,
        `object_id` varchar(50) NULL ,
        `order`  int(11) UNSIGNED NULL,
        `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
        PRIMARY KEY (`id`),
        INDEX `model_object` (`model_id`, `object_id`)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;
        ");
	}

	public function down()
	{
		echo "m120603_143144_add_albums does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}