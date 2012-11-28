<?php

class m120912_172859_alter_add_user_fk extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `pages` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                ON DELETE CASCADE ON UPDATE CASCADE ;
        ");
	}


	public function down()
	{
		echo "m120912_172859_alter_add_user_fk does not support migration down.\n";
		return false;
	}
}