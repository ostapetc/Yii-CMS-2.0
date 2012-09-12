<?php

class m120912_103643_set_name_default_value extends DbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users`
          CHANGE COLUMN `name` `name` VARCHAR(40) NULL DEFAULT NULL COMMENT 'Имя';
        ");
	}

	public function down()
	{
		echo "m120912_103643_set_name_default_value does not support migration down.\n";
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