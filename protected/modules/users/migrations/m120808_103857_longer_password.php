<?php

class m120808_103857_longer_password extends DbMigration
{
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `users`
	          CHANGE COLUMN `password` `password` VARCHAR(60) NOT NULL COMMENT 'Пароль' AFTER `email`;
        ");
	}

	public function safeDown()
	{
		echo "m120808_103857_longer_password does not support migration down.\n";
		return false;
	}

}