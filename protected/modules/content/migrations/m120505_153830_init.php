<?php

class m120505_153830_init extends EDbMigration
{
	public function up()
	{
        $this->execute(file_get_contents(__DIR__.DS.'init.sql'));
        $this->execute(file_get_contents(__DIR__.DS.'init.sql'));
	}

	public function down()
	{
		echo "m120505_153830_init does not support migration down.\n";
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