<?php

class m120909_191820_rename_albums extends DbMigration
{
	public function up()
	{
        $this->renameTable('image_gallery', 'media_albums');
	}

	public function down()
	{
		echo "m120909_191820_rename_albums does not support migration down.\n";
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