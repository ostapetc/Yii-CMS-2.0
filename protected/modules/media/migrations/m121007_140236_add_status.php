<?php

class m121007_140236_add_status extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_files`
            ADD COLUMN `status`  enum('on_moderate','active','deleted') NULL;
        ");
	}

	public function down()
	{
		echo "m121007_140236_add_status does not support migration down.\n";
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