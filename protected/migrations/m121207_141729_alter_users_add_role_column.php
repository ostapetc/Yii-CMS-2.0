<?php

class m121207_141729_alter_users_add_role_column extends DbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD COLUMN `role` CHAR(20) DEFAULT 'user' AFTER `status`");
    }


	public function down()
	{
		echo "m121207_141729_alter_users_add_role_column does not support migration down.\n";
		return false;
	}
}