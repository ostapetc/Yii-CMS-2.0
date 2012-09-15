<?php

class m120912_173456_alter_pages_add_language_fk extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `pages` ADD FOREIGN KEY (`language`) REFERENCES `languages` (`id`)
                ON DELETE CASCADE ON UPDATE CASCADE;
        ");
	}


	public function down()
	{
		echo "m120912_173456_alter_pages_add_language_fk does not support migration down.\n";
		return false;
	}
}