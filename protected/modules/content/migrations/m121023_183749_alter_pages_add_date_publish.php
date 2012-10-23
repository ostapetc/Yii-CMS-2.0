<?php

class m121023_183749_alter_pages_add_date_publish extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE  `pages`
                ADD  `date_publish` TIMESTAMP NULL DEFAULT NULL COMMENT  'Опубликовано'
                AFTER  `date_create`
        ");
	}


	public function down()
	{
		echo "m121023_183749_alter_pages_add_date_publish does not support migration down.\n";
		return false;
	}
}