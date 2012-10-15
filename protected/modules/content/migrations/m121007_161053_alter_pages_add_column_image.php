<?php

class m121007_161053_alter_pages_add_column_image extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `pages`
                ADD COLUMN `image` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Картинка' AFTER `text`;
        ");
	}


	public function down()
	{
		echo "m121007_161053_alter_pages_add_column_image does not support migration down.\n";
		return false;
	}
}