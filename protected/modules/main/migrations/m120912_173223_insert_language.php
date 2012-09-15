<?php

class m120912_173223_insert_language extends DbMigration
{
	public function up()
	{
        $this->execute("
            INSERT INTO  `languages` (`id`, `name`) VALUES ('ru', 'русский');
        ");
    }


	public function down()
	{
		echo "m120912_173223_insert_language does not support migration down.\n";
		return false;
	}
}