<?php

class m121007_173145_alter_pages_drop_url_column extends DbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `pages` DROP COLUMN `url`");
	}


	public function down()
	{
		echo "m121007_173145_alter_pages_drop_url_column does not support migration down.\n";
		return false;
	}
}