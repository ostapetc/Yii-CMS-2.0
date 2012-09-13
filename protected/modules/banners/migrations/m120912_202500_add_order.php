<?php

class m120912_202500_add_order extends DbMigration
{
	public function up()
	{
        $this->addColumn('banners', 'order', 'int(11) DEFAULT NULL');
	}

	public function down()
	{
		echo "m120912_202500_add_order does not support migration down.\n";
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