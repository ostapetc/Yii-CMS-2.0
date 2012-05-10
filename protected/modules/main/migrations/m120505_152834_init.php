<?php

class m120505_152834_init extends EDbMigration
{
	public function up()
	{
//        $this->execute('SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;');
//        $this->execute('SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;');
//        $this->execute('SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="TRADITIONAL";');

        $this->execute(file_get_contents(__DIR__.DS.'init.sql'));

//        $this->execute('SET SQL_MODE=@OLD_SQL_MODE;');
//        $this->execute('SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;');
//        $this->execute('SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;');

    }

	public function down()
	{
		echo "m120505_152834_init does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}