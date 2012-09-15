<?php

class m120914_133000_add_object_id extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_albums`
            ADD COLUMN `object_id` INT(10) NOT NULL;
        ");
	}

	public function down()
	{
		echo "m120914_133000_add_object_id does not support migration down.\n";
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