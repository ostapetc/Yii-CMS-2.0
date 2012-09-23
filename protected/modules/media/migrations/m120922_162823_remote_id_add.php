<?php

class m120922_162823_remote_id_add extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_files`
                ALTER `name` DROP DEFAULT;
            ALTER TABLE `media_files`
                CHANGE COLUMN `name` `remote_id` VARCHAR(100) NOT NULL COMMENT 'Файл' AFTER `model_id`,
                DROP COLUMN `path`;
        ");
	}

	public function down()
	{
		echo "m120922_162823_remote_id_add does not support migration down.\n";
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