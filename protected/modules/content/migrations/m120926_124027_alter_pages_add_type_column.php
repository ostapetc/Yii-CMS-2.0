<?php

class m120926_124027_alter_pages_add_type_column extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `pages`
	            ADD COLUMN `type` ENUM('post','forum') NOT NULL DEFAULT 'post' COMMENT 'Тип' AFTER `status`;
        ");
	}


	public function down()
	{
		echo "m120926_124027_alter_pages_add_type_column does not support migration down.\n";
		return false;
	}
}