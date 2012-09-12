<?php

class m120912_100341_create_media_album extends DbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `file_manager`");
        $this->execute("DROP TABLE IF EXISTS `file_manager`");

    }

	public function down()
	{
		echo "m120912_100341_create_media_album does not support migration down.\n";
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