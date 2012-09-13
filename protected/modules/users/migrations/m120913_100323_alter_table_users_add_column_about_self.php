<?php

class m120913_100323_alter_table_users_add_column_about_self extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `users`
	            ADD COLUMN `about_self` TEXT NULL DEFAULT NULL COMMENT 'О себе' AFTER `photo`;
        ");
	}


	public function down()
	{
		echo "m120913_100323_alter_table_users_add_column_about_self does not support migration down.\n";
		return false;
	}
}