<?php

class m120912_095808_create_media_file extends DbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `file_manager_album`");
        $this->execute("DROP TABLE IF EXISTS `media_albums`");

        $this->execute("CREATE TABLE IF NOT EXISTS `media_albums` (
              `image_id` int(11) NOT NULL AUTO_INCREMENT,
              `model_id` int(11) DEFAULT NULL,
              `type_id` varchar(50) DEFAULT NULL,
              `src` varchar(255) DEFAULT NULL,
              `title` text,
              `descr` text,
              `created` timestamp NULL DEFAULT NULL,
              `sort` int(11) DEFAULT NULL,
              PRIMARY KEY (`image_id`)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8;
        ");

	}

	public function down()
	{
		echo "m120912_095808_create_media_file does not support migration down.\n";
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