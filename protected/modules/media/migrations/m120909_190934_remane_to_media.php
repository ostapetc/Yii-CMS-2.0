<?php

class m120909_190934_remane_to_media extends DbMigration
{
	public function up()
	{
        $this->renameTable('file_manager', 'media_files');
	}

	public function down()
	{
		echo "m120909_190934_remane_to_media does not support migration down.\n";
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