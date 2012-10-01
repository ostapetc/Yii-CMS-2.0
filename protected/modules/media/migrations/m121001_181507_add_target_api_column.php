<?php

class m121001_181507_add_target_api_column extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_files`
            ADD COLUMN `target_api`  varchar(20) NULL;
        ");
	}

	public function down()
	{
		echo "m121001_181507_add_target_api_column does not support migration down.\n";
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