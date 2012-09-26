<?php

class m120925_133716_alter_messages_read_not_null extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `messages`
                CHANGE COLUMN `is_read` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Прочитано' AFTER `text`;
        ");
	}

	public function down()
	{
		echo "m120925_133716_alter_messages_read_not_null does not support migration down.\n";
		return false;
	}
}