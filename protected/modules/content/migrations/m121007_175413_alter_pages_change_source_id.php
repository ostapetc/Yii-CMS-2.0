<?php

class m121007_175413_alter_pages_change_source_id extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `pages`
            	CHANGE COLUMN `source_id` `source_url` VARCHAR(250)
            	    NULL DEFAULT NULL COMMENT 'URL источника' AFTER `source`;"
        );
	}


	public function down()
	{
		echo "m121007_175413_alter_pages_change_source_id does not support migration down.\n";
		return false;
	}
}