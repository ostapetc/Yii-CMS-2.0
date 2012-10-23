<?php

class m121021_150800_add_date_create extends DbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `media_files`
              ADD COLUMN `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан';
        ");
	}

	public function down()
	{
		echo "m121021_150800_add_date_create does not support migration down.\n";
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