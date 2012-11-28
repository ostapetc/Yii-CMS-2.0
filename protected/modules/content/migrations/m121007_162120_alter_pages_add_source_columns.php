<?php

class m121007_162120_alter_pages_add_source_columns extends DbMigration
{
	public function up()
	{
	    $this->execute("
            ALTER TABLE `pages`
                ADD COLUMN `source` VARCHAR(50) NULL DEFAULT NULL COMMENT 'источник' AFTER `user_id`,
                ADD COLUMN `source_id` VARCHAR(50) NULL DEFAULT NULL COMMENT 'ID источника' AFTER `source`;
	    ");
    }


	public function down()
	{
		echo "m121007_162120_alter_pages_add_source_columns does not support migration down.\n";
		return false;
	}
}