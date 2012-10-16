<?php

class m121016_073001_add_album_status extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_albums`
                ADD COLUMN `status` ENUM('active','deleted') NULL;
        ");
	}

	public function down()
	{
		echo "m121016_073001_add_album_status does not support migration down.\n";
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