<?php

class m120922_163905_api_name_add extends DbMigration
{
	public function up()
	{
        $this->execute("
          ALTER TABLE `media_files`
            ADD COLUMN `api_name` INT(10) NULL AFTER `type`;
        ");
	}

	public function down()
	{
		echo "m120922_163905_remote_id_add does not support migration down.\n";
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